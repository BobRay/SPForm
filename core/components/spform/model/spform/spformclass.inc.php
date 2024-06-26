<?php

/**
 * SPForm Class file
 *
 * Copyright 2011-2017 Bob Ray
 *
 * @author Bob Ray <https://bobsguides.com>
 * 1/15/11
 *
 * SPForm is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 * SPForm is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * SPForm; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package spform
 */
/**
 * MODX SPForm Class
 *
 * Description: SPForm Class
 * @package spform
 */


/**  This class is instantiated on the first request to the page.
*    It does some preliminary checks, then renders the form.
*    @package spform
*    @author  Bob Ray <https://bobsguides.com>
*    @created 10/04/2008
*    @version 3.2.0  */

class spform {
/**
     * @var modx MODX reference instance passed in the constructor.
     * @access protected
     */
    /* @var $modx modX */
    protected $modx;
    /**
     * @var $spfconfig array of snippet properties passed in the constructor.
     * @access protected
     */
    protected $spfconfig;

    /** @var $placeholders array array of placeholders */
    protected $placeholders;

/**
     * PHP5 Constructor
     * @access public
     * @param array $modx MODX object.
     * @param array $spfconfig Array of snippet properties.
     */

    function  __construct(&$modx, $spfconfig = array()) {
        $this->modx =& $modx;

        $this->spfconfig = array_merge(array(
            'assets_path' => $this->modx->getOption('assets_path').'components/spform/',
        ),$spfconfig);
    }


/**
* Inserts the javascript code to validate the form.
* The inserted code is customized based on various snippet
* properties.
* @access public.
*/
function register_js() {



    /* javascript validation */
    $inFile = $this->modx->getOption('assets_url')."components/spform/js/emailcheck.js";

    $this->modx->regClientStartupScript($inFile);

    $src = '<script type="text/javascript"> ';
    $src .= ' /* <![CDATA[ */ ';
    $src .= 'var requireName = ';
    $this->spfconfig["requireName"]? $src .= "true; " : $src .= "false; ";

    $src .= 'var requireEmail = ';
    $src .= $this->modx->getOption('requireEmail',$this->spfconfig,false) ? 'true; ' : 'false; ';

    $src .= 'var requireSubject = ';
    $src .= $this->modx->getOption('requireSubject',$this->spfconfig,false) ? 'true; ' : 'false; ';

    $src .= 'function checkform (form) { ';

        $src .= 'if (requireName == true) { ';
            $src .= 'if (form.name.value == "") { ';
                $src .= 'alert("' . $this->modx->lexicon('no-name') . '"); ';
                $src .= 'form.name.focus(); ';
                $src .= 'return false; ';
            $src .= '} ';
        $src .= '} ';

        $src .= 'if (requireEmail == true) { ';
            $src .= 'if (form.email.value.length == "") { ';
                $src .= 'alert("' . $this->modx->lexicon('no-email') . '" ); ';
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
                $src .= 'alert("' . $this->modx->lexicon('no-subject') . '"); ';
                $src .= 'form.subject.focus(); ';
                $src .= 'return false; ';
            $src .= '} ';
        $src .= '} ';

         $src .= 'if (form.comments.value == "") { ';
            $src .= 'alert("' . $this->modx->lexicon('no-comments') . '" ); ';
            $src .= 'form.comments.focus(); ';
            $src .= 'return false; ';
         $src .= '} ';

        if ($this->modx->getOption('requireVerify', $this->spfconfig, false)) {
            $src .= 'if (form.verify.value == "") { ';
            $src .= 'alert("' . $this->modx->lexicon('forgot-captcha') . '" ); ';
            $src .= 'form.verify.focus(); ';
            $src .= 'return false; ';
            $src .= '} ';
        }

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



    if(($this->modx->getOption('chkFormRefNotBlank',$this->spfconfig,false) && !$_SERVER['HTTP_REFERER']) ||
       ($this->modx->getOption('chkFormRefNotSelf',$this->spfconfig,false) && preg_match("#$selfChkStr$#i", $_SERVER['HTTP_REFERER'])) ||
       ($this->modx->getOption('chkFormRefOwnServer',$this->spfconfig,false) && $_SERVER['HTTP_REFERER'] &&
        !preg_match("#^$serverChkStr#i", $referer)))
    {
        /* Almost certainly web form spammers "terminate" the page early */

        print('<div align="center">'.$this->modx->lexicon('bad-referer').' "'.
            $_SERVER['HTTP_REFERER'] .'"</div>');
        print("</body></html>");
        session_write_close();
        exit;
    }

}

/**  Get ready to render the form and set all placeholders
 *  @access public
 */

function set_placeholders () {
  // echo print_r($_POST,true);
  $this->placeholders['spf-submit-var'] = isset($this->spfconfig['spf-submit-var'])? $this->spfconfig['spf-submit-var'] : 'defaultSubmitVar';
  /* set values from $_POST */
  $ph = array(
      'name',
      'email',
      'subject',
      'comments',
  );

  foreach($ph as $p) {
      if (isset($_POST[$p])) {
          $this->placeholders['spf-' . $p] = $_POST[$p];
      } else {
          $this->placeholders['spf-' . $p] = '';
      }
  }

/*  Create CAPTCHA image URL for use later if requireVerify is true  */

        if ($this->modx->getOption('requireVerify',$this->spfconfig,false)) {

            /* ToDO: path to captcha should be system setting: spform.captcha_path? */
            $verifyUrl=$this->modx->getOption('assets_url').'components/captcha/captcha.php';
            $this->placeholders['spf-cookie-message'] = '<div class="spf_cookie_msg">('.$this->modx->lexicon('cookies-required').')</div>';

            if ($this->modx->getOption('spfDebug',$this->spfconfig,false)) {
                echo "<b>Verify URL:</b><br />".$verifyUrl.'<br />';
            }
        } else {
            $this->placeholders['spf-cookie-message'] = "";
        }



      /* Send the keycount value if we're requiring the mouse and/or keyboard */
    if ($this->modx->getOption('requireKeyboard',$this->spfconfig,false)
     || $this->modx->getOption('requireMouseOrKeyboard',$this->spfconfig,false)) {
        $file = $this->spfconfig['assets_path'] . "js/usedkeyboard.js";
        if( false == ($str = file_get_contents($file))) {
            $val = $this->modx->lexicon('no-js') . $file;
            session_write_close();
            die($val);
        } else {
            $val = '<input type="hidden" name="keyCount" id="keyCount" value="" />';
            $val .= '<script type="text/javascript">';
            $val .= ' /* <![CDATA[ */ ';
            $val .= $str;
            $val .= ' /* ]]>  */ ';
            $val .= '</script>';
            $this->placeholders['spf-use-mouse-or-keyboard1'] = $val;
        }
    } else {
        $this->placeholders['spf-use-mouse-or-keyboard1'] = "";
    }

    /* send the mouse movement value */
    if ($this->modx->getOption('requireMouse',$this->spfconfig,false)
     || $this->modx->getOption('requireMouseOrKeyboard',$this->spfconfig,false)) {

        $file = $this->spfconfig['assets_path'] . "js/mousemovement.js";
        if( false == ($str = file_get_contents($file))) {
            $val = $this->modx->lexicon('no-js') . $file;
            session_write_close();
            die($val);
        } else {
            $val =  '<input type="hidden" name="mouseTravel" id="mouseTravel" value="" />';
            $val .= '<script type="text/javascript">';
            $val .= ' /* <![CDATA[ */ ';
            $val .= $str;
            $val .= ' /* ]]>  */ ';
            $val .= '</script>';
            $this->placeholders['spf-use-mouse-or-keyboard2'] = $val;
        }
    } else {
        $this->placeholders['spf-use-mouse-or-keyboard2'] = "";
    }

    /*  Add hidden field to output if $useHiddenField == true.
     * Double underscore in input variable name should prevent autofill by Firefox and RoboForm
     */
    if ($this->modx->getOption('useHiddenField',$this->spfconfig,true)) {
        $val = '<div class="spform_input">';
        $val .= $this->modx->lexicon('hidden-last-name').': ' . '<input type="text" name="Last__Name" size="30" /></div>';
        $this->placeholders['spf-use-hidden-field'] = $val;
    } else {
        $this->placeholders['spf-use-hidden-field'] = "";
    }

    /*  Set timer variables, if using timer */

    if ($this->modx->getOption('useTimer',$this->spfconfig,false)) {
        $val = "";
        $tm = time();  /* get current time in seconds  */
        if ($this->modx->getOption('spfDebug',$this->spfconfig,false)) {
            $val .=  'time = ' . $tm . '<br />';
        }
        $tm += $this->spfconfig['timerOffset'];  /* obfuscate time  */
        if ($this->modx->getOption('spfDebug',$this->spfconfig,false)) {
            $val .= 'time = ' . $tm . '<br /><br />';
        }
        $val .= '<div class="spform_normal_input"><input type="hidden" name="tmStart" value="' . $tm . '" /></div>';
        $this->placeholders['spf-use-timer'] = $val;
    } else {
        $this->placeholders['spf-use-timer'] = "";
    }

    /*  Now we'll create the input form itself  */

    /* Who are we sending the mail to  */

    /*The incoming property takes the form:
    Webmaster : webmaster@someplace.com, Sales : sales@someplace.com*/

    /* make an array from the comma-separated entries */

    $ra = $this->modx->getOption('recipientArray',$this->spfconfig,'');
    $this->spfconfig['recipientArray'] = explode(',',$ra);

    unset($ra);

    /* split each entry at the :  and set an option with the first part */
    $options = array();
    foreach ($this->spfconfig['recipientArray'] as $inString) {
        list($key, $value) =  explode(':', $inString);
        $options[$key] = $key;

    }

    /*  If we've more than one choice: present a menu  */
    $val = "";
    $selected = '';
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

        $this->placeholders['spf-recipient'] = $val;
    } else {
        /* There'll be only one...  */
        if ($this->modx->getOption('showSingleRecipientTo',$this->spfconfig,false)) {
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
        $this->placeholders['spf-recipient'] = $val;
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
    $this->placeholders['spf-name-prompt'] = $val;

    $val = $this->modx->lexicon('email-address');
    $this->placeholders['spf-email-prompt'] = $val;

    $val = $this->modx->lexicon('subject');
    $this->placeholders['spf-subject-prompt'] = $val;

    $val = "";

            /*  Are we requiring CAPTCHA-style "is a human" verification?  */

    if ($this->modx->getOption('requireVerify',$this->spfconfig,false)) {   /* $verifyUrl set earlier in this file  */

        /*   make sure we can  find the captcha files   */

        if (! file_exists($this->modx->getOption('assets_path'). "components/captcha/captcha.php")) {
          echo '<br />' . $this->modx->lexicon('no-captcha');
          session_write_close();
          exit();
        }
        $useMathString = $this->modx->getOption('useMathString',$this->spfconfig,true);

        if ($useMathString) {
            $alt = $this->modx->lexicon("login_mathstring_message");
        } else {
           $alt = $this->modx->lexicon("login_captcha_message");
        }

        if ($useMathString) {
            $_SESSION['captcha.use_mathstring'] = 'true';
            $captcha_prompt = $this->modx->lexicon("login_mathstring_message");
            $captcha_input_prompt = $this->modx->lexicon("captcha_mathstring_code").":";
        } else {
            $_SESSION['captcha.use_mathstring'] = 'false';
            $captcha_prompt = $this->modx->lexicon("login_captcha_message");
            $captcha_input_prompt = $this->modx->lexicon("captcha_code") . ":";
        }

        $captcha_image= '<img '. 'onclick="this.src=' . "'" . $this->modx->getOption('assets_url') . "components/captcha/captcha.php?rand='" .
            "+Math.floor(Math.random()*200);".'"' .' src="'. $this->modx->getOption('assets_url') . 'components/captcha/captcha.php?rand='.rand().'" alt="'.$alt.'" />';

        $this->placeholders['spf-captcha-instructions'] = $captcha_prompt;
        $this->placeholders['spf-captcha-image'] = $captcha_image;
        $this->placeholders['spf-captcha-input-prompt'] = $captcha_input_prompt;
        $this->placeholders['spf-captcha-input'] = '<input type="text" name="verify"  value="" />';

        $spfCaptchaTpl = $this->modx->getOption('spfcaptchaTpl',$this->spfconfig,'spfcaptchaTpl');
        $this->placeholders['spf-captcha-stuff'] = $this->modx->getChunk($spfCaptchaTpl);

    } else {
        $this->placeholders['spf-captcha-instructions'] = "";
        $this->placeholders['spf-captcha-image'] = "";
        $this->placeholders['spf-captcha-input-prompt'] = "";
        $this->placeholders['spf-captcha-input'] = "";
        $this->placeholders['spf-captcha-stuff'] = "";
    }



    $val =  $this->modx->lexicon('enter-comments');
    $this->placeholders['spf-comments-prompt'] = $val;
    $this->placeholders['spf-text-rows'] = $this->modx->getOption('spTextRows',$this->spfconfig,10);
    $this->placeholders['spf-text-cols'] = $this->modx->getOption('spTextCols',$this->spfconfig,50);

    $this->placeholders['spf-submit'] = $this->modx->lexicon('submit');

    if ($this->spfconfig['includeResetButton']) {
        $val =  '<input type="reset" value="'.$this->modx->lexicon('reset').'" />';
        $this->placeholders['spf-reset'] = $val;
    } else {
        $this->placeholders['spf-reset'] = '';
    }

}
/** Render the form
*   @access public
*   @return string Returns the processed output of the spformTpl chunk
*/

    function render() {
        /* @var $chunk modChunk */
        $spformTpl = $this->modx->getOption('spformTpl',$this->spfconfig,'spformTpl');

        $chunk = $this->modx->getChunk($spformTpl, $this->placeholders);
        if ($chunk == null) {
            session_write_close();
            die($this->modx->lexicon('no-template'). $spformTpl);
        }

       return $chunk;
    }

}

/*

   The original code for this snippet was written by James Seymour as
   scform.php. I've made extensive modifications to the code, but much of
   Jim's original code remains.

   Some changes were to integrate the package with MODX. Others were (hopefully)
   improvements I found in various other contact forms. I've also changed
   some of the original defaults and added some parameters.

   If the form works for you, James deserves most of the credit. If it doesn't,
   I probably deserve most of the blame. Please don't ask Jim for help with the
   snippet. As far as I know, he is not MODX-aware. I have left his GPL statement
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
