<?php
/**
 * Install resolver for
 *
 * @package spform
 * @subpackage build
 */
$success = false;
$object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Running PHP Resolver.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        /* get thank you resource */
        $resource = $object->xpdo->getObject('modResource',array(
            'pagetitle' => 'Thank You',
        ));
        if ($resource == null) {
            $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not find Thank You resource.');
            return false;
        }

        $temp_spfresponse_id = (integer) $resource->get('id');
        $myServer = $_SERVER['HTTP_HOST'];

        $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Setting recipientArray.');

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
          $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not get SPForm object');
        } else {
            $newRecipientArray = 'Webmaster :' . $options['user_email'];
            $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Setting recipientArray: ' . $newRecipientArray);
            $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Setting errorsTo: ' . $options['user_email'] );
            $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Setting spfResponseID: ' . $temp_spfresponse_id);
            $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Setting formProcAllowedReferers: ' . $myServer);




            $props = array(

                array (
                    'name'=>'recipientArray',
                    'desc'=>'spf_recipientarray_desc',
                    'type'=>'textfield',
                    'options'=>'',
                    'lexicon'=>'spform:properties',
                    'value'=>$newRecipientArray
                ),


                array(
                    'name'=>'errorsTo',
                    'desc'=>'spf_errorsto_desc',
                    'type'=>'textfield',
                    'options'=>'',
                    'lexicon'=>'spform:properties',
                    'value'=>$options['user_email']
                ),
                array(
                    'name'=>'spfResponseID',
                    'desc'=>'spf_spfresponseid_desc',
                    'type'=>'integer',
                    'options'=>'',
                    'lexicon'=>'spform:properties',
                    'value'=>$temp_spfresponse_id
                ),
                array(
                    'name'=>'formProcAllowedReferers',
                    'desc'=>'spf_formprocallowedreferers_desc',
                    'type'=>'textfield',
                    'options'=>'',
                    'lexicon'=>'spform:properties',
                    'value'=>$myServer


                )

            );


             if ($obj->setProperties($props, true) == false) {
                 $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not set properties of SPForm object');
             }


            if ($obj->save() == false ) {
                $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not save SPForm properties');
            }
        }

        /* This just loads and saves the SPFResponse snippet unchanged so it will appear last in the tree */
        $obj = $object->xpdo->getObject('modSnippet',array('name'=>'SPFResponse'));
        if (!$obj) {
          $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not get SPFResponse object');
        } else {

            if ($obj->save() == false ) {
                $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not save SPForm properties');
            }
        }

        /* Give the two resources the default template  */


        $default_template = $object->xpdo->getOption('default_template');

        $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Setting Contact and Thank You pages to default template: ' . $default_template);

        /* First the Contact page  */
        $obj = $object->xpdo->getObject('modResource',array('pagetitle'=>'Contact'));
        $temp_spform_id = (integer) $obj->id; /* used below to set the Thank You page parent */
        if (!$obj) {
          $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not get "Contact" Resource');
        } else {
            /* store ID of contact page for uninstall */
            $fp = fopen(MODX_CORE_PATH . 'components/spform/contactid.txt','w');
            fwrite($fp,$obj->get('id'));
            fclose($fp);
            $obj->set('template',$default_template);  /* give it the default template */
            $obj->set('isfolder',1);
            if ($obj->save() == false ) {
                $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not save SPForm properties');
            }
        }
        /*  Now the "Thank You" page  */
        $obj = $object->xpdo->getObject('modResource',array('pagetitle'=>'Thank You'));
        if (!$obj) {
          $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not get "Thank You" Resource');
        } else {
            $obj->set('template',$default_template);  /* give it the default template */
            $obj->set('parent',$temp_spform_id);   /* set parent to contact page */
            if ($obj->save() == false ) {
                $object->xpdo->log(xPDO::LOG_LEVEL_ERROR,'Could not save SPFResponse properties');
            }
        }

        $success =  true;
        break;
    case xPDOTransport::ACTION_UPGRADE:
        $fName = MODX_CORE_PATH . 'components/spform/banlist.inc.php';
        $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Upgrading SPForm.');
        if (file_exists($fName)) {
            $c = file_get_contents($fName);
            $chunkObj = $object->xpdo->getObject('modChunk', array('name'=>'spfBanlist'));
            if ($chunkObj && ! empty($c)) {
                $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Moving the content of your Banlist file into the new spfBanlist chunk.');
                $chunkObj->setContent($c);
                if ($chunkObj->save()) {
                     if (rename ($fName,$fName . 'bak'))
                         $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Renamed banlist file banlist.bak.');;
                }
            }
        }

        $success = true;
        break;
    case xPDOTransport::ACTION_UNINSTALL:
        $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Uninstalling . . .');
        $fp = fopen(MODX_CORE_PATH . 'components/spform/contactid.txt','r');
        if ($fp) {
            $id = fread($fp,20);
            $id = (int) $id;
            $obj = $object->xpdo->getObject('modResource',$id);
            fclose($fp);
        }
        if ($obj) {
            $object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Removing "Contact" and "Thank You" resources.');
            $obj->remove();
        } else {
            $object->xpdo->log(xPDO::LOG_LEVEL_WARN,'Note: You may have to remove the Contact and Thank You resources manually.');
        }
        $success = true;
        break;

}
$object->xpdo->log(xPDO::LOG_LEVEL_INFO,'Script resolver actions completed');
return $success;