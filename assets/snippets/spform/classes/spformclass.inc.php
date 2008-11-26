<?php


/**  This class is instantiated on the first request to the page.
*    It does some preliminary checks, then renders the form.
*    @package spform
*    @author  Bob Ray <bobray@softville.com>
*    @created 10/04/2008
*    @version 3.0.6  */

class spform {
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
     * PHP4 Constructor
     * @access public
     * @param array $modx MODx object.
     * @param array $spfconfig Array of snippet properties.
     */
    function spform($modx, $spfconfig) {
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


/**
* Inserts the javascript code to validate the form.
* The inserted code is customized based on various snippet
* properties.
* @access public.
*/
function register_js() {



    /* javascript validation */
    $inFile = MODX_ASSETS_URL . "snippets/spform/js/emailcheck.js";

    $this->modx->regClientStartupScript($inFile);

    $src = '<script type="text/javascript"> ';
    $src .= ' /* <![CDATA[ */ ';
    $src .= 'var requireName = ';
    $this->spfconfig["requireName"]? $src .= "true; " : $src .= "false; ";

    $src .= 'var requireEmail = ';
    $this->spfconfig["requireEmail"]? $src .= "true; " : $src .= "false; ";

    $src .= 'var requireSubject = ';
    $this->spfconfig["requireSubject"]? $src .= "true; " : $src .= "false; ";


    $src .= 'function checkform (form) { ';

        $src .= 'if (requireName == true) { ';
            $src .= 'if (form.name.value == "") { ';
                $src .= 'alert( "Please enter your name" ); ';
                $src .= 'form.name.focus(); ';
                $src .= 'return false; ';
            $src .= '} ';
        $src .= '} ';

        $src .= 'if (requireEmail == true) { ';
            $src .= 'if (form.email.value.length == "") { ';
                $src .= 'alert( "Please enter your email" ); ';
                $src .= 'form.email.focus(); ';
                $src .= 'return false; ';
            $src .= '} ';

            $src .= 'if(emailCheck(form.email.value) == false) { ';
                $src .= 'alert("' . $this->modx->lexicon('bad-email') . '"); ';
                $src .= 'form.email.focus(); ';
                $src .= 'return false; ';
            $src .= ' } ';

        $src .= '} ';

        $src .= 'if (requireSubject == true) { ';
            $src .= 'if (form.subject.value == "") { ';
                $src .= 'alert( "Please enter a subject" ); ';
                $src .= 'form.subject.focus(); ';
                $src .= 'return false; ';
            $src .= '} ';
        $src .= '} ';

         $src .= 'if (form.comments.value == "") { ';
            $src .= 'alert( "Please enter a comment" ); ';
            $src .= 'form.comments.focus(); ';
            $src .= 'return false; ';
         $src .= '} ';

    $src .= '} ';

    $src .= ' /* ]]> */ ';
    $src .= '</script> ';

    $this->modx->regClientStartupScript($src);

}


/** Web form spammers frequently either leave HTTP_REFERER empty, set it
*   equal to the form's own URL, or make something up out of thin air.
*   We don't do this "is it our own server" if it's blank, as the "is it
*   blank" check will get that one. This check does nothing unless the appropriate
*   properties are set.  No return value, aborts on illegal referer.
*   @access public
*/
function check_referer() {



    $selfChkStr = $_SERVER['PHP_SELF'];
    $serverChkStr = "http://" . $_SERVER['SERVER_NAME'];

    $referer = $_SERVER['HTTP_REFERER'];



    if(($this->spfconfig['chkFormRefNotBlank'] && !$_SERVER['HTTP_REFERER']) ||
       ($this->spfconfig['chkFormRefNotSelf'] && preg_match("#$selfChkStr$#i", $_SERVER['HTTP_REFERER'])) ||
       ($this->spfconfig['chkFormRefOwnServer'] && $_SERVER['HTTP_REFERER'] &&
        !preg_match("#^$serverChkStr#i", $referer)))
    {
        /* Almost certainly web form spammers "terminate" the page early)*/

        print('<div align="center">'.$this->modx->lexicon('bad-referer').' "'.
            $_SERVER['HTTP_REFERER'] .'"</div>');
        print("</body></html>");
        exit;
    }

}

/**  Get ready to render the form and set all placeholders
 *  @access public
 */

function set_placeholders () {


/*  Create CAPTCHA image URL for use later if requireVerify is true  */

        if($this->spfconfig['requireVerify']) {

            $verifyUrl=MODX_ASSETS_URL.'captcha/captcha.php';
            $this->modx->setPlaceholder('spf-cookie-message','<div class="spf_cookie_msg">('.$this->modx->lexicon('cookies-required').')</div>');
            $this->modx->lexicon->load('captcha:default');

            if ($this->spfconfig['spfDebug']) {
                echo "<b>Verify URL:</b><br />".$verifyUrl."<br />";
            }
        } else {
            $this->modx->setPlaceholder('spf-cookie-message',"");
        }



      /* Send the keycount value if we're requiring the mouse and/or keyboard */
    if ($this->spfconfig['requireKeyboard'] || $this->spfconfig['requireMouseOrKeyboard']) {
        if( false == ($str = file_get_contents($this->spfconfig['spformPath'] . "js/usedkeyboard.js"))) {
            $val = $this->modx->lexicon('no-js') . $this->spfconfig['spformPath'] . "js/usedkeyboard.js";
            die($val);
        } else {
            $val = '<input type="hidden" name="keyCount" id="keyCount" value="" />';
            $val .= '<script type="text/javascript">';
            $val .= ' /* <![CDATA[ */ ';
            $val .= $str;
            $val .= ' /* ]]>  */ ';
            $val .= '</script>';
            $this->modx->setPlaceholder('spf-use-mouse-or-keyboard1',$val);
        }
    } else {
        $this->modx->setPlaceholder('spf-use-mouse-or-keyboard1',"");
    }

    /* send the mouse movement value */
    if ($this->spfconfig['requireMouse'] || $this->spfconfig['requireMouseOrKeyboard']) {


       if( false == ($str = file_get_contents($this->spfconfig['spformPath'] . "js/mousemovement.js"))) {
            $val = $this->modx->lexicon('no-js') . $this->spfconfig['spformPath'] . "js/mousemovement.js";
            die($val);
        } else {
            $val =  '<input type="hidden" name="mouseTravel" id="mouseTravel" value="" />';
            $val .= '<script type="text/javascript">';
            $val .= ' /* <![CDATA[ */ ';
            $val .= $str;
            $val .= ' /* ]]>  */ ';
            $val .= '</script>';
            $this->modx->setPlaceholder('spf-use-mouse-or-keyboard2',$val);
        }
    } else {
        $this->modx->setPlaceholder('spf-use-mouse-or-keyboard2',"");
    }

    /*  Add hidden field to output if $useHiddenField == true.
     * Double underscore in input variable name should prevent autofill by Firefox and RoboForm
     */
    if($this->spfconfig['useHiddenField']) {
        $val = '<div class="spform_input">';
        $val .= $this->modx->lexicon('hidden-last-name').': ' . '<input type="text" name="Last__Name" size="30" /></div>';
        $this->modx->setPlaceholder('spf-use-hidden-field',$val);
    } else {
        $this->modx->setPlaceholder('spf-use-hidden-field',"");
    }

    /*  Set timer variables, if using timer */

    if ($this->spfconfig['useTimer']) {
        $val = "";
        $tm = time();  /* get current time in seconds  */
        if ($this->spfconfig['spfDebug']) {
            $val .=  'time = ' . $tm . '<br />';
        }
        $tm += $this->spfconfig['timerOffset'];  /* obfuscate time  */
        if ($this->spfconfig['spfDebug']) {
            $val .= 'time = ' . $tm . '<br /><br />';
        }
        $val .= '<div class="spform_normal_input"><input type="hidden" name="tmStart" value="' . $tm . '" /></div>';
        $this->modx->setPlaceholder('spf-use-timer',$val);
    } else {
        $this->modx->setPlaceholder('spf-use-timer',"");
    }

    /*  Now we'll create the input form itself  */

    /* Who are we sending the mail to  */

    /*The incoming property takes the form:
    Webmaster : webmaster@someplace.com, Sales : sales@someplace.com*/

    /* make an array from the comma-separated entries */

    $this->spfconfig['recipientArray'] = explode(",",$this->spfconfig['recipientArray']);

    /* split each entry at the :  and set an option with the first part */

    foreach ($this->spfconfig['recipientArray'] as $inString) {
        list($key, $value) =  explode(':', $inString);
        $options[$key] = $key;

    }

    /*  If we've more than one choice: present a menu  */
    $val = "";
    if(count($options) > 1) {
    /*   If we were given a single arg, that'll be the selected menu item.  */
        $val = '<span class="spf_inline_prompt">'.$this->modx->lexicon('send-to').': </span>';

        if(count($_GET) == 1)
            $selected = strtolower(key($_GET));
        $val .= "<span><select name=\"whoto\">\n";
        foreach($options as $key => $description) {
            $val .= "<option ";
            if(strtolower($key) == $selected)
                $val .= "selected ";
                $val .= "value=\"" . trim($key) .  "\">" .
                trim($description) . "\n".'</option>';
        }
        $val .= "</select></span>\n";

        $this->modx->setPlaceholder('spf-recipient',$val);
    } else {
        /* There'll be only one...  */
        if ($this->spfconfig['showSingleRecipientTo']) {
            $val = '<span class="spf_inline_prompt">'.$this->modx->lexicon('send-to').': </span>';


            foreach($options as $key => $description) {
                $val .= '<span class="spf_normal_input"><input type="hidden" name="whoto" value="' .
                trim($key) . '" />' . trim($description) . "\n".'</span>';
            }

        }  else {
            foreach($options as $key => $description) {
                $val .='<input type="hidden" name="whoto" value="' .
                trim($key) . "\" />\n";
            }
        }
        $this->modx->setPlaceholder('spf-recipient',$val);
    }

    /* Set $_SESSION variable used by the spfresponse page to create a "take me back" link.*/

    $ref = getenv("HTTP_REFERER");
    if (empty($ref)) {
        $ref = $_SERVER["HTTP_REFERER"];
    }

    if(!empty($ref)) {

       $_SESSION['origReferer'] = $ref;
    }

    $val = $this->modx->lexicon('your-name') ;
    $this->modx->setPlaceholder('spf-name-prompt',$val);

    $val = $this->modx->lexicon('email-address');
    $this->modx->setPlaceholder('spf-email-prompt',$val);

    $val = $this->modx->lexicon('subject');
    $this->modx->setPlaceholder('spf-subject-prompt',$val);

    $val = "";

            /*  Are we requiring CAPTCHA-style "is a human" verification?  */

    if($this->spfconfig['requireVerify']) {   /* $verifyUrl set earlier in this file  */

        /*   make sure we can  find the captcha files   */

        if (! file_exists(MODX_ASSETS_PATH. "captcha/captcha.php")) {
          echo "<br>" . $this->modx->lexicon('no-captcha');
          exit();
        }
        $useMathString = $this->spfconfig['useMathString'];

        if ($useMathString) {
        $alt = $this->modx->lexicon("login_mathstring_message");
        } else {
           $alt = $this->modx->lexicon("login_captcha_message");
        }

        $captcha_image= '<img '. 'onclick="this.src=' . "'" . $this->modx->config['site_url'] . "assets/captcha/captcha.php?rand='" .
            "+Math.floor(Math.random()*200);".'"' .' src="'.$this->modx->config['site_url'].'assets/captcha/captcha.php?rand='.rand().'" alt="'.$alt.'" />';


        if ($useMathString) {
            $_SESSION['captcha_use_mathstring'] = true;
            $captcha_prompt = $this->modx->lexicon("login_mathstring_message");
            $captcha_input_prompt = $this->modx->lexicon("captcha_mathstring_code").":";
        } else {
            $_SESSION['captcha_use_mathstring'] = false;
            $captcha_prompt = $this->modx->lexicon("login_captcha_message");
            $captcha_input_prompt = $this->modx->lexicon("captcha_code") . ":";
        }


        $this->modx->setPlaceholder('spf-captcha-instructions',$captcha_prompt);
        $this->modx->setPlaceholder('spf-captcha-image',$captcha_image);
        $this->modx->setPlaceholder('spf-captcha-input-prompt',$captcha_input_prompt);
        $this->modx->setPlaceholder('spf-captcha-input','<input type="text" name="verify"  value="" />');

        $this->modx->setPlaceholder('spf-captcha-stuff',$this->modx->getChunk($this->spfconfig['spfcaptchaTpl']));

    } else {
        $this->modx->setPlaceholder('spf-captcha-instructions',"");
        $this->modx->setPlaceholder('spf-captcha-image',"");
        $this->modx->setPlaceholder('spf-captcha-input-prompt',"");
        $this->modx->setPlaceholder('spf-captcha-input',"");
        $this->modx->setPlaceholder('spf-captcha-stuff',"");
    }



    $val =  $this->modx->lexicon('enter-comments');
    $this->modx->setPlaceholder('spf-comments-prompt',$val);
    $this->modx->setPlaceholder('spf-text-rows',$this->spfconfig['spTextRows']);
    $this->modx->setPlaceholder('spf-text-cols',$this->spfconfig['spTextCols']);

    $this->modx->setPlaceholder('spf-submit',$this->modx->lexicon('submit'));

    if ($this->spfconfig['includeResetButton']) {
        $val =  '<input type="reset" value="'.$this->modx->lexicon('reset').'" />';
        $this->modx->setPlaceholder('spf-reset',$val);
    } else {
        $this->modx->setPlaceholder('spf-reset',"");
    }

}
/** Render the form
*   @access public
*   @return string Returns the processed output of the spformTpl chunk
*/

    function render() {

        $chunk = $this->modx->getObject('modChunk',array(
        'name' => $this->spfconfig['spformTpl']
        ));
        if ($chunk == null) {
            die ($this->modx->lexicon('no-template'). $this->spfconfig['spformTpl']);
        }

       return $chunk->process();
    }

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
   ?>