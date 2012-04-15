<?php

/**
 * Script to interact with user during SPForm package install
 *
 * Copyright 2011 Bob Ray
 * @author Bob Ray <http://bobsguides.com>
 * 1/15/11
 *
 *  is free software; you can redistribute it and/or modify it
 * under the terms of the GNU General Public License as published by the Free
 * Software Foundation; either version 2 of the License, or (at your option) any
 * later version.
 *
 *  is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * ; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 * @package spform
 */
/**
 * Description: Script to interact with user during SPForm package install
 * @package spform
 * @subpackage build
 *
 * @var $options array
 */


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