<?php

/**
 * SPForm snippet
 *
 * Copyright 2011 Bob Ray
 *
 * @author Bob Ray
 * @date 1/15/11
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
 * MODx SPForm Snippet
 *
 * Description: SPForm snippet code
  *
 * @package spform
 *
 * Properties
 * @property recipientarray - Comma separated list of recipient title/email pairs for the sent mail. Should be in this form:  Webmaster :webmaster@mydomain.com,Sales :sales@mydomain.com
 * @property errorsto - Error reports will be emailed to this address if the appropriate options are set.
 * @property spformtpl - SPForm Template chunk name; default: spformTpl.
 * @property spformproctpl - SPFormproc Template chunk name; default: spformprocTpl.
 * @property spfcaptchatpl - SPForm captcha Template chunk name; default: spfcaptchaTpl.
 * @property test_mode - Test SPForm without sending mail; default: 0.
 * @property spfdebug - Print debugging info - Do not leave this on for a working site; default: 0.
 * @property formprocallowedreferers - Comma separated list of allowed referers. Be sure this lists all the domains by which your contact page can be reached.
 * @property spfresponseid - Resource ID of SPFResponse page. This value will be set automatically on the first visit to the form.
 * @property adviseall - Email all errors to &errorsTo recipient; default: 0.
 * @property warnall - Warn the user of all errors (use this only for debugging); default: 0.
 * @property spfusesmtp - Use SMTP instead of mail(). Be sure to set all spfSMTP_ variables if you use this; default: 0.
 * @property spfsmtp_port - SMTP Port; default: 587.
 * @property spfsmtp_host - SMTP account Host.
 * @property spfsmtp_username - SMTP account username.
 * @property spfsmtp_password - SMTP account password.
 * @property usehiddenfield - Use hidden field to fool spambots. If they fill it out, the mail is not sent. Note: This doesn not use visibility:hidden so it should not affect SEO; default: 1.
 * @property warnhiddenfield - Warn the user about hidden field violations; default: 0.
 * @property logonhidden - Log hidden field violations; default: 0.
 * @property requiremouseorkeyboard - Require user to use either mouse or keyboard. Should not cause accessibility problems; default: 1.
 * @property requirekeyboard - Require user to use keyboard (ignored if requireMouseOrKeyboard=1). This creates accessibility issues and should only be used for debugging; default: 0.
 * @property requiremouse - Requre user to use mouse (ignored if requireMouseOrKeyboard=1). This creates accessibility issues and should only be used for debugging; default: 0.
 * @property warnmouseandkeyboard - Warn user of mouse or keyboard violations; default: 0.
 * @property logmouseandkeyboarderrors - Log mouse and keyboard violations; default: 0.
 * @property usetimer - Use max and min time limits for the form. Spambots often fill the form very quickly or very slowly. The settings should be fairly generous to avoid accessibility issues; default: 1.
 * @property usetimermin - Minimum time allowed (seconds); default: 10.
 * @property usetimermax - Maximum time allowed (seconds); default: 1800.
 * @property warntimer - Warn user of timer violations; default: 0.
 * @property logontimer - Log timer violations; default: 0.
$_lang['spf_timeroffset_desc'] - Obfuscates the timer value; default: 14543.;
 * @property addsubjsig - Add a distinctive prefix to subject field; default: 1.
 * @property dfltsubj - Subject prefix to use. If addSubjSig = 1, this prefix is added to the subject of all messages; default: Contact.
 * @property loginjections - Log script injection attempts; default: 0.
 * @property warninjections - Warn user of script injection attempts; default: 0.
 * @property maxrecipientlen - Maximum length of recipient field. If you are sending to multiple people with very long email addresses, you may need to change this; default: 65.
 * @property logrecipientlen - Log recipient length violations; default: 0.
 * @property warnrecipientlen - Warn user of recipient length violations; default: 0.
 * @property maxsubjectlen - Maximum length of subject field. You can make this longer or shorter if you like; default: 100.
 * @property logsubjectlen - Log subject length violations; default: 0.
 * @property warnsubjectlen - Warn user of subject length violations; default: 0.
 * @property maxlinks - Maximum number of http links in the message body. If your users will be sending you long lists of links, you will need to make this bigger; default: 3.
 * @property logmaxlinks - Log max links violations; default: 0.
 * @property warnmaxlinks - Warn user of max links violations; default: 0.
 * @property logillegalsubject - Log illegal content in the subject field; default: 0.
 * @property warnillegalsubject - Warn user of illegal content in the subject field; default: 0.
 * @property mailalso - All emails sent will be CCd to this address.
 * @property requirename - Require the name field; default: 1.
 * @property requiresubject - Require the subject field; default: 1.
 * @property requireemail - Require the email field; default: 1.
 * @property sptextrows - Row size of message window (the input box for the message body); default: 10.
 * @property sptextcols - Column size of message window (the input box for the message body); default: 50.
 * @property includeresetbutton - Include a reset button that empties all form fields; default: 0.
 * @property showsinglerecipientto - Show the recipient name if there is only one; default: 0.
 * @property requireverify - Use captcha-style verification; default: 0.
 * @property usemathstring - Use simple math equations as captcha images. The user is asked to solve a simple equation. This fools spambots that can read captcha images; default: 1.
 * @property warnverify - Warn users that their captcha entry is wrong; default: 1.
 * @property adviseonverify - email errorsTo recipient about bad captcha attempts; default: 0.
 * @property logonverify - Log bad captcha attempts; default: 0.
 * @property reportremotehost - Put remote host in x-headers (if there is one); default: 1.
 * @property reportremoteuser - Put remote user in x-headers (if there is one); default: 1.
 * @property reportremoteaddr - Put remote host address in x-headers (if there is one); default: 1.
 * @property reportremoteident - Put remote identity in x-headers (if there is one); default: 1.
 * @property reportorigreferer - Put original referer in x-headers (if there is one); default: 1.
 * @property formprocblankrefokay - Allow HTTP REFERER to be blank; default: 1.
 * @property adviseonreferer - Email errorsTo recipient about invalid referer hits; default: 0.
 * @property logonreferer - Log invalid referer hits; default: 0.
 * @property usebanlist - Check every attempt against the Ban List. To use the banlist, manually edit the banlist file: core/components/spform/banlist.inc.php; default: 0.
 * @property banlistchunk - Name of Banlist chunk; default: spfBanlist.
 * @property warnbanned - Warn people that they are banned; default: 0.
 * @property adviseonban - Email errorsTo recipient about banned attempts; default: 0.
 * @property logonban - Log banned attempts; default: 0.
 * @property chkformrefnotself - Make sure the referer is not the form itself. Spammers often set the referer to the form itself; default: 1.
 * @property chkformrefownserver - Make sure request is coming from us. This can cause an intermittent "Disallowed HTTP referer" error if there are different urls for reaching the page or if users come directly to the contact page without visiting another page at the site first; default: 0.
 * @property chkformrefnotblank - Make sure referer is not blank. Use with care because some firewalls and proxies remove the HTTP referer; default: 0.

 */

