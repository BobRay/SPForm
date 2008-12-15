<?php
/**
* This class processes the form on postback
* and redirects to the "Thank You" page
* @package spform
* @author  Bob Ray <bobray@softville.com>
* @created 10/04/2008
* @version 3.0.7
*/

/* error_reporting(E_ALL); */
/*******************************************
File:         spformprocclass.inc.php

Snippet:       SPForm
Version: 3.0.7
$Revision: 208 $
$Author: Bob Ray $
$Date: 2008-11-03 01:44:13 -0600 (Mon, 03 Nov 2008) $
Adapted from:  Many sources but particularly scform by James Seymour and CFFormProtect by Jake Munson
Compatibility: MODX Revolution

*******************************************/

define('CRLF',chr(13) . chr(10));

  /**
   *  This class processes the form after submission.
   *  The two main functions are validate() and send()
   */




class spformproc {
    /**
     * @var array MODx instance passed in the constructor.
     * @access protected
     */
    var $modx;
    /**
     * @var array Array of snippet properties passed in the constructor.
     * @access protected
     */
    var $spfconfig;
    /**
     * @var array Array to hold the recipient's titles and email addresses.
     * @access protected
     */
    var $_whotos = array();
    /**
     * @var array List of error messages for errors that have occurred -- both fatal and non-fatal.
     * @access protected
     */
    var $_errors = array();
    /**
     * @var string Mail header from.
     * @access protected
     */
    var $_from = "";
    /**
     * @var string Mail header from name.
     * @access protected
     */
    var $_fromName = "";
    /**
     * @var string Mail header recipient (addressee).
     * @access protected
     */
    var $_recipient = "";
    /**
     * @var string Mail header message subject.
     * @access protected
     */
    var $_finalSubject = "";
    /**
     * @var string Mail header message content.
     * @access protected
     */
    var $_content = "";

/**
     * @var boolean Should we send an advisory email on errors?
     * @access protected
     */
    var $_advise = false;

    /**
     * @var string Mail header optional additional headers.
     * @access protected
     */
    var $_addlHeaders = array();

    /**
     * PHP4 Constructor
     * @access public
     * @param array $modx MODx object.
     * @param array $spfconfig Array of snippet properties.
     */

    function spformproc($modx, $spfconfig) {
        $this->__construct($spfconfig);
    }
/**
     * PHP5 Constructor
     * @access public
     * @param array $modx MODx object.
     * @param array $spfconfig Array of snippet properties.
     */
    function  __construct($modx, $spfconfig) {
        $this->spfconfig = $spfconfig;
        $this->modx = $modx;

    }


/* **************************************************************
 *                                                              *
 *        This processes the submitted form.            *
 *                                                              *
 * **************************************************************/

