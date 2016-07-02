<?php
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

global $xoopsDB, $xoopsConfig, $xoopsModule;
include('admin_header.php');
include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php');
xoops_cp_header();
//adminmenu(-1);

if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/help.php')) {
    include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/help.php');
} else {
    include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/english/help.php');
}

//adminfooter();
//xoops_cp_footer();
include_once __DIR__ . '/admin_footer.php';
