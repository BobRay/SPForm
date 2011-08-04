<?php
/**
 * Properties lexicon topic for SPForm package
 * @author Bob Ray
 * 1/15/11
 *
 * @package spform
 * @subpackage lexicon
 * @language en
 */


/* SPForm Property Description strings */
$_lang['spf_recipientarray_desc'] = 'Comma separated list of recipient title/email pairs for the sent mail. Should be in this form:  Webmaster :webmaster@mydomain.com,Sales :sales@mydomain.com';
$_lang['spf_errorsto_desc'] = 'Error reports will be emailed to this address if the appropriate options are set.';
$_lang['spf_spformtpl_desc'] = 'SPForm Template chunk name; default: spformTpl.';
$_lang['spf_spformproctpl_desc'] = 'SPFormproc Template chunk name; default: spformprocTpl.';
$_lang['spf_spfcaptchatpl_desc'] = 'SPForm captcha Template chunk name; default: spfcaptchaTpl.';
$_lang['spf_test_mode_desc'] = 'Test SPForm without sending mail; default: 0.';
$_lang['spf_spfdebug_desc'] = 'Print debugging info - Do not leave this on for a working site; default: 0.';
$_lang['spf_formprocallowedreferers_desc'] = 'Comma separated list of allowed referers. Be sure this lists all the domains by which your contact page can be reached.';
$_lang['spf_spfresponseid_desc'] = 'Resource ID of SPFResponse page. This value will be set automatically on the first visit to the form.';
$_lang['spf_adviseall_desc'] = 'Email all errors to &errorsTo recipient; default: 0.';
$_lang['spf_warnall_desc'] = 'Warn the user of all errors (use this only for debugging); default: 0.';
$_lang['spf_spfusesmtp_desc'] = 'Use SMTP instead of mail(). Be sure to set all spfSMTP_ variables if you use this; default: 0.';
$_lang['spf_spfsmtp_port_desc'] = 'SMTP Port; default: 587.';
$_lang['spf_spfsmtp_host_desc'] = 'SMTP account Host.';
$_lang['spf_spfsmtp_username_desc'] = 'SMTP account username.';
$_lang['spf_spfsmtp_password_desc'] = 'SMTP account password.';
$_lang['spf_usehiddenfield_desc'] = 'Use hidden field to fool spambots. If they fill it out, the mail is not sent. Note: This doesn not use visibility:hidden so it should not affect SEO; default: 1.';
$_lang['spf_warnhiddenfield_desc'] = 'Warn the user about hidden field violations; default: 0.';
$_lang['spf_logonhidden_desc'] = 'Log hidden field violations; default: 0.';
$_lang['spf_requiremouseorkeyboard_desc'] = 'Require user to use either mouse or keyboard. Should not cause accessibility problems; default: 1.';
$_lang['spf_requirekeyboard_desc'] = 'Require user to use keyboard (ignored if requireMouseOrKeyboard=1). This creates accessibility issues and should only be used for debugging; default: 0.';
$_lang['spf_requiremouse_desc'] = 'Requre user to use mouse (ignored if requireMouseOrKeyboard=1). This creates accessibility issues and should only be used for debugging; default: 0.';
$_lang['spf_warnmouseandkeyboard_desc'] = 'Warn user of mouse or keyboard violations; default: 0.';
$_lang['spf_logmouseandkeyboarderrors_desc'] = 'Log mouse and keyboard violations; default: 0.';
$_lang['spf_usetimer_desc'] = 'Use max and min time limits for the form. Spambots often fill the form very quickly or very slowly. The settings should be fairly generous to avoid accessibility issues; default: 1.';
$_lang['spf_usetimermin_desc'] = 'Minimum time allowed (seconds); default: 10.';
$_lang['spf_usetimermax_desc'] = 'Maximum time allowed (seconds); default: 1800.';
$_lang['spf_warntimer_desc'] = 'Warn user of timer violations; default: 0.';
$_lang['spf_logontimer_desc'] = 'Log timer violations; default: 0.';
$_lang['spf_timeroffset_desc'] = 'Obfuscates the timer value; default: 14543.';
$_lang['spf_addsubjsig_desc'] = 'Add a distinctive prefix to subject field; default: 1.';
$_lang['spf_dfltsubj_desc'] = 'Subject prefix to use. If addSubjSig = 1, this prefix is added to the subject of all messages; default: Contact.';
$_lang['spf_loginjections_desc'] = 'Log script injection attempts; default: 0.';
$_lang['spf_warninjections_desc'] = 'Warn user of script injection attempts; default: 0.';
$_lang['spf_maxrecipientlen_desc'] = 'Maximum length of recipient field. If you are sending to multiple people with very long email addresses, you may need to change this; default: 65.';
$_lang['spf_logrecipientlen_desc'] = 'Log recipient length violations; default: 0.';
$_lang['spf_warnrecipientlen_desc'] = 'Warn user of recipient length violations; default: 0.';
$_lang['spf_maxsubjectlen_desc'] = 'Maximum length of subject field. You can make this longer or shorter if you like; default: 100.';
$_lang['spf_logsubjectlen_desc'] = 'Log subject length violations; default: 0.';
$_lang['spf_warnsubjectlen_desc'] = 'Warn user of subject length violations; default: 0.';
$_lang['spf_maxlinks_desc'] = 'Maximum number of http links in the message body. If your users will be sending you long lists of links, you will need to make this bigger; default: 3.';
$_lang['spf_logmaxlinks_desc'] = 'Log max links violations; default: 0.';
$_lang['spf_warnmaxlinks_desc'] = 'Warn user of max links violations; default: 0.';
$_lang['spf_logillegalsubject_desc'] = 'Log illegal content in the subject field; default: 0.';
$_lang['spf_warnillegalsubject_desc'] = 'Warn user of illegal content in the subject field; default: 0.';
$_lang['spf_mailalso_desc'] = 'All emails sent will be CCd to this address.';
$_lang['spf_requirename_desc'] = 'Require the name field; default: 1.';
$_lang['spf_requiresubject_desc'] = 'Require the subject field; default: 1.';
$_lang['spf_requireemail_desc'] = 'Require the email field; default: 1.';
$_lang['spf_sptextrows_desc'] = 'Row size of message window (the input box for the message body); default: 10.';
$_lang['spf_sptextcols_desc'] = 'Column size of message window (the input box for the message body); default: 50.';
$_lang['spf_includeresetbutton_desc'] = 'Include a reset button that empties all form fields; default: 0.';
$_lang['spf_showsinglerecipientto_desc'] = 'Show the recipient name if there is only one; default: 0.';
$_lang['spf_requireverify_desc'] = 'Use captcha-style verification; default: 0.';
$_lang['spf_usemathstring_desc'] = 'Use simple math equations as captcha images. The user is asked to solve a simple equation. This fools spambots that can read captcha images; default: 1.';
$_lang['spf_warnverify_desc'] = 'Warn users that their captcha entry is wrong; default: 1.';
$_lang['spf_adviseonverify_desc'] = 'email errorsTo recipient about bad captcha attempts; default: 0.';
$_lang['spf_logonverify_desc'] = 'Log bad captcha attempts; default: 0.';
$_lang['spf_reportremotehost_desc'] = 'Put remote host in x-headers (if there is one); default: 1.';
$_lang['spf_reportremoteuser_desc'] = 'Put remote user in x-headers (if there is one); default: 1.';
$_lang['spf_reportremoteaddr_desc'] = 'Put remote host address in x-headers (if there is one); default: 1.';
$_lang['spf_reportremoteident_desc'] = 'Put remote identity in x-headers (if there is one); default: 1.';
$_lang['spf_reportorigreferer_desc'] = 'Put original referer in x-headers (if there is one); default: 1.';
$_lang['spf_formprocblankrefokay_desc'] = 'Allow HTTP REFERER to be blank; default: 1.';
$_lang['spf_adviseonreferer_desc'] = 'Email errorsTo recipient about invalid referer hits; default: 0.';
$_lang['spf_logonreferer_desc'] = 'Log invalid referer hits; default: 0.';
$_lang['spf_usebanlist_desc'] = 'Check every attempt against the Ban List. To use the banlist, manually edit the banlist file: core/components/spform/banlist.inc.php; default: 0.';
$_lang['spf_banlistchunk_desc'] = 'Name of Banlist chunk; default: spfBanlist.';
$_lang['spf_warnbanned_desc'] = 'Warn people that they are banned; default: 0.';
$_lang['spf_adviseonban_desc'] = 'Email errorsTo recipient about banned attempts; default: 0.';
$_lang['spf_logonban_desc'] = 'Log banned attempts; default: 0.';
$_lang['spf_chkformrefnotself_desc'] = 'Make sure the referer is not the form itself. Spammers often set the referer to the form itself; default: 1.';
$_lang['spf_chkformrefownserver_desc'] = 'Make sure request is coming from us. This can cause an intermittent "Disallowed HTTP referer" error if there are different urls for reaching the page or if users come directly to the contact page without visiting another page at the site first; default: 0.';
$_lang['spf_chkformrefnotblank_desc'] = 'Make sure referer is not blank. Use with care because some firewalls and proxies remove the HTTP referer; default: 0.';
$_lang['spf_spfrom_desc'] = 'Specify email address to use for Email From address; default: empty.';
$_lang['spf_useemailsender_desc'] = 'Use emailsender System Setting for Email From address; default: empty -- overrides spfrom property; default: 0.';

/* SPFResponse language strings */

$_lang['spf_takemeback_desc'] = 'Put a "take me back" link on response page; default: 1.';
$_lang['spf_spfresponsetpl_desc'] = 'SPF Response Template chunk name; default: spfresponseTpl.';














