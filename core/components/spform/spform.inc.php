<?php
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
* @version 3.0.8
*
*/

/* error_reporting(E_ALL); */
/* ******************************************
File:         spform.inc.php

Snippet:       SPForm
Version: 3.0.8
$Revision: 259 $
$Author: Bob Ray $
$Date: 2008-11-23 18:37:55 -0600 (Sun, 23 Nov 2008) $
Adapted from:  Many sources but particularly scform by James Seymour and CFFormProtect by Jake Munson
Compatibility: MODX Revolution
Completely re-factored for MODx Revolution

*******************************************/

global $modx;
/* $modx->setDebug(E_ALL & ~E_NOTICE); */

$spfconfig = $scriptProperties;
$spconfig['spformPath'] = $modx->getOption('spformPath',$spfconfig,$modx->getOption('assets_path').'components/spform');

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