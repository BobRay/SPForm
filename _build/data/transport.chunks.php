<?php
/**
 * @package spform
 * @subpackage build
 */
$chunks = array();

$chunks[1]= $modx->newObject('modChunk');
$chunks[1]->fromArray(array(
    'id' => 1,
    'name' => 'spformTpl',
    'description' => 'SPForm contact form template',
),'',true,true);
$chunks[1]->setContent(file_get_contents($sources['source_core'] . '/templates/spform.tpl'));

$chunks[2]= $modx->newObject('modChunk');
$chunks[2]->fromArray(array(
    'id' => 2,
    'name' => 'spformprocTpl',
    'description' => 'SPForm error page template',
),'',true,true);
$chunks[2]->setContent(file_get_contents($sources['source_core'] . '/templates/spformproc.tpl'));

$chunks[3]= $modx->newObject('modChunk');
$chunks[3]->fromArray(array(
    'id' => 3,
    'name' => 'spfresponseTpl',
    'description' => 'SPForm "Thank You" page template',
),'',true,true);
$chunks[3]->setContent(file_get_contents($sources['source_core'] . '/templates/spfresponse.tpl'));

$chunks[4]= $modx->newObject('modChunk');
$chunks[4]->fromArray(array(
    'id' => 4,
    'name' => 'spfcaptchaTpl',
    'description' => 'SPForm captcha template',
),'',true,true);
$chunks[4]->setContent(file_get_contents($sources['source_core'] . '/templates/spfcaptcha.tpl'));

return $chunks;