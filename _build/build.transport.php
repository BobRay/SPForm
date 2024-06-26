<?php

/**
 * SPForm build script
 *
 * Copyright 2011-2017 Bob Ray
 * @author Bob Ray <https://bobsguides.com>
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
 * Description: SPForm build script
 * @package spform
 * @subpackage build
 */

define('MODX_BASE_URL','http://localhost/addons/');
define('MODX_MANAGER_URL','http://localhost/addons/manager/');
define('MODX_ASSETS_URL','http://localhost/addons/assets/');
define('MODX_CONNECTORS_URL','http://localhost/addons/connectors/');


define('PKG_NAME','SPForm');
define('PKG_NAME_LOWER','spform');
define('PKG_VERSION','3.3.5');
define('PKG_RELEASE','pl');


$mtime = microtime();
$mtime = explode(" ", $mtime);
$mtime = $mtime[1] + $mtime[0];
$tstart = $mtime;
set_time_limit(0);

$root = dirname(dirname(__FILE__)).'/';
$sources= array (
    'root' => $root,
    'build' => $root . '_build/',
    'data' => $root . '_build/data/',
    'lexicon' => $root . 'core/components/spform/lexicon/',
    'docs' => $root . 'core/components/spform/docs/',
    'source_assets' => $root . 'assets/components/spform',
    'source_core' => $root . 'core/components/spform',
);
unset($root);


$packageNamespace = 'spform';
/* This example assumes that you are creating one element with one namespace, a
 * lexicon, and one file resolver.  You'll need to modify it if your situation
 * is different. A snippet with no support files (no images, no css, no js
 * includes, etc.) doesn't need a file  resolver so you can comment out that
 * part of the code. If you have no lexicon, you can comment out that part of
 * the code. If you need to create multiple  elements (e.g. a snippet, several
 * chunks, and maybe a plugin) you can do it all in this file, but you'll have
 * to duplicate the code below that creates  and packages the element. You'll
 * also have to reset the variables for each segment. If you put all your
 * support files in or below in a single  directory, you'll only need one file
 * resolver.
*/

/* override with your own defines here (see build.config.sample.php */
require_once dirname(__FILE__).'/build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
echo '<pre>'; /* used for nice formatting for log messages  */
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
    /* $modx->setDebug(true); */

$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage(PKG_NAME_LOWER,PKG_VERSION,PKG_RELEASE);
$builder->registerNamespace(PKG_NAME_LOWER,false,true,'{core_path}components/'.PKG_NAME_LOWER.'/');

/* create category */
$attr = array(
    xPDOTransport::UNIQUE_KEY => 'category',
    xPDOTransport::PRESERVE_KEYS => false,
    xPDOTransport::UPDATE_OBJECT => true,
    xPDOTransport::RELATED_OBJECTS => true,
    xPDOTransport::RELATED_OBJECT_ATTRIBUTES => array (
        'Snippets' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
        'Chunks' => array (
            xPDOTransport::PRESERVE_KEYS => false,
            xPDOTransport::UPDATE_OBJECT => true,
            xPDOTransport::UNIQUE_KEY => 'name',
        ),
    )
);
/** @var $categoryObject modCategory */
$categoryObject= $modx->newObject('modCategory');
$categoryObject->set('id',1);
$categoryObject->set('category','SPForm');

/* add snippets to category */
/** @var $snippets array(modSnippet) */
$snippets = require_once $sources['data'].'transport.snippets.php';
$categoryObject->addMany($snippets,'Snippets');

/* add chunks to category */
$chunks = require_once $sources['data'].'transport.chunks.php';
$categoryObject->addMany($chunks,'Chunks');

/* build category */
$vehicle = $builder->createVehicle($categoryObject,$attr);
$vehicle->resolve('file',array(
    'source' => $sources['source_assets'],
    'target' => "return MODX_ASSETS_PATH . 'components/';",
));
$vehicle->resolve('file',array(
    'source' => $sources['source_core'],
    'target' => "return MODX_CORE_PATH . 'components/';",
));
$builder->putVehicle($vehicle);

/* done setting category/snippets/chunks */


/* Add the resources (documents) */
$resources = require_once $sources['data'].'transport.resources.php';
$attributes= array(
    xPDOTransport::UNIQUE_KEY => 'pagetitle',
    xPDOTransport::UPDATE_OBJECT => false,
    xPDOTransport::PRESERVE_KEYS => false,
);
foreach ($resources as $k => $resource) {
    /** @var $vehicle modTransportVehicle
     *  @var $resource modResource */
    $vehicle = $builder->createVehicle($resource,$attributes);
    if ($resource->get('pagetitle') == 'Thank You') {
        $modx->log(modX::LOG_LEVEL_INFO,'Packaging install script.<br />');
        $vehicle->resolve('php',array(
            'type' => 'php',
            'source' => $sources['build'] . 'install.script.php',
            'target' => "return '" . $sources['build'] . "';"
        ));
    }
    $builder->putVehicle($vehicle);
}

/* done building package */
/* now pack in the license file, readme and setup options */
$builder->setPackageAttributes(array(
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'changelog' => file_get_contents($sources['docs'] . 'changelog.txt'),
    'setup-options' => array(
        'source' => $sources['build'] . 'user.input.php',
    ),
));


/* zip up the package  */
$builder->pack();

$mtime= microtime();
$mtime= explode(" ", $mtime);
$mtime= $mtime[1] + $mtime[0];
$tend= $mtime;
$totalTime= ($tend - $tstart);
$totalTime= sprintf("%2.4f s", $totalTime);

$modx->log(MODX_LOG_LEVEL_INFO,'Package completed.<br />Execution time: '
        . $totalTime . '<br />');
session_write_close();
exit();