 /**
     * Validates the submitted form
     * @access public
     * @return string Returns "validated" on success, something else on failure.
     */

function validate() {

     /* Get the list of valid referes from snippet properties  */

     $referers = explode(",",$this->spfconfig['formProcAllowedReferers']);

     /* Check the referer  Note: bad referer is logged in _check_allowed_referer function if logOnReferer is set */


    if(!$this->_check_allowed_referer($referers, $this->spfconfig['logOnReferer'])) {

        if($this->spfconfig['adviseOnReferer']) {
            $this->_advise = true;

        }

        return($this->_show_fatal($this->_errors));

    }


    /*  Convert recipient list to an array  */
    $this->spfconfig['recipientArray'] = explode(",",$this->spfconfig['recipientArray']);

    foreach ($this->spfconfig['recipientArray'] as $inString) {
        list($key, $value) = explode(':', $inString);
        $this->_whotos[trim($key)] = trim($value);

    }


    /* Convert "whoto" to recipient. */
    foreach($this->_whotos as $key => $value) {

        if($_POST['whoto'] == $key) {
            $this->_recipient = $value;
            break;
        }
    }

    /* No valid recipient?  That's an error. */
    if(empty($this->_recipient)) {
        $this->_errors[] = "\"" . $_POST['whoto'] . "\"".$this->modx->lexicon('bad-destination');
    }

    $banned = false;

       /* Check for banned email addresses and remote hosts */

    if ($this->spfconfig['useBanList']) {
        if($banned = $this->_check_banlist($this->spfconfig['logOnBan'], $_POST['email'])) {

            if($this->spfconfig['adviseOnBan']) {
                $this->_advise = true;
            }
            if($this->spfconfig['warnBanned'] || $this->spfconfig['warnAll']) {
                return($this->_show_fatal($this->_errors));

                exit;
            } else {
                unset($this->_errors);        /* Make it look as if all's well */
                return("");
            }
        }
    }


    /* These will apply only if JS is turned off.
     * If it's on, these errors will be caught before the form is submitted.
     * An exception is certain errors in the email address because we do
     * more thourough testing here.
     *  */

    /* Gave an email address?  It's an error if not--unless we allow no email address. */
    if(empty($_POST['email'])) {
        /* if $requireEmail is not set, we default to "true".*/
        if(!isset($this->spfconfig['requireEmail']) || $this->spfconfig['requireEmail']) {
            $this->_errors[] = $this->modx->lexicon('no-email');
        }
    /* Valid-looking email address?  (regex borrowed from eForm) */


    } elseif(!preg_match('/^(?:[a-z0-9+_-]+?\.)*?[a-z0-9_+-]+?@(?:[a-z0-9_-]+?\.)*?[a-z0-9_-]+?\.[a-z0-9]{2,5}$/i', $_POST['email'])) {
        $this->_errors[] = "\"" . $_POST['email'] .
            "\"".$this->modx->lexicon('bad-email');
    }


     /* Check for name?  */
    if($this->spfconfig['requireName'] && empty($_POST['name'])) {
         $this->_errors[] = $this->modx->lexicon('no-name');
    }

    /* Check for subject?  */
    if($this->spfconfig['requireSubject'] && empty($_POST['subject'])) {
         $this->_errors[] = $this->modx->lexicon('no-subject');
    }

     /* Comments?  What's the point, if not?  */
    if(empty($_POST['comments'])) {
         $this->_errors[] = $this->modx->lexicon('no-comments');
    }


/*   End of non JS section  */

/* See if the user made the error of filling in the hidden field  */

    if($this->spfconfig['useHiddenField']) {

        if(!(empty($_POST['Last__Name']))) {  /* probable spammer filled the hidden field */
            if ($this->spfconfig['logOnHidden']) {
                error_log($this->modx->lexicon('last-name'));
            }
            if ($this->spfconfig['warnHiddenField'] || $this->spfconfig['warnAll']) {
                $this->_errors[] = $this->modx->lexicon('last-name');
            } else {
                exit; /* die quietly  */
            }
        }
    }

/*  If we're requiring the keyboard and/or mouse, make sure they were used  */

    if ($this->spfconfig['requireKeyboard'] || $this->spfconfig['requireMouseOrKeyboard']) {  /* get number of keys pressed  */
        $keysUsed = $_POST['keyCount'];
    }

    if ($this->spfconfig['requireMouse'] || $this->spfconfig['requireMouseOrKeyboard']) {   /* get mouse movement number  */
        $mouseMove = $_POST['mouseTravel'];
    }

    if ($this->spfconfig['requireMouseOrKeyboard']) {
        if (($mouseMove < 5)&&($keysUsed < 5)) {
            if ($this->spfconfig['logMouseAndKeyboardErrors']) {
                error_log($this->modx->lexicon("mouse-kb-warning"));
            }
            if ($this->spfconfig['warnMouseAndKeyboard'] || $this->spfconfig['warnAll']) {
                $this->_errors[] = $this->modx->lexicon('mouse-kb-warning');
            } else {
                exit();
            }
        }

    } else {
        if ($this->spfconfig['requireKeyboard']) {     /* Make sure the keyboard was used  */
            if ($keysUsed < 5) {
                if ($this->spfconfig['logMouseAndKeyboardErrors']) {
                    error_log($this->modx->lexicon("kb-warning"));
                }
                if ($this->spfconfig['warnMouseAndKeyboard'] || $this->spfconfig['warnAll']) {
                    $this->_errors[] = $this->modx->lexicon('kb-warning');
                } else {
                    exit();
                }
            }
        }

        if ($this->spfconfig['requireMouse']) {   /* Make sure the mouse was used  */

            if ($mouseMove < 5) {

                if ($this->spfconfig['logMouseAndKeyboardErrors']) {
                    error_log($this->modx->lexicon("mouse-warning"));
                }
                if ($this->spfconfig['warnMouseAndKeyboard'] || $this->spfconfig['warnAll']) {
                    $this->_errors[] = $this->modx->lexicon('mouse-warning');
                } else {
                    exit();
                }
            }
        }
    }

/*    If we're using the timer, make sure there wasn't a timing violation  */

    if($this->spfconfig['useTimer']) {

        if(!(empty($_POST['tmStart']))) {  /* start time for form  */
            $currentTime = time();
            $startTime = $_POST['tmStart'];
            $startTime -= $this->spfconfig['timerOffset']; /* deobfuscate time  */
            $elapsedTime = $currentTime - $startTime;
            if (($elapsedTime < $this->spfconfig['useTimerMin']) || ($elapsedTime > $this->spfconfig['useTimerMax'])) {   /* Timer violation  */
                if ($this->spfconfig['logTimer']) {
                    error_log($this->modx->lexicon('timer-violation'));
                }
                if ($this->spfconfig['warnTimer'] || $this->spfconfig['warnAll']) {
                     $this->_errors[] = $this->modx->lexicon('timeout1');
                } else {
                    exit;
                }
            }

        } else {
            $this->_errors[] = $this->modx->lexicon('no-time'); /* POST is missing start time and $useTimer=true  */
        }
    }


    /* If CAPTCHA is turned on, check the verification string  */
    if($this->spfconfig['requireVerify']) {

        if($_SESSION['veriword'] !=  $_POST['verify']) {
           /* echo "Session: " . $_SESSION['veriword'] . '<br />';
            echo "Post: " . $_POST['verify'] . '<br />';
            die(); */
            if($this->spfconfig['logOnVerify']) {
                error_log("[" . $scriptName . "]" . $this->modx->lexicon('bad-verification') . $_SERVER['REMOTE_ADDR'], 0);
            }
            if($this->spfconfig['adviseOnVerify']) {
                $this->_advise = true;
            }
            if ($this->spfconfig['warnVerify'] || $this->spfconfig['warnAll']) {
               $this->_errors[] = $this->modx->lexicon('bad-verification');
            } else {
                exit;  /* if not warning, die quietly with no error message */
            }


        }
    }

    /* if there were errors already , print out an error page and bail out
     * before doing any more work  */

    if(count($this->_errors)) {
        return($this->_show_errors($this->_errors));
    }


    if(!empty($_POST['name'])) {
        $this->_content = $_POST['name'] .' '.$this->modx->lexicon('wrote');
        $this->_fromName = $_POST['name'];
    }
    $this->_content .= preg_replace('/\r/', '', stripslashes($_POST['comments']));

    if (!empty($_POST['email'])) {
        $this->_from = $_POST['email'];
        $this->_addlHeaders[] = "Reply-To: " . $_POST['email'];
    }

    $this->_addlHeaders[] = $this->_generate_additional_headers();

    /* Additional recipients?  */
    if(!empty($this->spfconfig['mailAlso'])) {
        $this->_addlHeaders[] = "Cc: " . $this->spfconfig['mailAlso'] . "\n";
    }

    /* Subject line  */
    if(empty($_POST['subject'])) {  /* no subject from users, use the default subject */
        $this->_finalSubject = $this->spfconfig['dfltSubj'];
    } else {                       /* if addSubjSig is set, use default subjects as a prefix */
        if($this->spfconfig['addSubjSig']) {
            $this->_finalSubject = "[". $this->spfconfig['dfltSubj'] . "] ";
        }
        $this->_finalSubject .= addcslashes(stripslashes($_POST['subject']), "\x00..\x1f");
    }


     /* check for email injections, logical email address and overlong fields  */

    if (! preg_match("/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i", $this->_recipient, $result)) {

        if ($this->spfconfig['logInjections']) {
            error_log($this->modx->lexicon('bad-recipient') . $this->_recipient);
        }
        if ($this->spfconfig['warnInjections'] || $this->spfconfig['warnAll']) {
            $this->_errors[] = $this->modx->lexicon('bad-recipient');
        } else {
            exit;  /* die quietly with no warning */
        }
    }

    /*    Make sure the recipient field isn't too long   */

    if (strlen($this->_recipient) > $this->spfconfig['maxRecipientLen']) {

        if ($this->spfconfig['logRecipientLen']) {
            error_log($this->modx->lexicon('bad-recipient-length'));
        }
        if ($this->spfconfig['warnRecipientLen'] || $this->spfconfig['warnAll'] ) {
            $this->_errors[] = $this->modx->lexicon('bad-recipient-length');
        } else {
            exit; /* die quietly with no warning */
        }
    }
    /*    Make sure the subject  field isn't too long   */
    if (strlen($this->_finalSubject) > $this->spfconfig['maxSubjectLen']) {
        if ($this->spfconfig['logSubjectLen']) {
            error_log($this->modx->lexicon('bad-subject-length'));
        }
        if ($this->spfconfig['warnSubjectLen'] || $this->spfconfig['warnAll']) {
            $this->_errors[] = $this->modx->lexicon('bad-subject-length');
        } else {
            exit; /* die quietly with no warning */
        }
    }

/*    Check for illegal content in subject field  */
    if(stristr($this->_finalSubject, "Bcc:") or stristr($this->_finalSubject, "cc:") or stristr($this->_finalSubject, "to:")) {

        if ($this->spfconfig['logIllegalSubject']) {
            error_log($this->modx->lexicon('illegal-subject' . $this->_finalSubject));
        }
        if ($this->spfconfig['warnIllegalSubject'] || $this->spfconfig['warnAll']) {
            $this->_errors[] = $this->modx->lexicon('illegal-subject');
        } else {
            exit; /* die quietly with no warning */
        }
    }

/*    Check for illegal content in Content field   */
    if(stristr($this->_content, "Bcc:") or stristr($this->_content, "cc:") or stristr($this->_content, "to:")) {
        if ($this->spfconfig['logIllegalContent'] ){
            error_log($this->modx->lexicon('illegal-message') . $this->_content);
        }
        if ($this->spfconfig['warnIllegalContent'] || $this->spfconfig['warnAll']) {
            $this->_errors[] = $this->modx->lexicon('illegal-message');

        } else {
            exit; /* die quietly with no warning */
        }
    }

/*    Make sure there aren't too many http links in the content  */
    $linkCount = substr_count($this->_content,'http');  /* count links in content */
    if ($linkCount > $maxLinks) {
         if ($this->spfconfig['logMaxLinks'] ) {
            error_log($this->modx->lexicon('content-links') . $linkCount);
         }
         if ($this->spfconfig['warnMaxLinks'] || $this->spfconfig['warnAll']) {
            $this->_errors[] = $this->modx->lexicon('content-links');
         } else {
            exit; /* die quietly with no warning */
         }
    }

    /* final error check before mailing */

    if(count($this->_errors)) {
        return($this->_show_errors($this->_errors));
    } else {
        return("validated");
    }

}
    /** This method will send the mail (by calling _my_mail() )
     *   if no errors have been encountered.
     *   It has no return. _my_mail() exits if unsuccessful.
     *   If _my_mail succeeds in sending, the user ends up back
     *   here and is forwarded to the response page.
     *   @access public
     */

function send() {
    $this->_my_mail($this->_from, $this->_fromName, $this->_recipient, $this->_finalSubject, $this->_content, $this->_addlHeaders);




    $responseURL = $this->modx->makeUrl($this->spfconfig['spfResponseID'],'','','full'); /* $spfResponseID is set in the config file */

    if ($this->spfconfig['spfDebug']) {
        echo "ResponseURL: ".$responseURL.'<br>';
    }


    $this->modx->sendRedirect($responseURL,0);

}

