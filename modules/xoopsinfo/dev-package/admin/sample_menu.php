<?php

declare(strict_types=1);

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2001 - 2006 <http://www.xoops.org/>
 *
 * Module: xoopsinfo 2.0
 * Licence : GPL
 * Authors :
 *              - Jmorris
 *              - Marco
 *              - Christian
 *              - DuGris (http://www.dugris.info)
 */
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

include_once(XOOPS_ROOT_PATH . '/class/uploader.php');
if (defined('_XI_MIMETYPE')) {
    $adminmenu[4]['title'] = 'Mime types';

    $adminmenu[4]['link'] = 'mimetypesadmin.php';
}
