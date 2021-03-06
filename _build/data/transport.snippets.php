<?php

/**
 * Snippet object array for the SPForm package
 * @author Bob Ray
 * 1/15/11
 *
 * @package spform
 * @subpackage build
 */


$snippets = array();

$snippets[0]= $modx->newObject('modSnippet');
$snippets[0]->fromArray(array(
    'id' => 1,
    'name' => 'SPForm',
    'description' => 'SPForm '.PKG_VERSION.'-'.PKG_RELEASE
            .' -  Creates a contact form for your site',
),'',true,true);
$snippets[0]->setContent(file_get_contents($sources['source_core'] . '/spform.inc.php'));
$properties = include $sources['data'].'properties.spform.php';
$snippets[0]->setProperties($properties);
unset($properties);


$snippets[1]= $modx->newObject('modSnippet');
$snippets[1]->fromArray(array(
    'id' => 2,
    'name' => 'SPFResponse',
    'description' => 'SPForm "Thank You" page',
),'',true,true);
$snippets[1]->setContent(file_get_contents($sources['source_core'] . '/spfresponse.inc.php'));
$properties = include $sources['data'].'properties.spfresponse.php';
$snippets[1]->setProperties($properties);
unset($properties);

return $snippets;


