<?php
/**
 * @package spform
 * @subpackage build
 */
 /* global $modx;

  $obj = $modx->getObject('modSnippet',array('name'=>'SPForm'));

  if (!$obj) {
      $output .= "Object not found<br>";
  }*/


/*$obj = $modx->getObject('modSnippet',array('name'=>'SPFResponse'));

  if (!$obj) {
      die("Object not found<br>");
  }
*/

$properties = array (
    array(
        'name'=>'takeMeBack',
        'desc'=>'Put a "take me back" link on response page',
        'type'=>'combo-boolean',
        'options'=>'',
        'value'=>'1'
    ),
    array(
        'name'=>'spfresponseTpl',
        'desc'=>'SPF Response Template chunk name',
        'type'=>'textfield',
        'options'=>'',
        'value'=>'spfresponseTpl'
    ),
    array(
        'name'=>'spfDebug',
        'desc'=>'Print debugging info - Do not leave this on for a working site',
        'type'=>'combo-boolean',
        'options'=>'',
        'value'=>'0'
    )
);

/* $obj->setProperties($spfResponseProperties);
  $obj->save();

  return $output;*/
?>
