<?php

/**
 * SPFResponse snippet for SPForm package
 *
 * Copyright 2011 Bob Ray
 *
 * @author Bob Ray
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
 * MODx SPFResponse Snippet
 *
 * @description SPFResponse snippet for SPForm package
  *
 * @package spform
 *
 * Properties
 * @property takemeback boolean - Put a "take me back" link on response page; default: 1.
 * @property spfresponsetpl string - SPF Response Template chunk name; default: spfresponseTpl.
 *
 * This snippet creates the "Thank You" page users are sent to
 * after successfully sending mail.
 *
 * @var $scriptProperties array
 * @see spform.inc.php
 * @see spformclass.inc.php
 * @see spformprocclass.inc.php
*/

/* ******************************************
Adapted from:  Many sources but particularly scform by James Seymour and CFFormProtect by Jake Munson
Compatibility: MODX Revolution
*******************************************/
global $modx;
//session_start();


$spf_key = $modx->getOption('emailsender');

if ( (strlen($spf_key) < 5) || ($_SESSION['include_auth'] != md5($spf_key)) ){
    return $modx->lexicon('unauthorized');
}
$spfconfig = $scriptProperties;

$language = !empty($spfconfig['language'])
    ? $spfconfig['language'] . ':'
    : '';

/* allow different language than used in Manager */
if (!empty($spfconfig['language'])) {
  $modx->setOption('cultureKey', $spfconfig['language']);
}


$modx->lexicon->load($language . 'spform:default');


/*  If spfCssPath parameter is missing, user default.
  * IF set to "", no css file.
 *  If it's set to a path, use that
 */
$cssPath = $modx->getOption('spfCssPath',$spfconfig,false);
if ($cssPath == false) {
    $spfCSS = $modx->getOption('assets_url') . "components/spform/css/spform.css";
    $modx->regClientCSS($spfCSS);

} else if (!empty($cssPath)) {
    $modx->regClientCSS($cssPath);
}
/* else do nothing, spfCssPath is set to "", user wants no spf css file.*/


if ($modx->getOption('spfDebug',$spfconfig,false)) {
    echo "spfresponseTpl: ",$spfconfig['spfresponseTpl'] . '<br />';
    echo "takeMeBack: ",$spfconfig['takeMeBack'] . '<br />';
    echo "spfCssPath: ",$spfconfig['spfCssPath'] . '<br />';
    echo "originalReferer: ",$_SESSION['origReferer'] . '<br />';
}


$modx->setPlaceholder('spf-thank-you',$modx->lexicon('thank-you'));


/* Create the "take me back" link, if possible  */

$originalReferer = $_SESSION['origReferer'];

if( (!empty($originalReferer)) && $modx->getOption('takeMeBack',$spfconfig,true)) {
    $spf_from = '<p>' . $modx->lexicon('came-from') . '</p>';
    $spf_back = '<p><a href="'. $originalReferer . '">' . $modx->lexicon('back') . '</a></p>';

} else {
    $spf_from = '';
    $spf_back = '';
}

$spfResponseTpl = $modx->getOption('spfresponseTpl',$spfconfig,'spfresponseTpl');
$o = $modx->getChunk($spfResponseTpl,array(
    'spf-back' => $spf_back,
    'spf-came-from' => $spf_from,
));
return $o;