 /*

   The original code for this snippet was written by James Seymour as
   scform.php. I've made extensive modifications to the code, but much of
   Jim's original code remains.

   Some changes were to integrate the package with MODx. Others were (hopefully)
   improvements I found in various other contact forms. I've also changed
   some of the original defaults and added some parameters.

   If the form works for you, James deserves most of the credit. If it doesn't,
   I probably deserve most of the blame. Please don't ask Jim for help with the
   snippet. As far as I know, he is not MODx-aware. I have left his GPL statement
   below  -- Bob Ray


   **********************************************************
   scform.php - Web page form for Simple Contact Form package
   Copyright (C) 2002-2004 by James S. Seymour (jseymour [at] LinxNet [dot] com)
   (See "License", below.)  Release 1.2.5.

   License:
      This program is free software; you can redistribute it and/or
      modify it under the terms of the GNU General Public License
      as published by the Free Software Foundation; either version 2
      of the License, or (at your option) any later version.

      This program is distributed in the hope that it will be useful,
      but WITHOUT ANY WARRANTY; without even the implied warranty of
      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
      GNU General Public License for more details.

      You may have received a copy of the GNU General Public License
      along with this program; if not, write to the Free Software
      Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307,
      USA.

      An on-line copy of the GNU General Public License can be found
      http://www.fsf.org/copyleft/gpl.html.

*/


/* The following functions are only used internally  */


