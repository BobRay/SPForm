<?php

/**
 * Resource object array for the SPForm package
 * @author Bob Ray
 * 1/15/11
 *
 * @package spform
 * @subpackage build
 */

/* ToDo: Make sure "Thank You" page is published */
$resources = array();

$modx->log(modX::LOG_LEVEL_INFO,'Creating resource: Contact Page<br />');
$resources[1]= $modx->newObject('modResource');
$resources[1]->fromArray(array(
    'id' => 1,
    'class_key' => 'modResource',
    'context_key' => 'web',
    'type' => 'document',
    'contentType' => 'text/html',
    'pagetitle' => 'Contact',
    'longtitle' => 'Contact Us',
    'description' => 'Spam-proof Contact Form',
    'alias' => 'contact',
    'published' => 1,
    'parent' => 0,
    'isfolder' => 0,
    'richtext' => 0,
    'menuindex' => 99,
    'searchable' => 0,
    'cacheable' => 1,
    'menutitle' => 'Contact Us',
    'donthit' => 0,
    'hidemenu' => 0,
),'',true,true);
$resources[1]->setContent('[[!SPForm]]');

$modx->log(modX::LOG_LEVEL_INFO,'Creating resource: Response Page<br />');
$resources[2]= $modx->newObject('modResource');
$resources[2]->fromArray(array(
    'id' => 2,
    'class_key' => 'modResource',
    'context_key' => 'web',
    'type' => 'document',
    'contentType' => 'text/html',
    'pagetitle' => 'Thank You',
    'longtitle' => 'Thank You',
    'description' => 'Spam-proof Contact Form "Thank You" page',
    'alias' => 'thankyou',
    'published' => 1,
    'parent' => 0,
    'isfolder' => 0,
    'richtext' => 0,
    'menuindex' => 99,
    'searchable' => 0,
    'cacheable' => 1,
    'menutitle' => 'Thank You',
    'donthit' => 0,
    'hidemenu' => 1,
),'',true,true);
$resources[2]->setContent('[[!SPFResponse]]');

return $resources;
