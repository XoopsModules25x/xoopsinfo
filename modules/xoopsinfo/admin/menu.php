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

if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}

include_once(XOOPS_ROOT_PATH . '/class/uploader.php');

include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/functions.php');
$phpsysinfo_path = XoopsInfo_moduleoption('xi_phpsysinfo_folder');
$phpsecinfo_path = XoopsInfo_moduleoption('xi_phpsecinfo_folder');

$moduleDirName = basename(dirname(__DIR__));

$moduleHandler = xoops_getHandler('module');
$module        = $moduleHandler->getByDirname($moduleDirName);
$pathIcon32    = '../../' . $module->getInfo('sysicons32');
$pathModIcon32 = './' . $module->getInfo('modicons32');
xoops_loadLanguage('modinfo', $module->dirname());

$xoopsModuleAdminPath = XOOPS_ROOT_PATH . '/' . $module->getInfo('dirmoduleadmin');
include_once $xoopsModuleAdminPath . '/language/english/main.php';


$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_HOME,
    'link'  => 'admin/index.php',
    'icon'  => $pathIcon32 . '/home.png'
);

$adminmenu[] = array(
    'title' => _MI_XI_ADMENU1,
    'link'  => 'admin/main.php',
    'icon'  => $pathIcon32 . '/manage.png'
);

$adminmenu[] = array(
    'title' => _MI_XI_ADMENU2,
    'link'  => 'admin/php.php',
    'icon'  => $pathIcon32 . '/administration.png'
);

$adminmenu[] = array(
    'title' => _MI_XI_ADMENU3,
    'link'  => 'admin/mysqlinfo.php',
    'icon'  => $pathIcon32 . '/list.png'
);



//if (!empty($phpsysinfo_path) && file_exists(XOOPS_ROOT_PATH . $phpsysinfo_path . '/index.php')) {
//    if (!defined("_PHPSYSINFO")) {
//        define('_PHPSYSINFO', 1);
//    }
    $adminmenu[] = array(
        'title' => _MI_XI_ADMENU8,
        'link'  => 'admin/phpsysinfo.php',
        'icon'  => $pathIcon32 . '/faq.png'
    );
//}

//if (!empty($phpsecinfo_path) && file_exists(XOOPS_ROOT_PATH . $phpsecinfo_path . '/index.php')) {
//    if (!defined("_PHPSECINFO")) {
//        define('_PHPSECINFO', 1);
//    }
    $adminmenu[] = array(
        'title' => _MI_XI_ADMENU9,
        'link'  => 'admin/phpsecinfo.php',
        'icon'  => $pathIcon32 . '/firewall.png'
    );
//}

$adminmenu[] = array(
    'title' => _MI_XI_ADMENU4,
    'link'  => 'admin/modules.php',
    'icon'  => $pathIcon32 . '/exec.png'
);

$adminmenu[] = array(
    'title' => _MI_XI_ADMENU5,
    'link'  => 'admin/editors.php',
    'icon'  => $pathIcon32 . '/translations.png'
);

$adminmenu[] = array(
    'title' => _MI_XI_ADMENU6,
    'link'  => 'admin/templates.php',
    'icon'  => $pathIcon32 . '/watermark.png'
);


//if (defined("_XI_MIMETYPE")) {
    $adminmenu[] = array(
        'title' => _MI_XI_ADMENU7,
        'link'  => 'admin/mimetypes.php',
        'icon'  => $pathIcon32 . '/type.png'
    );
//}

//$adminmenu[] = array(
//    'title' => _MI_XI_NEWVERSION,
//    'link'  => 'admin/main.php?op=newversion',
//    'icon'  => $pathIcon32 . '/update.png'
//);


$adminmenu[] = array(
    'title' => _AM_MODULEADMIN_ABOUT,
    'link'  => 'admin/about.php',
    'icon'  => $pathIcon32 . '/about.png'
);
