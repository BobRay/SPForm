<?php

/**
 * SPForm debugging code for SPForm package
 *
 * Copyright 2011 Bob Ray
 * @author Bob Ray <http://bobsguides.com>
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
 * Description: SPForm debugging code
 * @package spform
 */

/**
 * This section prints the debugging information if $spfDebug=true
 * @var $spfconfig array
 */
 echo "spfCssPath: ",$spfconfig['spfCssPath'] . '<br />';
 echo "referer: " . $_SERVER['HTTP_REFERER'] . '<br />';
 echo "spformTpl: ",$spfconfig['spformTpl'] . '<br />';
 echo "spformprocTpl: ",$spfconfig['spformprocTpl'] . '<br />';
 echo "spfcaptchaTpl: ",$spfconfig['spfcaptchaTpl'] . '<br />';
 echo "test_mode: ",$spfconfig['test_mode'] . '<br />';
 echo "formProcAllowedReferers: ",$spfconfig['formProcAllowedReferers'] . '<br />';
 echo "recipientArray: ",$spfconfig['recipientArray'] . '<br />';
 echo "spfResponseID: ",$spfconfig['spfResponseID'] . '<br />';
 echo "errorsto: ",$spfconfig['errorsTo'] . '<br />';
 echo "adviseAll: ",$spfconfig['adviseAll'] . '<br />';
 echo "warnAll: ",$spfconfig['warnAll'] . '<br />';
 echo "spfUseSMTP: ",$spfconfig['spfUseSMTP'] . '<br />';
 echo "spfSMTP_Host: ",$spfconfig['spfSMTP_Host'] . '<br />';
 echo "spfSMTP_Port: ",$spfconfig['spfSMTP_Port'] . '<br />';
 echo "useHiddenField: ",$spfconfig['useHiddenField'] . '<br />';
 echo "warnHiddenField: ",$spfconfig['warnHiddenField'] . '<br />';
 echo "logOnHidden: ",$spfconfig['logOnHidden'] . '<br />';
 echo "requireMouseOrKeyboard: ",$spfconfig['requireMouseOrKeyboard'] . '<br />';
 echo "requireKeyboard: ",$spfconfig['requireKeyboard'] . '<br />';
 echo "requireMouse: ",$spfconfig['requireMouse'] . '<br />';
 echo "warnMouseAndKeyboard: ",$spfconfig['warnMouseAndKeyboard'] . '<br />';
 echo "logMouseAndKeyboardErrors: ",$spfconfig['logMouseAndKeyboardErrors'] . '<br />';
 echo "useTimer: ",$spfconfig['useTimer'] . '<br />';
 echo "useTimerMin: ",$spfconfig['useTimerMin'] . '<br />';
 echo "useTimerMax: ",$spfconfig['useTimerMax'] . '<br />';
 echo "warnTimer: ",$spfconfig['warnTimer'] . '<br />';
 echo "logInTimer: ",$spfconfig['logOnTimer'] . '<br />';
 echo "addSubjSig: ",$spfconfig['addSubjSig'] . '<br />';
 echo "dfltSubj: ",$spfconfig['dfltSubj'] . '<br />';
 echo "logInjections: ",$spfconfig['logInjections'] . '<br />';
 echo "warnInjections: ",$spfconfig['warnInjections'] . '<br />';
 echo "maxRecipientLen: ",$spfconfig['maxRecipientLen'] . '<br />';
 echo "warnRecipientLen: ",$spfconfig['warnRecipientLen'] . '<br />';
 echo "maxSubjectLen: ",$spfconfig['maxSubjectLen'] . '<br />';
 echo "logSubjectLen: ",$spfconfig['logSubjectLen'] . '<br />';
 echo "warnSubjectLen: ",$spfconfig['warnSubjectLen'] . '<br />';
 echo "maxLinks: ",$spfconfig['maxLinks'] . '<br />';
 echo "logMaxLinks: ",$spfconfig['logMaxLinks'] . '<br />';
 echo "warnMaxLinks: ",$spfconfig['warnMaxLinks'] . '<br />';
 echo "logIllegalSubject: ",$spfconfig['logIllegalSubject'] . '<br />';
 echo "warnIllegalSubject: ",$spfconfig['warnIllegalSubject'] . '<br />';
 echo "mailAlso: ",$spfconfig['mailAlso'] . '<br />';
 echo "requireName: ",$spfconfig['requireName'] . '<br />';
 echo "requireSubj: ",$spfconfig['requireSubject'] . '<br />';
 echo "requireEmail: ",$spfconfig['requireEmail'] . '<br />';
 echo "spTextRows: ",$spfconfig['spTextRows'] . '<br />';
 echo "spTextCols: ",$spfconfig['spTextCols'] . '<br />';
 echo "includeResetButton: ",$spfconfig['includeResetButton'] . '<br />';
 echo "showSingleRecipientTo: ".$spfconfig['showSingleRecipientTo'] . '<br />';
 echo "requireVerify: ",$spfconfig['requireVerify'] . '<br />';
 echo "usemathString: ",$spfconfig['useMathString'] . '<br />';
 echo "warnVerify: ",$spfconfig['warnVerify'] . '<br />';
 echo "adviseOnVerify: ",$spfconfig['adviseOnVerify'] . '<br />';
 echo "logOnVerify: ",$spfconfig['logOnVerify'] . '<br />';
 echo "reportRemoteHost: ",$spfconfig['reportRemoteHost'] . '<br />';
 echo "reportRemoteUser: ",$spfconfig['reportRemoteUser'] . '<br />';
 echo "reportRemoteAddr: ",$spfconfig['reportRemoteAddr'] . '<br />';
 echo "reportRemoteIdent: ",$spfconfig['reportRemoteIdent'] . '<br />';
 echo "reportOrigReferer: ",$spfconfig['reportOrigReferer'] . '<br />';
 echo "formProcBlankRefOkay: ",$spfconfig['formProcBlankRefOkay'] . '<br />';
 echo "adviseOnReferer: ",$spfconfig['adviseOnReferer'] . '<br />';
 echo "logOnReferer: ",$spfconfig['logOnReferer'] . '<br />';
 echo "warnBanned: ",$spfconfig['warnBanned'] . '<br />';
 echo "adviseOnBan: ",$spfconfig['adviseOnBan'] . '<br />';
 echo "logOnBan: ",$spfconfig['logOnBan'] . '<br />';
 echo "chkFormRefNotSelf: ",$spfconfig['chkFormRefNotSelf'] . '<br />';
 echo "chkFormRefOwnServer: ",$spfconfig['chkFormRefOwnServer'] . '<br />';
 echo "chkFormRefNotBlank: ",$spfconfig['chkFormRefNotBlank'] . '<br />';
?>
