<?php
/**
 * @package spform
 * @subpackage build
 */
switch ($options[XPDO_TRANSPORT_PACKAGE_ACTION]) {
    case XPDO_TRANSPORT_ACTION_INSTALL: break;
    case XPDO_TRANSPORT_ACTION_UPGRADE: break;
    case XPDO_TRANSPORT_ACTION_UNINSTALL: break;
}

$output = '<p>&nbsp;</p>
<label for="user_email">Please enter the email address you would like SPForm to send to.</label>

<p>&nbsp;</p>
<input type="text" name="user_email" id="user_email" value="" align="left" width="60" maxlength="60" />
<p>&nbsp;</p>
<p>
Note: You can change this easily, or add multiple recipients, later<br />
by going to the SPForm snippet page, selecting the "properties" tab,<br />
and changing the value of the recipientArray property.</p>';

return $output;