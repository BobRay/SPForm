<?php
/**
 * SPform Build Script
 *
 * @name SPform
 * @version 3.0.7
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
    'spform' => $root . 'spform/',
    'build' => $root . '_build/',
    'lexicon' => $root . 'spform/lexicon/',
    'docs' => $root . 'spform/docs/'
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
$package_version = '3.0.7';
$package_release = 'beta';


/* Note that for file resolvers, the named directory itself is also packaged.
*  e.g. $source = /components/spform
*  $target = MODX_ASSETS_PATH".
*/

/* Array of snippets and chunks to be created.
 * Note that these will appear in the Manager Tree in the order
 * you use here.
 */

$objectArray = array (
    array (
        /* What is it? modSnippet, modChunk, modPlugin, etc. */
        'object_type' => 'modSnippet',

        /* name of your element as it will appear in the Manager */
        'name' => 'SPForm',

        /* description field in the element's editing page */
        'description' => 'SPForm 3.0.7-beta -  Creates a contact form for ' .
            'your site',

        /* What's the content field called. Note: this field for chunks is also
         * called "snippet" */
        'type' => 'snippet',

        /* Where's the file PB will use to create the element */
        'source_file' => $sources['spform'] . 'spform.inc.php',

        /* properties source file  */
        'props_file' => $sources['build'] . 'spformprops.inc.php',

        /* type of resolver */
        'resolver_type' => 'file',

        /* Files in this directory will be packaged  */
        'resolver_source' => $sources['spform'],

         /* Those files will go here  */
        'resolver_target' => "return MODX_ASSETS_PATH . 'components/';"

    ),

    array (

        'object_type' => 'modSnippet',
        'name' => 'SPFResponse',
        'description' => 'SPForm "Thank You" page',
        'type' => 'snippet',
        'source_file' => $sources['spform'] . 'spfresponse.inc.php',
        'props_file' => $sources['build'] . 'spfresponseprops.inc.php',
        'resolver_source' => ''

    ),


    array (

        'object_type' => 'modChunk',
        'name' => 'spformTpl',
        'description' => 'SPForm contact form template',
        'type' => 'snippet',
        'source_file' => $sources['spform'] . 'templates/spform.tpl',
        'props_file' => '',
        'resolver_source' => '',
        'resolver_target' => ''
    ),

    array (

        'object_type' => 'modChunk',
        'name' => 'spformprocTpl',
        'description' => 'SPForm error page template',
        'type' => 'snippet',
        'source_file' => $sources['spform'] . 'templates/spformproc.tpl',
        'props_file' => '',
        'resolver_source' => '',
        'resolver_target' => ''
    ),

    array (

        'object_type' => 'modChunk',
        'name' => 'spfresponseTpl',
        'description' => 'SPForm "Thank You" page template',
        'type' => 'snippet',
        'source_file' => $sources['spform'] . 'templates/spfresponse.tpl',
        'props_file' => '',
        'resolver_source' => '',
        'resolver_target' => ''
    ),

    array (

        'object_type' => 'modChunk',
        'name' => 'spfcaptchaTpl',
        'description' => 'SPForm captcha template',
        'type' => 'snippet',
        'source_file' => $sources['spform'] . 'templates/spfcaptcha.tpl',
        'props_file' => '',
        'resolver_source' => '',
        'resolver_target' => ''
    )

);
/*   Uncomment for debugging

foreach ($objectArray as $object) {
    echo "<br>object_type: " . $object['object_type'];
    echo "<br>name: " . $object['name'];
    echo "<br>description: " . $object['description'];
    echo "<br>type: " . $object['type'];
    echo "<br>source_file: " . $object['source_file'];
    echo "<br>category: " . $object['category'];
    echo "<br>props_file: " . $object['props_file'];
    echo "<br>resolver_source: " . $object['resolver_source'];
    echo "<br>resolver_target: " . $object['resolver_target'];
    echo "<br>";

}

die ("<br> Finished");
*/

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