  /** Actually send the mail.  Also used by _mail_advisory()
   *  @access protected
   *  @param string $from Mail header "from" and "sender".
   *  @param string $fromName Mail header "fromName".
   *  @param string $recipient Mail header "to" (addressee).
   *  @param string $finalSubject Mail header "subject".
   *  @param string $content Mail header "body".
   *  @param string $addlHEaders Mail header optional "addlHEaders".
   * */

function _my_mail($from, $fromName, $recipient, $finalSubject, $content, $addlHeaders) {

    if ($this->spfconfig['test_mode']) {
        return;
    }
    if ( ! $this->modx->getService('mail', 'mail.modPHPMailer')) {
        die($this->modx->lexicon('could-not-initiate-mail-service'));
    }

    $this->modx->mail->set(MODX_MAIL_CHARSET,$this->modx->config['modx_charset']);
    $this->modx->mail->set(MODX_MAIL_BODY, $content);
    $this->modx->mail->set(MODX_MAIL_FROM, $from);
    $this->modx->mail->set(MODX_MAIL_FROM_NAME, $fromName);
    $this->modx->mail->set(MODX_MAIL_SENDER, $from);
    $this->modx->mail->set(MODX_MAIL_SUBJECT, $finalSubject);
    $this->modx->mail->address('to', $recipient);
    foreach($this->_addlHeaders as $value) {
        /*  MS-Win mail servers want crlf and *don't* want a trailing pair
         *  necessary only for addl headers */
        if(PHP_OS == "WIN32" || PHP_OS == "WINNT") {
            $$value = preg_replace("/\n$/", "", $$value);
            $$value = preg_replace("/\n/", "\r\n", $$value);
        }
        $this->modx->mail->header($value);
    }


    if ($this->spfconfig['spfUseSMTP']) {
        $this->modx->mail->set(MODX_MAIL_ENGINE, 'smtp');
        $this->modx->mail->set(MODX_MAIL_SMTP_AUTH, true);
        $this->modx->mail->set(MODX_MAIL_SMTP_HOSTS, $this->spfconfig['spfSMTP_Host']);


        $this->modx->mail->set(MODX_MAIL_SMTP_PASS, $this->spfconfig['spfSMTP_Password']);

        $this->modx->mail->set(MODX_MAIL_SMTP_PORT, $this->spfconfig['spfSMTP_Port']);

        $this->modx->mail->set(MODX_MAIL_SMTP_USER, $this->spfconfig['spfSMTP_UserName']);

    }

    if (!$this->modx->mail->send()) {
        /* if debug is on, resend with error reporting */
        if($this->spfconfig['debug']) {
            echo "<b>SMTP errors:</b><br />";
            $this->modx->mail->mailer->SMTPDebug = 2;
            $this->modx->mail->send();
            echo '<br /><br /><b>' . "Mailer ErrorInfo:</b><br />";
            die($this->modx->mail->mailer->ErrorInfo);
        }

        die('<b>' . $this->modx->lexicon('mail-failure') . '</b>');

    }
    $this->modx->mail->reset();

}

/** Function is shared by the _show_errors() and _show_fatal() functions,
*   to emit the list of problems as <li> items.  (Note: Assumes <ul> is set in the
*   Tpl chunk. Also assumes HTML "opening" stuff has been done by MODx.
*   @access protected
*   @param array $errors  Array of error messages for errors that have occurred.
*   @return string Returns the processed contents of the spformprocTPL chunk
*/

function _show_error_list($errors) {

    $nerrors = count($errors);
    $output = "";

    for($i = 0; $i < $nerrors; $i++)
    $output .= '<li class = "spf_error">' . $errors[$i] . "</li>\n";
    $this->modx->setPlaceholder('spf-errors',$output);
    $output = $this->modx->getChunk($this->spfconfig['spformprocTpl']);
    return($output);


}

/**
* Show list of non-fatal errors (if any).
* Sets the approprate placeholders for the non-fatal error list.
*
* @access protected
* @param array $errors  Array of error messages for errors that have occurred.
* @return string Returns the result of _show_error_list()
*/
function _show_errors($errors) {


    $this->modx->setPlaceholder('spf-error-header', $this->modx->lexicon('form-errors') );
    $this->modx->setPlaceholder('spf-error-footer', "" );



    $this->modx->setPlaceholder('spf-error-back-button','<br><input type="button" value="Back" onclick="history.back(1)">');

    if ($this->spfconfig['adviseAll'] || $this->_advise) {
        $this->_mail_advisory($errors);
    }
    return($this->_show_error_list($errors));
}

/**
* Show list of fatal errors (if any).
* Sets the approprate placeholders for the non-fatal error list.
* @access protected
* @param array $errors  Array of error messages for errors that have occurred.
* @return string Returns the result of _show_error_list()

*/
function _show_fatal($errors) {

    $this->modx->setPlaceholder('spf-error-header',$this->modx->lexicon('fatal1'));
    $this->modx->setPlaceholder('spf-error-footer', $this->modx->lexicon('fatal2'));
    $this->modx->setPlaceholder('spf-error-back-button','<br><input type="button" value="Back" onclick="history.back(1)">');

    if ($this->spfconfig['adviseAll'] || $this->_advise) {
        $this->_mail_advisory($errors);
    }

    return($this->_show_error_list($errors));
}


/**
* Check the referer against the list of acceptable refererers.
* If the $referers array is empty, returns true/pass by default.
* @access protected
* @param mixed $referers
* @param mixed $logOnReferer
* @return boolean True on success
*/
function _check_allowed_referer($referers, $logOnReferer) {

    global $scriptName, $formProcBlankRefOkay;


    $found = true;   /* Default to "pass" */

    /* Check only if the array of allowed referers is non-empty or if the HTTP
     REFERER is empty and we're allowing that */

    if(!(empty($_SERVER['HTTP_REFERER']) && $formProcBlankRefOkay)) {
    if(count($referers)) {
        $found = false;

        if(!empty($_SERVER['HTTP_REFERER'])) {
            list($referer) =
                array_slice(explode("/", $_SERVER['HTTP_REFERER']), 2, 1);
            for($x = 0; $x < count($referers); ++$x) {
                if(eregi($referers[$x], $referer)) {
                $found = true;
                break;
                }
            }
        }

        if(!$found) {
            $this->_errors[] = $this->modx->lexicon('unauthorized-server') ."(" .
                    $_SERVER['HTTP_REFERER'] . ")";
            if($this->spfconfig['logOnReferer']) {
                error_log("[" . $scriptName . "] " . " Illegal Referer. (" .
                       $_SERVER['HTTP_REFERER'] . ") ", 0);
            }
        }
    }
    }

    return $found;
}

