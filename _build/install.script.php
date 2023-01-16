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

/** @var xPDOTransport $transport */

if ($transport->xpdo) {
    $modx =& $transport->xpdo;
} else {
    $modx =& $object->xpdo;
}

if (! $modx instanceof modX) {
    die("no MODX");
}
$prefix = $modx->getVersionData()['version'] >= 3
    ? 'MODX\Revolution\\'
    : '';

$modx->log(xPDO::LOG_LEVEL_INFO,'Running PHP Resolver.');

$action = $options[xPDOTransport::PACKAGE_ACTION];

/* Stuff that should happen for both upgrade and install */
if ($action !== xPDOTransport::ACTION_UNINSTALL) {
    /** @var modResource $contactPage */
    $contactPage = $modx->getObject($prefix . 'modResource', array('alias' => 'contact'));

    if (!$contactPage) {
        $modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not get "Contact" Resource');
        return false;
    }

    $c = $contactPage->getContent();

    if (strpos($c, '[[!SPForm') === false) {
        /* not our contact page */
        $modx->log(xPDO::LOG_LEVEL_ERROR, 'Site already has a resource with alias "contact". Please change its alias and try again.');
        return false;
    }
    $temp_spform_id = (integer)$contactPage->id; /* used below to set the Thank-You page parent */

    /* get thank you resource */
    $thanksPage = $modx->getObject($prefix . 'modResource', array(
        'alias' => 'thankyou',
    ));
    if ($thanksPage == null) {
        $modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not find resource with alias "thankyou".');
        return false;
    }
    /** @var string $c */
    $c = $thanksPage->getContent();

    if (strpos($c, '[[!SPFResponse]]') === false) {
        /* not our thank-you page */
        $modx->log(xPDO::LOG_LEVEL_ERROR, 'Site already has a resource with alias "thankyou". Please change its alias and try again.');
        return false;
    }

    $thanksPageId = $thanksPage->get('id');

    /* Set Contact form content from spformpropsTpl chunk,
       but only if it's a first install, not a reinstall */

    if (!file_exists(MODX_CORE_PATH . 'components/spform/contactid.txt')) {
        /* Set snippet properties */
        $modx->log(modX::LOG_LEVEL_INFO, 'Setting properties in contact resource tag');
        $props = array();

        $myServer = $_SERVER['HTTP_HOST'];
        /* remove port number, if any */
        $myServer = explode(':',$myServer)[0];
        $emailSender = $modx->getOption('emailsender', null);
        $recipients = $options['user_email'];
        $recipients = empty($recipients)
            ? $emailSender
            : $options['user_email'];
        $recipientArray = 'Webmaster :' . $recipients;

        $props['recipientArray'] = $recipients;
        $props['errorsTo'] = $emailSender;
        $props['recipientArray'] = $recipientArray;
        $props['formProcAllowedReferers'] = MODX_HTTP_HOST;
        $props['spfResponseId'] = $thanksPageId;

        $cc = $modx->getChunk('spformpropsTpl', $props);
        if (!$cc) {
           $modx->log(modX::LOG_LEVEL_ERROR, 'Could not find spformpropsTpl chunk');
        }
        $contactPage->setContent($cc);
        $contactPage->save();
    }
}

/* Separate operations for install, upgrade & uninstall */
switch($options[xPDOTransport::PACKAGE_ACTION]) {
    case xPDOTransport::ACTION_INSTALL:
        /** @var modResource $thanksPage */

        $temp_spfresponse_id = (integer) $thanksPage->get('id');

        $default_template = $modx->getOption('default_template');

        $modx->log(xPDO::LOG_LEVEL_INFO, 'Setting Contact and Thank You pages to default template: ' . $default_template);

        /* store ID of contact page for uninstall */
        $fp = fopen(MODX_CORE_PATH . 'components/spform/contactid.txt', 'w');
        fwrite($fp, $temp_spform_id);
        fclose($fp);

        /* give it the default template; make it a folder*/
        $contactPage->set('template', $default_template);
        $contactPage->set('isfolder', 1);
        if ($contactPage->save() === false) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not save Contact page');
        }

        /*  Now the "Thank You" page  */

        /* give it the default template */
        $thanksPage->set('template', $default_template);

        /* set parent to contact page */
        $thanksPage->set('parent', $temp_spform_id);
        if ($thanksPage->save() === false) {
            $modx->log(xPDO::LOG_LEVEL_ERROR, 'Could not save Thanks page');
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

        /* Moves Banlist file content to spfBanlist chunk if it
           hasn't been done already */
        if (file_exists($fName) && ! $modx->getChunk('spfBanlist')) {
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
        /** @var $contactResource modResource
         *  @var $child modResource
         * */
        $modx->log(xPDO::LOG_LEVEL_INFO,'Uninstalling . . .');
        $fp = fopen(MODX_CORE_PATH . 'components/spform/contactid.txt','r');
        if ($fp) {
            $id = fread($fp,20);
            $id = (int) $id;
            $contactResource = $modx->getObject($prefix . 'modResource',$id);
            fclose($fp);
        }
        if ($contactResource) {
            $modx->log(xPDO::LOG_LEVEL_INFO,'Removing "Contact" and "Thank You" resources.');
            $children = $contactResource->getMany('Children');
            if (!empty ($children)) {
                foreach ($children as $child) {
                    $child->remove();
                }
            }
            /* This is necessary, even though it generates a warning later */
            $contactResource->remove();

        } else {
            $modx->log(xPDO::LOG_LEVEL_WARN,'Note: You may have to remove the Contact and Thank You resources manually.');
        }

        $success = true;
        break;

}
$modx->log(xPDO::LOG_LEVEL_INFO,'Script resolver actions completed');
return $success;