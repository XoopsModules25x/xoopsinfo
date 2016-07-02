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

if (!defined('XOOPS_ROOT_PATH')) { die('XOOPS root path not defined'); }

include_once( XOOPS_ROOT_PATH . '/class/uploader.php');

include_once( XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/functions.php');
$phpsysinfo_path = XoopsInfo_moduleoption('xi_phpsysinfo_folder');
$phpsecinfo_path = XoopsInfo_moduleoption('xi_phpsecinfo_folder');

$i=0;
$adminmenu[$i]['title'] = _MI_XI_ADMENU1;
$adminmenu[$i]['link'] = 'admin/index.php';

$i++;
$adminmenu[$i]['title'] = _MI_XI_ADMENU2;
$adminmenu[$i]['link'] = 'admin/php.php';

$i++;
$adminmenu[$i]['title'] = _MI_XI_ADMENU3;
$adminmenu[$i]['link'] = 'admin/mysqlinfo.php';

if ( !empty($phpsysinfo_path) && file_exists(XOOPS_ROOT_PATH . $phpsysinfo_path . '/index.php') ) {
	if ( !defined("_PHPSYSINFO") ){
		define('_PHPSYSINFO', 1);
	}
	$i++;
	$adminmenu[$i]['title'] = _MI_XI_ADMENU8;
	$adminmenu[$i]['link'] = 'admin/phpsysinfo.php';
}

if ( !empty($phpsecinfo_path) && file_exists(XOOPS_ROOT_PATH . $phpsecinfo_path . '/index.php') ) {
	if ( !defined("_PHPSECINFO") ){
		define('_PHPSECINFO', 1);
	}
	$i++;
	$adminmenu[$i]['title'] = _MI_XI_ADMENU9;
	$adminmenu[$i]['link'] = 'admin/phpsecinfo.php';
}

$i++;
$adminmenu[$i]['title'] = _MI_XI_ADMENU4;
$adminmenu[$i]['link'] = 'admin/modules.php';

$i++;
$adminmenu[$i]['title'] = _MI_XI_ADMENU5;
$adminmenu[$i]['link'] = 'admin/editors.php';

$i++;
$adminmenu[$i]['title'] = _MI_XI_ADMENU6;
$adminmenu[$i]['link'] = 'admin/templates.php';

if ( defined("_XI_MIMETYPE") ) {
	$i++;
	$adminmenu[$i]['title'] = _MI_XI_ADMENU7;
	$adminmenu[$i]['link'] = 'admin/mimetypes.php';
}

if (isset($xoopsModule)) {
	$i = 0;
	$headermenu[$i]['title'] = _AM_XI_GOTOHOMEPAGE;
	$headermenu[$i]['link'] = XOOPS_URL . '/';

	$i++;
	$headermenu[$i]['title'] = _PREFERENCES;
	$headermenu[$i]['link'] = '../../system/admin.php?fct=preferences&amp;op=showmod&amp;mod=' . $xoopsModule->getVar('mid');

	$i++;
	$headermenu[$i]['title'] = _MI_XI_HELP;
	$headermenu[$i]['link'] = XOOPS_URL . '/modules/xoopsinfo/admin/help.php';

	$i++;
	$headermenu[$i]['title'] = _MI_XI_UPDATE_MODULE;
	$headermenu[$i]['link'] = XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $xoopsModule->getVar('dirname');

	$i++;
	$headermenu[$i]['title'] = _MI_XI_NEWVERSION;
	$headermenu[$i]['link'] = XOOPS_URL . '/modules/xoopsinfo/admin/index.php?op=newversion';
}
?>