    /**
    * Function to check an IP address match.
    * Used by _check_banlist.
    * Handles CIDR notation in the thing to check against
    * Note: Address to check against is expected to be in regexp format
    * (i.e.: "."s escaped with "\"s)
    *
    * @access protected
    * @param array $chkAgainst  banned addresses
    * @param string $chkAddr Address to check
    * @return boolean True on success
    */
    function _check_ip($chkAgainst, $chkAddr) {

        $addrMatch = false;    /* Assume no match */

        /* If the "check against" value contains a "/", it'll be an IP
         address (range) in CIDR notation. */

        if(ereg('/[0-9]', $chkAgainst)) {

        /* Break down dot.ted.qu.ad/bits of address to check against */
        list($addrBase, $hostBits) = explode('/', $chkAgainst);
        list($w, $x, $y, $z) = explode('.', $addrBase);

        /* Convert to high and low address ints */
        $chkAgainst = ($w << 24) + ($x << 16) + ($y << 8) + $z;
        $mask = $hostBits == 0? 0 : (~0 << (32 - $hostBits));
        $lowLimit = $chkAgainst & $mask;
        $highLimit = $chkAgainst | (~$mask & 0xffffffff);

        /* Convert addr to check to int */
        list($w, $x, $y, $z) = explode('.', $chkAddr);
        $chkAddr = ($w << 24) + ($x << 16) + ($y << 8) + $z;

        $addrMatch = (($chkAddr >= $lowLimit) && ($chkAddr <= $highLimit));

        } else {
        $addrMatch = ereg("^$chkAgainst", $chkAddr);
        }

        return $addrMatch;
    }

