<?php
/**
 * SPform Build Script
 *
 * @name SPform
 * @version 3.0.8
 * @release beta
 * @author BobRay <bobray@softville.com>
 */
global $modx;

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

/* The name of the package as it will appear in Workspaces will be this plus
 * the next two variables */
$package_name = 'spform';
$package_version = '3.0.9';
$package_release = 'beta1';


/* override with your own defines here (see build.config.sample.php */
require_once dirname(__FILE__).'/build.config.php';
require_once MODX_CORE_PATH . 'model/modx/modx.class.php';

$modx= new modX();
$modx->initialize('mgr');
echo '<pre>'; /* used for nice formatting for log messages  */
$modx->setLogLevel(MODX_LOG_LEVEL_INFO);
$modx->setLogTarget('ECHO');
    /* $modx->setDebug(true); */

$modx->loadClass('transport.modPackageBuilder','',false, true);
$builder = new modPackageBuilder($modx);
$builder->createPackage($package_name,$package_version,$package_release);
$builder->registerNamespace($packageNamespace,false,true);

/* create category */
$attr = array(
    XPDO_TRANSPORT_UNIQUE_KEY => 'category',
    XPDO_TRANSPORT_PRESERVE_KEYS => false,
    XPDO_TRANSPORT_UPDATE_OBJECT => true,
    XPDO_TRANSPORT_RELATED_OBJECTS => true,
    XPDO_TRANSPORT_RELATED_OBJECT_ATTRIBUTES => array (
        'Snippets' => array (
            XPDO_TRANSPORT_PRESERVE_KEYS => false,
            XPDO_TRANSPORT_UPDATE_OBJECT => true,
            XPDO_TRANSPORT_UNIQUE_KEY => 'name',
        ),
        'Chunks' => array (
            XPDO_TRANSPORT_PRESERVE_KEYS => false,
            XPDO_TRANSPORT_UPDATE_OBJECT => true,
            XPDO_TRANSPORT_UNIQUE_KEY => 'name',
        ),
    )
);
$categoryObject= $modx->newObject('modCategory');
$categoryObject->set('id',1);
$categoryObject->set('category','SPForm');

/* add snippets to category */
$snippets = require_once $sources['data'].'transport.snippets.php';
$categoryObject->addMany($snippets);

/* add chunks to category */
$chunks = require_once $sources['data'].'transport.chunks.php';
$categoryObject->addMany($chunks);

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


/* Add the resources (documents).
 * Note that these will appear in the Manager Tree in reverse order
 * from the order you use here*/
$resources = require_once $sources['data'].'transport.resources.php';
$attributes= array(
    XPDO_TRANSPORT_UNIQUE_KEY => 'pagetitle',
    XPDO_TRANSPORT_UPDATE_OBJECT => false,
    XPDO_TRANSPORT_PRESERVE_KEYS => false,
);
foreach ($resources as $k => $resource) {
    $vehicle = $builder->createVehicle($resource,$attributes);
    if ($resource->get('pagetitle') == 'Thank You') {
        $vehicle->resolve('php',array(
            'type' => 'php',
            'source' => $sources['build'] . 'install-script.php',
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
    'setup-options' => array(
        'source' => $sources['build'] . 'user_input.php',
    ),
));


/* load lexicon strings */
$builder->buildLexicon($sources['lexicon']);

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

exit();