/* array of objects -- used to set categories  */
$snippets = array();
$chunks = array();

/* loop to create snippets, and chunks  */

foreach($objectArray as $object) {

    if (!file_exists($object['source_file'])) {
        $modx->log(MODX_LOG_LEVEL_FATAL,'<b>Error</b> - Element source file not'
            . ' found: '.$object['source_file'].'<br />');
    }
    $modx->log(MODX_LOG_LEVEL_INFO,'Creating element from source file: ' .
            $object['source_file'].'<br />');

    /* You can get the source from the actual element in your database
     * OR manually create the object, grabbing the source from a file */
    echo '   Creating newObject of type '. $object['object_type'] . "\n";
    $c= $modx->newObject($object['object_type']);

    echo '   Setting name to ' . $object['name'] . "\n";
    $c->set('name', $object['name']);

    echo '   Setting description to ' . $object['description'] . "\n";
    $c->set('description', $object['description']);

    echo '   Setting ' . $object['type'] . ' from ' . $object['source_file']
         . "\n";

    $c->setContent(file_get_contents($object['source_file']));

    if($object['props_file'] != '') {
        require_once $object['props_file'];

        /* merge with current properties */
        $c->setProperties($properties, true);
    }

    if ($object['object_type'] == 'modSnippet' ) {
        $snippets[] = $c;
    }

    if ($object['object_type'] == 'modChunk') {
        $chunks[] = $c;
    }

    /* create a transport vehicle for the data object */
    $attributes= array(
        XPDO_TRANSPORT_UNIQUE_KEY => 'name',
        XPDO_TRANSPORT_UPDATE_OBJECT => true,
        XPDO_TRANSPORT_PRESERVE_KEYS => false

    );
    $vehicle = $builder->createVehicle($c, $attributes);

    if ($object['resolver_source'] != '') {
        $modx->log(MODX_LOG_LEVEL_INFO,"Creating Resolver<br />");

        if ($object['resolver_type'] == 'file'
         && !is_dir($object['resolver_source'])) {
            $modx->log(MODX_LOG_LEVEL_FATAL,'<b>Error</b> - Resolver source '
                    . 'directory not found: '.$object['resolver_source']
                    . '<br />');
        }

        $modx->log(MODX_LOG_LEVEL_INFO,'Source: '.$object['resolver_source']
            . '<br />');
        $modx->log(MODX_LOG_LEVEL_INFO,'Target: '.$object['resolver_target']
            . '<br /><br />');

        $vehicle->resolve($object['resolver_type'],array(
            'type' => $object['resolver_type'],
            'source' => $object['resolver_source'],
            'target' => $object['resolver_target'],
        ));

    }

    $builder->putVehicle($vehicle);

    unset($c);
}

/* done adding snippets and chunks */


/* create categories */

/* This sets the snippets' categories using the $snippet array  */



$attr = array(
    XPDO_TRANSPORT_UNIQUE_KEY => 'category',
    XPDO_TRANSPORT_PRESERVE_KEYS => false,
    XPDO_TRANSPORT_UPDATE_OBJECT => true,
    XPDO_TRANSPORT_RELATED_OBJECTS => true,
    XPDO_TRANSPORT_RELATED_OBJECT_ATTRIBUTES => array (
        'modSnippet' => array (
            XPDO_TRANSPORT_PRESERVE_KEYS => false,
            XPDO_TRANSPORT_UPDATE_OBJECT => true,
            XPDO_TRANSPORT_UNIQUE_KEY => 'name',
        )
    )
);

$categoryObject= $modx->newObject('modCategory');
$categoryObject->set('category','spform-snippets');

$categoryObject->addMany($snippets,'modSnippet');

$vehicle = $builder->createVehicle($categoryObject,$attr);
$builder->putVehicle($vehicle);

/* Now we'll set the chunks' category using the $chunks array */

