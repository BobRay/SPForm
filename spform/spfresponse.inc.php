<?php
/**
* This snippet creates the "Thank You" page users are sent to
* after successfully sending mail.
* @package spform
*
* @see spform.inc.php
* @see spformclass.inc.php
* @see spformprocclass.inc.php
* @author  Bob Ray <bobray@softville.com>
* @created 10/04/2008
* @version 3.0.7
*/


/* ******************************************
File:         spfresponse.inc.php

Snippet:       SPForm
Version: 3.0.7
$Revision: 259 $
$Author: Bob Ray $
$Date: 2008-11-23 18:37:55 -0600 (Sun, 23 Nov 2008) $
Adapted from:  Many sources but particularly scform by James Seymour and CFFormProtect by Jake Munson
Compatibility: MODX Revolution

*******************************************/


    global $modx;
    session_start();

    $modx->lexicon->load('spform:default');
    $spf_key = $modx->config['emailsender'];

    if ( (strlen($spf_key) < 5) || ($_SESSION['include_auth'] != md5($spf_key)) ){
        die ($modx->lexicon('unauthorized'));
    }
    $spfconfig = $scriptProperties;



    /*  If spfCssPath parameter is missing, user default.
      * IF set to "", no css file.
     *  If it's set to a path, use that
     */
    if (!isset($spfconfig['spfCssPath'])) {

        $spfCSS = MODX_ASSETS_PATH . "components/spform/css/spform.css";
        $modx->regClientCSS($spfCSS);

    } else if (isset($spfconfig['spfCssPath']) && $spfconfig['spfCssPath'] != "" ) {

        $spfCSS = $spfconfig['spfCssPath'];
        $modx->regClientCSS($spfCSS);

    }  /* else do nothing, spfCssPath is set to "", user wants no spf css file.*/


    if ($spfconfig['spfDebug']) {
        echo "spfresponstTpl: ",$spfconfig['spfresponseTpl'] . "<br>";
        echo "takeMeBack: ",$spfconfig['takeMeBack'] . "<br>";
        echo "spfCssPath: ",$spfconfig['spfCssPath'] . "<br>";
        echo "originalReferer: ",$_SESSION['origReferer'] . "<br>";
    }


    $modx->setPlaceholder('spf-thank-you',$modx->lexicon('thank-you'));


    /* Create the "take me back" link, if possible  */

    $originalReferer = $_SESSION['origReferer'];

    if( (!empty($originalReferer)) && ($spfconfig['takeMeBack'] ) )  {
        $spf_from = '<p>' . $modx->lexicon('came-from') . '</p>';
        $spf_back = '<p><a href="'. $originalReferer . '">' . $modx->lexicon('back') . '</a></p>';

    } else {
        $spf_from = "";
        $spf_back = "";
    }

    return ($modx->getChunk($spfconfig['spfresponseTpl'],array('spf-back'=>$spf_back, 'spf-came-from'=>$spf_from)));


?>
