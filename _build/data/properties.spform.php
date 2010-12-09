<?php

/**
* include file to set spform snippet properties.
* @access protected.
*
* Note: the properties recipientArray, errorsTo,
* SPFResponseID, and formProcAllowedReferers will
* be reset on install so their values here
* don't matter - they're set here to establish
* their position in the properties list.
*/

/* This section and the one at the end for debugging
 *  They allow this run as a standalone script that
 *  sets the properties and prints debugging info
 */

/*
global $modx;
$obj = $modx->getObject('modSnippet',array('name'=>'SPForm'));
if (!$obj) {
    $output .= "Object not found<br>";
}
*/

$properties = array(

array (
    'name'=>'recipientArray',
    'desc'=>'Comma separated list of recipient title/email pairs for the sent mail. Should be in this form --> Webmaster :webmaster@mydomain.com,Sales :sales@mydomain.com',
    'type'=>'textfield',
    'options'=>'',
    'value'=>'Webmaster: Webmaster: you@yourdomain.com'
),

array(
    'name'=>'errorsTo',
    'desc'=>'Error reports will be emailed to this address if the appropriate options are set.',
    'type'=>'textfield',
    'options'=>'',
    'value'=>'you@yourdomain.com'
),

array(
    'name'=>'spformTpl',
    'desc'=>'SPForm Template chunk name',
    'type'=>'textfield',
    'options'=>'',
    'value'=>'spformTpl'
),
array(
    'name'=>'spformprocTpl',
    'desc'=>'SPFormproc Template chunk name',
    'type'=>'textfield',
    'options'=>'',
    'value'=>'spformprocTpl'
),
array(
    'name'=>'spfcaptchaTpl',
    'desc'=>'SPForm captcha Template chunk name',
    'type'=>'textfield',
    'options'=>'',
    'value'=>'spfcaptchaTpl'
),

array(
    'name'=>'test_mode',
    'desc'=>'Test SPForm without sending mail',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'spfDebug',
    'desc'=>'Print debugging info - Do not leave this on for a working site',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'formProcAllowedReferers',
    'desc'=>'Comma separated list of allowed referers. Be sure this lists all the domains by which your contact page can be reached.',
    'type'=>'textfield',
    'options'=>'',
    'value'=>'mysite.com'
),


array(
    'name'=>'spfResponseID',
    'desc'=>'Resource ID of SPFResponse page. This value will be set automatically on the first visit to the form.',
    'type'=>'integer',
    'options'=>'',
    'value'=>'9999'
),


array(
    'name'=>'adviseAll',
    'desc'=>'Email all errors to $errorsTo recipient',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'warnAll',
    'desc'=>'Warn the user of all errors (use this only for debugging)',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'spfUseSMTP',
    'desc'=>'Use SMTP instead of mail(). Be sure to set the four spfSMTP_ variables if you use this.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'spfSMTP_Port',
    'desc'=>'SMTP Port',
    'type'=>'integer',
    'options'=>'',
    'value'=>'587'
),

array(
    'name'=>'spfSMTP_Host',
    'desc'=>'SMTP acount Host',
    'type'=>'textfield',
    'options'=>'',
    'value'=>'yourhost.com'
),

array(
    'name'=>'spfSMTP_UserName',
    'desc'=>'SMTP account username',
    'type'=>'textfield',
    'options'=>'',
    'value'=>'yourUserName'
),

array(
    'name'=>'spfSMTP_Password',
    'desc'=>'SMTP account password',
    'type'=>'textfield',
    'options'=>'',
    'value'=>'yourPassword'
),


array(
    'name'=>'useHiddenField',
    'desc'=>'Use hidden field to fool spambots. If they fill it out, the mail is not sent. Note: This doesn not use visibility:hidden so it should not affect SEO.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),



array(
    'name'=>'warnHiddenField',
    'desc'=>'Warn the user about hidden field violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'logOnHidden',
    'desc'=>'Log hidden field violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'requireMouseOrKeyboard',
    'desc'=>'Require user to use either mouse or keyboard. Should not cause accessibility problems.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),



array(
    'name'=>'requireKeyboard',
    'desc'=>'Require user to use keyboard (ignored if requireMouseOrKeyboard=1). This creates accessibility issues and should only be used for debugging.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'requireMouse',
    'desc'=>'Requre user to use mouse (ignored if requireMouseOrKeyboard=1). This creates accessibility issues and should only be used for debugging.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'warnMouseAndKeyboard',
    'desc'=>'Warn user of mouse or keyboard violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),


array(
    'name'=>'logMouseAndKeyboardErrors',
    'desc'=>'Log mouse and keyboard violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),


array(
    'name'=>'useTimer',
    'desc'=>'Use max and min time limits for the form. Spambots often fill the form very quickly or very slowly. The settings should be fairly generous to avoid accessibility issues.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),

array(
    'name'=>'useTimerMin',
    'desc'=>'Minimum time allowed (seconds)',
    'type'=>'integer',
    'options'=>'',
    'value'=>'10'
),

array(
    'name'=>'useTimerMax',
    'desc'=>'Maximum time allowed (seconds)',
    'type'=>'integer',
    'options'=>'',
    'value'=>'1800'
),



array(
    'name'=>'warnTimer',
    'desc'=>'Warn user of timer violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'logOnTimer',
    'desc'=>'Log timer violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'timerOffset',
    'desc'=>'Obfuscates the timer value',
    'type'=>'integer',
    'options'=>'',
    'value'=>'14543'
),


array(
    'name'=>'addSubjSig',
    'desc'=>'Add a distinctive prefix to subject field',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),



array(
    'name'=>'dfltSubj',
    'desc'=>'Subject prefix to use. If addSubjSig = 1, this prefix is added to the subject of all messages. Another possibilty is $modx->config["site_name"]',
    'type'=>'textfield',
    'options'=>'',
    'value'=>" Contact"
),



array(
    'name'=>'logInjections',
    'desc'=>'Log script injection attempts',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'warnInjections',
    'desc'=>'Warn user of script injection violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'maxRecipientLen',
    'desc'=>'Maximum length of recipient field. If you are sending to multiple people with very long email addresses, you may need to change this.',
    'type'=>'integer',
    'options'=>'',
    'value'=>'65'
),

array(
    'name'=>'logRecipientLen',
    'desc'=>'Log recipient length violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'warnRecipientLen',
    'desc'=>'Warn user of recipient length violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'maxSubjectLen',
    'desc'=>'Maximum length of subject field. You can make this longer or shorter if you like.',
    'type'=>'integer',
    'options'=>'',
    'value'=>'100'
),

array(
    'name'=>'logSubjectLen',
    'desc'=>'Log subject length violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'warnSubjectLen',
    'desc'=>'Warn user of subject length violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'maxLinks',
    'desc'=>'Maximum number of http links in the message body. If your users will be sending you long lists of links, you will need to make this bigger.',
    'type'=>'integer',
    'options'=>'',
    'value'=>'3'
),

array(
    'name'=>'logMaxLinks',
    'desc'=>'Log max links violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'warnMaxLinks',
    'desc'=>'Warn user of max links violations',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'logIllegalSubject',
    'desc'=>'Log illegal content in the subject field.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'warnIllegalSubject',
    'desc'=>'Warn user of illegal content in the subject field.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'mailAlso',
    'desc'=>'All emails sent will be CCd to this address',
    'type'=>'textfield',
    'options'=>'',
    'value'=>''
),



array(
    'name'=>'requireName',
    'desc'=>'Require the name field',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),

array(
    'name'=>'requireSubject',
    'desc'=>'Require the subject field',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),

array(
    'name'=>'requireEmail',
    'desc'=>'Require the email field',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),



array(
    'name'=>'spTextRows',
    'desc'=>'Row size of message window (the input box for the message body)',
    'type'=>'integer',
    'options'=>'',
    'value'=>'10'
),

array(
    'name'=>'spTextCols',
    'desc'=>'Column size of message window (the input box for the message body)',
    'type'=>'integer',
    'options'=>'',
    'value'=>'50'
),



array(
    'name'=>'includeResetButton',
    'desc'=>'Include a reset button that empties all form fields.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'showSingleRecipientTo',
    'desc'=>'Show the recipient name if there is only one',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'requireVerify',
    'desc'=>'Use captcha-style verification',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'useMathString',
    'desc'=>'Use simple math equations as captcha images. The user is asked to solve a simple equation. This fools spambots that can read captcha images.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),



array(
    'name'=>'warnVerify',
    'desc'=>'Warn users that their captcha entry is wrong',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),
array(
    'name'=>'adviseOnVerify',
    'desc'=>'email errorsTo recipient about bad captcha attempts',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'logOnVerify',
    'desc'=>'Log bad captcha attempts',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),


array(
    'name'=>'reportRemoteHost',
    'desc'=>'Put remote host in x-headers (if there is one).',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),

array(
    'name'=>'reportRemoteUser',
    'desc'=>'Put remote user in x-headers (if there is one)',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),

array(
    'name'=>'reportRemoteAddr',
    'desc'=>'Put remote host address in x-headers (if there is one)',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),

array(
    'name'=>'reportRemoteIdent',
    'desc'=>'Put remote identity in x-headers (if there is one)',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),

array(
    'name'=>'reportOrigReferer',
    'desc'=>'Put original referer in x-headers (if there is one)',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),




array(
    'name'=>'formProcBlankRefOkay',
    'desc'=>'Allow HTTP REFERER to be blank',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),



array(
    'name'=>'adviseOnReferer',
    'desc'=>'Email errorsTo recipient about invalid referer hits',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'logOnReferer',
    'desc'=>'Log invalid referer hits',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'useBanList',
    'desc'=>'Check every attempt against the Ban List. To use the banlist, manually edit the banlist file: assets/components/spform/banlist.inc.php.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'warnBanned',
    'desc'=>'Warn people that they are banned',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'adviseOnBan',
    'desc'=>'email errorsTo recipient about banned attempts',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'logOnBan',
    'desc'=>'Log banned attempts',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),

array(
    'name'=>'chkFormRefNotSelf',
    'desc'=>'Make sure the referer is not the form itself. Spammers often set the referer to the form itself.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'1'
),



array(
    'name'=>'chkFormRefOwnServer',
    'desc'=>'Make sure request is coming from us. This can cause an intermittent "Disallowed HTTP referer" error if there are different urls for reaching the page or if users come directly to the contact page without visiting another page at the site first.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
),



array(
    'name'=>'chkFormRefNotBlank',
    'desc'=>'Make sure referer is not blank. Use with care because some firewalls and proxies remove the HTTP referer.',
    'type'=>'combo-boolean',
    'options'=>'',
    'value'=>'0'
)

);

/* For debugging - see note above */

/*
  $obj->setProperties($spformProperties);
  $obj->save();

 $propArray = $obj->getProperties();

  foreach ($propArray as $key=>$value) {
      $output .= $key . ": " . $value . "<br><br>";
 }
*/

return $properties;