    /**
    * Function to check the given email address, the remote host (if
    * available) and the remote IP against the ban list.
    *
    * @access protected
    * @param boolean $logOnBan Are we logging banned attempts
    * @param string $email User's email address
    * @return boolean True if user is banned
    */
    function _check_banlist($logOnBan, $email) {

        global $scriptName;



        $banListFile = $this->spfconfig['spformPath'] . 'banlist.inc.php';

        /* Get the banList */
        if($fp = fopen($banListFile, "r")) {
            while($inString = $this->_read_file_line($fp))
                $banList[] = $inString;
            fclose($fp);
        } else {
            echo "banListFile = " . $banListFile;
            die("<br>Couldn't open banlist");
        }

        $notAllowed = false;    /* Default to allowed */

        if(count($banList)) {
            $emailFix = trim(strtolower($email));
            $remoteHostFix = trim(strtolower($_SERVER['REMOTE_HOST']));

            foreach($banList as $banned) {
                $banFix = trim(strtolower(ereg_replace('\.', '\\.', $banned)));
                if(strstr($banFix, "@")) {            /* email address? */
                    if(ereg('^@', $banFix)) {        /* Any user @host? */
                        /* Expand the match expression to catch hosts and sub-domains  */
                        $banFix = ereg_replace('^@', '[@\\.]', $banFix);
                        if(($notAllowed = ereg("$banFix$", $emailFix))) {
                            $bannedOn = $emailFix;
                            break;
                        }
                    } elseif(ereg('@$', $banFix)) {    /* User at any host? */
                        if(($notAllowed = ereg("^$banFix", $emailFix))) {
                            $bannedOn = $emailFix;
                            break;
                        }
                    } else {                /* User@host*/
                        if(($notAllowed = (strtolower($banned) == $emailFix))) {
                            $bannedOn = $emailFix;
                            break;
                        }
                    }
                } elseif(preg_match('/^\d{1,3}(\\\.\d{1,3}){0,3}(\/\d{1,2})?$/',
                                    $banFix)) {
                    /* IP address  */
                    if($notAllowed = $this->_check_ip($banFix, $_SERVER['REMOTE_ADDR'])) {
                        $bannedOn = $_SERVER['REMOTE_ADDR'];
                        break;
                    }

                    /* If the client is working through a proxy...*/
                    if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        if($notAllowed =
                            $this->_check_ip($banFix, $_SERVER['HTTP_X_FORWARDED_FOR']))
                        {
                        $bannedOn = $_SERVER['HTTP_X_FORWARDED_FOR'];
                        break;
                        }
                    }

                } else {                /* Must be a host/domain name  */
                    if(($notAllowed = ereg("$banFix$", $remoteHostFix))) {
                        $bannedOn = $remoteHostFix;
                        break;
                    }
                }
            }
        }