$attr = array(
    XPDO_TRANSPORT_UNIQUE_KEY => 'category',
    XPDO_TRANSPORT_PRESERVE_KEYS => false,
    XPDO_TRANSPORT_UPDATE_OBJECT => true,
    XPDO_TRANSPORT_RELATED_OBJECTS => true,
    XPDO_TRANSPORT_RELATED_OBJECT_ATTRIBUTES => array (
        'modChunk' => array (
            XPDO_TRANSPORT_PRESERVE_KEYS => false,
            XPDO_TRANSPORT_UPDATE_OBJECT => true,
            XPDO_TRANSPORT_UNIQUE_KEY => 'name',
        )
    )
);

$categoryObject= $modx->newObject('modCategory');
$categoryObject->set('category','spform-chunks');

$categoryObject->addMany($chunks,'modChunk');

$vehicle = $builder->createVehicle($categoryObject,$attr);
$builder->putVehicle($vehicle);


/* done setting categories */

/* Now we'll add the resources (documents).
 * Note that these will appear in the Manager Tree in reverse order
 * from the order you use here*/


$modx->log(MODX_LOG_LEVEL_INFO,'Creating resource: Contact Page<br />');
$r = $modx->newObject('modResource');
$r->set('class_key','modDocument');
$r->set('context_key','web');
$r->set('type','document');
$r->set('contentType','text/html');
$r->set('pagetitle','Contact');
$r->set('longtitle','Contact Us');
$r->set('description','Spam-proof Contact Form');
$r->set('alias','contact');
$r->set('published',1);
$r->set('parent',0);
$r->set('isfolder',0);
$r->setContent('[[!SPForm]]');
$r->set('richtext',0);
$r->set('menuindex',99);
$r->set('searchable',0);
$r->set('cacheable',1);
$r->set('menutitle','Contact Us');
$r->set('donthit',0);
$r->set('hidemenu',0);
   $attributes= array(
        XPDO_TRANSPORT_UNIQUE_KEY => 'pagetitle',
        XPDO_TRANSPORT_UPDATE_OBJECT => true,
        XPDO_TRANSPORT_PRESERVE_KEYS => false

    );


$vehicle = $builder->createVehicle($r, $attributes);
$builder->putVehicle($vehicle);

unset($r);

/* and a second resource */

$modx->log(MODX_LOG_LEVEL_INFO,'Creating resource: Response Page<br />');
$r = $modx->newObject('modResource');
$r->set('class_key','modDocument');
$r->set('context_key','web');

$r->set('type','document');
$r->set('contentType','text/html');
$r->set('pagetitle','Thank You');
$r->set('longtitle','Thank You');
$r->set('description','Spam-proof Contact Form "Thank You" page');
$r->set('alias','thankyou');
$r->set('published',1);
$r->set('parent',0);
$r->set('isfolder',0);
$r->setContent('[[!SPFResponse]]');
$r->set('richtext',0);
$r->set('searchable',0);
$r->set('cacheable',1);
$r->set('donthit',1);
$r->set('hidemenu',1);
   $attributes= array(
        XPDO_TRANSPORT_UNIQUE_KEY => 'pagetitle',
        XPDO_TRANSPORT_UPDATE_OBJECT => true,
        XPDO_TRANSPORT_PRESERVE_KEYS => false

    );




$vehicle = $builder->createVehicle($r, $attributes);

 $vehicle->resolve('php',array(
            'type' => 'php',
            'source' => $sources['build'] . 'install-script.php',
            'target' => "return '" . $sources['build'] . "';"

        ));



$builder->putVehicle($vehicle);
unset($r);


/* done building package */

/* now pack in the license file, readme and setup options */

$builder->setPackageAttributes(array(
    'readme' => file_get_contents($sources['docs'] . 'readme.txt'),
    'license' => file_get_contents($sources['docs'] . 'license.txt'),
    'setup-options' => file_get_contents($sources['build'] . 'user_input.html')
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