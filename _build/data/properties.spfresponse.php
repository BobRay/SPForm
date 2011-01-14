<?php
/**
 * @package spform
 * @subpackage build
 */

$properties = array (
    array(
        'name'=>'takeMeBack',
        'desc'=>'spf_takemeback_desc',
        'type'=>'combo-boolean',
        'options'=>'',
        'lexicon'=>'spform:properties',
        'value'=>'1'
    ),
    array(
        'name'=>'spfresponseTpl',
        'desc'=>'spf_spfresponsetpl_desc',
        'type'=>'textfield',
        'options'=>'',
        'lexicon'=>'spform:properties',
        'value'=>'spfresponseTpl'
    ),
    array(
        'name'=>'spfDebug',
        'desc'=>'spf_spfdebug_desc',
        'type'=>'combo-boolean',
        'options'=>'',
        'lexicon'=>'spform:properties',
        'value'=>'0',

    )
);


return $properties;