        if($notAllowed) {
            $this->_errors[] = $this->modx->lexicon('banned'). $bannedOn;
            if($this->spfconfig['logOnBan']) {
                error_log("[" . $scriptName . "]" . '  Banned on "' . $bannedOn . '"');
            }
        }

        return $notAllowed;
    }

    /**
    * Create list of additional headers to be added to message.
    * Adds them to $this->_addlHeaders array.
    * No return value.
    *
    * @access protected
    */
    function _generate_additional_headers() {




            /* Remote host/address/user reporting? */
        if($this->spfconfig['reportRemoteHost'] && !empty($_SERVER['REMOTE_HOST'])) {
            $this->_addlHeaders[] = "X-Remote-Host: " . $_SERVER['REMOTE_HOST'] . "\n";
        }
        if($this->spfconfig['reportRemoteAddr']) {
            if(!empty($_SERVER['REMOTE_ADDR'])) {
                $this->_addlHeaders[] = "X-Remote-Address: " . $_SERVER['REMOTE_ADDR'] . "\n";
            }

            /* If the client is working through a proxy... */
            if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                $this->_addlHeaders[] = "X-Http-X-Forwarded-For: " .
                         $_SERVER['HTTP_X_FORWARDED_FOR'] . "\n";
            }

        }
        if($this->spfconfig['reportRemoteUser'] && !empty($_SERVER['REMOTE_USER'])) {
            $this->_addlHeaders[] = "X-Remote-User: " . $_SERVER['REMOTE_USER'] . "\n";
        }

        if($this->spfconfig['reportRemoteIdent'] && !empty($_SERVER['REMOTE_IDENT'])) {
            $this->_addlHeaders[] = "X-Remote-Ident: " . $_SERVER['REMOTE_IDENT'] . "\n";
        }
        if($this->spfconfig['reportOrigReferer'] && !empty($_POST['orig_referer'])) {
            $this->_addlHeaders[] = "X-SPForm-Referer: " . $_POST['orig_referer'] . "\n";
        }

    }


    /**
    * Mails an advisory message to  the "errorsTo" address
    *
    * @param array $errors  Array of error messages for errors that have occurred
    */
    function _mail_advisory($errors) {


        $finalSubject = "";

        if(!empty($this->spfconfig['errorsTo'])) {
            if($this->spfconfig['addSubjSig']) {
                $finalSubject = "[" .  $this->spfconfig['dfltSubj'] . "] ";
            }

            $finalSubject .= $this->modx->lexicon('form-problem');

            $content = $this->modx->lexicon('form-problem-content') . CRLF;

            $nerrors = count($errors);

            for($i = 0; $i < $nerrors; $i++) {
                $content .= "    . " . $errors[$i] . "\n";
            }
            $senderEmail = $_POST['email'];
            $content .= "\n\nFrom: " . $senderEmail;

            $this->_addlHeaders[] = "X-purported_from_Address: " . $senderEmail . "\n";
            $addlHeaders = $this->_generate_additional_headers();
            $site = $this->modx->config['site_name'];

            $this->_my_mail($this->spfconfig['errorsTo'],$site,$this->spfconfig['errorsTo'],$finalSubject,$content,$this->_addlHeaders);


        }
    }

   /**
    * Read a line from a file, stripping comments and blank lines.
    * Used by _check_banlist
    *
    * @param mixed $fp  file pointer to open file
    * @return string Line from file.
    */

    function _read_file_line($fp) {
        while(($inString = fgets($fp, 2048)) != false) {
        $inString = rtrim(preg_replace('/\s*#.*/', '', $inString));
        if(!empty($inString))
            break;
        }

        return $inString;
    }

}

?>
