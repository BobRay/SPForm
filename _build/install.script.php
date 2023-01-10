<?php

/**
 * SPForm resolver script - runs on install.
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
 * Description: Resolver script for SPForm package
 * @package spform
 * @subpackage build
 *
 * @var $object modX
 * @var $options array
 * @var $modx modx
 */

$success = false;
$modx =& $object->xpdo;

$prefix = $modx->getVersionData()['version'] >= 3
    ? 'MODX\Revolution\\'
    : '';

$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Resolver.');
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        /* get thank you resource */
        /** @var modResource $thanksPage */
        $thanksPage = $modx->getObject($prefix . 'modResource',array(
            'alias' => 'thankyou',
        ));
        if ($thanksPage == null) {
            $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not find resource with alias "thankyou".');
            return false;
        }
        /** @var string $c */
        $c = $thanksPage->getContent();

        if (strpos($c, '[[!SPFResponse]]') === false) {
            /* not our thank-you page */
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'Site already has a resource with alias "thankyou". Please change its alias and try again.');
            return false;
        }

        /** @var modResource $contactPage */
        $contactPage = $modx->getObject($prefix . 'modResource', array('alias' => 'contact'));

        if (!$contactPage) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not get "Contact" Resource');
             return false;
        }

        $c = $contactPage->getContent();

        if (strpos($c, '[[!SPForm]]') === false) {
            /* not our contact page */
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'Site already has a resource with alias "contact". Please change its alias and try again.');
            return false;
        }
        $temp_spform_id = (integer)$contactPage->id; /* used below to set the Thank-You page parent */
        $temp_spfresponse_id = (integer) $thanksPage->get('id');
        $myServer = $_SERVER['HTTP_HOST'];
        $default_template = $modx->getOption('default_template');

        $modx->log(xPDO::LOG_LEVEL_INFO, 'Setting Contact and Thank You pages to default template: ' . $default_template);

        /* store ID of contact page for uninstall */
        $fp = fopen(MODX_CORE_PATH . 'components/spform/contactid.txt', 'w');
        fwrite($fp, $temp_spform_id);
        fclose($fp);
        $contactPage->set('template', $default_template);  /* give it the default template */
        $contactPage->set('isfolder', 1);
        if ($contactPage->save() === false) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not save Contact page');
        }

        /*  Now the "Thank You" page  */
        $thanksPage->set('template', $default_template);  /* give it the default template */
        $thanksPage->set('parent', $temp_spform_id);   /* set parent to contact page */
        if ($thanksPage->save() === false) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not save Thanks page');
        }

        /* Set recipient array in snippet properties */
        $modx->log(xPDO::LOG_LEVEL_INFO,'Setting recipientArray.');

        if (strstr($myServer,'www')) {
            $temp = str_replace('www.','',$myServer);
            $myServer = $myServer . ',' . $temp;
        } else {
            $myServer = 'www.' .$myServer . ',' . $myServer;
        }

        /* get snippet */
        /** @var $snippet modSnippet */
        $snippet = $modx->getObject($prefix . 'modSnippet',array(
            'name'=>'SPForm'
        ));
        if (!$snippet) {
          $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not get SPForm snippet object');
        } else {
            $newRecipientArray = 'Webmaster :' . $options['user_email'];
            $modx->log(xPDO::LOG_LEVEL_INFO,'Setting recipientArray: ' . $newRecipientArray);
            $modx->log(xPDO::LOG_LEVEL_INFO,'Setting errorsTo: ' . $options['user_email'] );
            $modx->log(xPDO::LOG_LEVEL_INFO,'Setting spfResponseID: ' . $temp_spfresponse_id);
            $modx->log(xPDO::LOG_LEVEL_INFO,'Setting formProcAllowedReferers: ' . $myServer);

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

             if ($snippet->setProperties($props, true) == false) {
                 $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not set properties of SPForm object');
             }

            if ($snippet->save() === false ) {
                $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not save SPForm properties');
            }
        }

        /* This just loads and saves the SPFResponse snippet unchanged, so it will appear last in the tree */
        $obj = $modx->getObject($prefix . 'modSnippet',array('name'=>'SPFResponse'));
        if (!$obj) {
          $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not get SPFResponse object');
        } else {

            if ($obj->save() == false ) {
                $modx->log(xPDO::LOG_LEVEL_ERROR,'Could not save SPForm properties');
            }
        }
        $success =  true;
        break;

    case xPDOTransport::ACTION_UPGRADE:
        $fName = MODX_CORE_PATH . 'components/spform/banlist.inc.php';
        $modx->log(xPDO::LOG_LEVEL_INFO,'Upgrading SPForm.');
        if (file_exists($fName)) {
            $c = file_get_contents($fName);
            $chunkObj = $modx->getObject($prefix . 'modChunk', array('name'=>'spfBanlist'));
            if ($chunkObj && ! empty($c)) {
                $modx->log(xPDO::LOG_LEVEL_INFO,'Moving the content of your Banlist file into the new spfBanlist chunk.');
                $chunkObj->setContent($c);
                if ($chunkObj->save()) {
                     if (rename ($fName,$fName . 'bak'))
                         $modx->log(xPDO::LOG_LEVEL_INFO,'Renamed banlist file banlist.bak.');;
                }
            }
        }

        $success = true;
        break;

    case xPDOTransport::ACTION_UNINSTALL:
        /** @var $obj modResource
         *  @var $child modResource
         * */
        $modx->log(xPDO::LOG_LEVEL_INFO,'Uninstalling . . .');
        $fp = fopen(MODX_CORE_PATH . 'components/spform/contactid.txt','r');
        if ($fp) {
            $id = fread($fp,20);
            $id = (int) $id;
            $obj = $modx->getObject($prefix . 'modResource',$id);

            fclose($fp);
        }
        if ($obj) {
            $modx->log(xPDO::LOG_LEVEL_INFO,'Removing "Contact" and "Thank You" resources.');
            $children = $obj->getMany('Children');
            $obj->remove();
            if (!empty ($children)) {
                foreach($children as $child) {
                    $child->remove();
                }
            }
        } else {
            $modx->log(xPDO::LOG_LEVEL_WARN,'Note: You may have to remove the Contact and Thank You resources manually.');
        }
        $success = true;
        break;

}
$modx->log(xPDO::LOG_LEVEL_INFO,'Script resolver actions completed');
return $success;