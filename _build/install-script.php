<?php
/**
 * Install resolver for
 *
 * @package spform
 * @subpackage build
 */
$success = false;
$object->xpdo->log(XPDO_LOG_LEVEL_INFO,'Running install script.');
switch($options[XPDO_TRANSPORT_PACKAGE_ACTION]) {
    case XPDO_TRANSPORT_ACTION_INSTALL:
        /* get thank you resource */
        $resource = $object->xpdo->getObject('modResource',array(
            'pagetitle' => 'Thank You',
        ));
        if ($resource == null) {
            $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not find Thank You resource.');
            return false;
        }

        $temp_spfresponse_id = (integer) $resource->get('id');
        $myServer = $_SERVER['HTTP_HOST'];

        if (strstr($myServer,'www')) {
            $temp = str_replace('www.','',$myServer);
            $myServer = $myServer . ',' . $temp;
        } else {
            $myServer = 'www.' .$myServer . ',' . $myServer;
        }

        /* get snippet */
        $obj = $object->xpdo->getObject('modSnippet',array(
            'name'=>'SPForm'
        ));
        if (!$obj) {
          $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not get SPForm object');
        } else {

            $newRecipientArray = 'Webmaster :' . $options['user_email'];

            $props = array(

                array (
                    'name'=>'recipientArray',
                    'desc'=>'Recipients',
                    'type'=>'textfield',
                    'options'=>'',
                    'value'=>$newRecipientArray
                ),


                array(
                    'name'=>'errorsTo',
                    'desc'=>'Where to email error reports',
                    'type'=>'textfield',
                    'options'=>'',
                    'value'=>$options['user_email']
                ),
                array(
                    'name'=>'spfResponseID',
                    'desc'=>'Resource ID of SPFResponse page. This value will be set automatically on the first visit to the form.',
                    'type'=>'integer',
                    'options'=>'',
                    'value'=>$temp_spfresponse_id
                ),
                array(
                    'name'=>'formProcAllowedReferers',
                    'desc'=>'Comma separated list of allowed referers. Be sure this lists all the domains by which your contact page can be reached.',
                    'type'=>'textfield',
                    'options'=>'',
                    'value'=>$myServer


                )

            );


             if ($obj->setProperties($props, true) == false) {
                 $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not set properties of SPForm object');
             }


            if ($obj->save() == false ) {
                $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not save SPForm properties');
            }
        }

        /* This just loads and saves the SPFResponse snippet unchanged so it will appear last in the tree */
        $obj = $object->xpdo->getObject('modSnippet',array('name'=>'SPFResponse'));
        if (!$obj) {
          $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not get SPFResponse object');
        } else {

            if ($obj->save() == false ) {
                $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not save SPForm properties');
            }
        }

        /* Give the two resources the default template  */

        $default_template = $object->xpdo->getOption('default_template');

        /* First the Contact page  */
        $obj = $object->xpdo->getObject('modResource',array('pagetitle'=>'Contact'));
        $temp_spform_id = (integer) $obj->id; /* used below to set the Thank You page parent */
        if (!$obj) {
          $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not get "Contact" Resource');
        } else {

            $obj->set('template',$default_template);  /* give it the default template */
            $obj->set('isfolder',1);
            if ($obj->save() == false ) {
                $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not save SPForm properties');
            }
        }
        /*  Now the "Thank You" page  */
        $obj = $object->xpdo->getObject('modResource',array('pagetitle'=>'Thank You'));
        if (!$obj) {
          $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not get "Thank You" Resource');
        } else {
            $obj->set('template',$default_template);  /* give it the default template */
            $obj->set('parent',$temp_spform_id);   /* set parent to contact page */
            if ($obj->save() == false ) {
                $object->xpdo->log(XPDO_LOG_LEVEL_ERROR,'Could not save SPFResponse properties');
            }
        }

        $success =  true;
        break;
    case XPDO_TRANSPORT_ACTION_UPGRADE:
    case XPDO_TRANSPORT_ACTION_UNINSTALL:
        $success = true;
        break;

}
return $success;