/**
* This snippet creates a simple contact form with many spam-proofing options.
* For more information, see the assets/components/spform/docs/readme.txt file
* @package spform
*
* @see spformclass.inc.php
* @see spformprocclass.inc.php
* @see spformresponse
* @author  Bob Ray <bobray@softville.com>
* @created 10/04/2008
* @version 3.1.4
*
*/

/* error_reporting(E_ALL); */

global $modx;
/* $modx->setDebug(E_ALL & ~E_NOTICE); */

$spfconfig = $scriptProperties;
$spfconfig['spformPath'] = $modx->getOption('spformPath',$spfconfig,$modx->getOption('core_path').'components/spform/');

ini_set('error_log', $spformPath . 'error.log');

$modx->lexicon->load('spform:default');


$spformTpl = $modx->getOption('spformTpl',$spfconfig,false);
if (empty($spformTpl)) {
    die($modx->lexicon('no-config'). ' in spform');
}


/* If spfCssPath parameter is missing, user default.
 * IF set to "", no css file.
 * If it's set to a path, use that
 */
$cssPath = $modx->getOption('spfCssPath',$spfconfig,false);
if (!$cssPath) {
    $spfCSS = $modx->getOption('assets_url') . 'components/spform/css/spform.css';
    $modx->regClientCSS($spfCSS);

} else if (!empty($cssPath)) {
    $modx->regClientCSS($cssPath);

}  /* else do nothing, spfCssPath is set to "", user wants no spf css file.*/


/* This section processes the submitted form and sends mail */
if (isset($_POST['s'])) {

    $spf_key = $modx->getOption('emailsender');
    if ((strlen($spf_key) < 5) || ($_SESSION['include_auth'] != md5($spf_key))) {
        die ('Unauthorized Access in spformproc');
    }
    $iFile = $spfconfig['spformPath'] . "classes/spformprocclass.inc.php";

    require_once $iFile;

    $formProc = new spformproc($modx, $spfconfig);

    $retVal = $formProc->validate();
    if ($retVal != 'validated') {
        return $retVal;
    } else {
        return $formProc->send();
    }
}


/************************************************************************************/

/*  This section runs on the first request. It displays the form and submits it.  */

if ($modx->getOption('spfDebug',$spfconfig,false)) {
    echo "SPFormPath: " . $spfconfig['spformPath'];
    $iFile = $spfconfig['spformPath'] . "spfdebug.php";
    echo '<br /> iFile = ' . $iFile . '<br />';
    require $iFile;
}


$localKey = $modx->getOption('emailsender');
if ($localKey == '') {
    die($modx->lexicon('set_email'));
}
if (strlen($localKey) < 5) {
    die($modx->lexicon('unauthorized'));
}

/* set this for testing on postback */

$localKey = md5($localKey);
$_SESSION['include_auth'] = $localKey;

$iFile = $spfconfig['spformPath'] . "classes/spformclass.inc.php";
require_once $iFile;

$spform = new spform($modx, $spfconfig);

$spform->register_js();
$spform->check_referer();
$spform->set_placeholders();
return $spform->render();


 /*

   The original code for this snippet was written by James Seymour as
   scform.php. I've made extensive modifications to the code, but much of
   Jim's original code remains.

   Some changes were to integrate the package with MODx. Others were (hopefully)
   improvements I found in various other contact forms. I've also changed
   some of the original defaults and added many parameters.

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