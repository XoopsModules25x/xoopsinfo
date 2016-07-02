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

if ( basename($_SERVER['PHP_SELF']) != 'rescue.php') {
	include '../../../include/cp_header.php';
}
define('XOOPSINFO_URL',XOOPS_URL . '/modules/xoopsinfo/');
define('XOOPSINFO_URL_IMAGE',XOOPS_URL . '/modules/xoopsinfo/images/');
define('XOOPSINFO_ADMIN_URL',XOOPS_URL . '/modules/xoopsinfo/admin/');
define('XOOPSINFO_PATH',XOOPS_ROOT_PATH . '/modules/xoopsinfo/');

include_once( XOOPS_ROOT_PATH.'/class/xoopsformloader.php' );
include_once( XOOPS_ROOT_PATH.'/class/module.textsanitizer.php' );

include_once( XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/functions.php');
include_once( XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php');

@include_once( XOOPS_ROOT_PATH.'/modules/xoopsinfo/xoops_version.php' );

if ( file_exists( XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/modinfo.php' ) ) {
	include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/modinfo.php');
} else {
	include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/english/modinfo.php');
}

if ( file_exists( XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/global.php' ) ) {
	@include_once( XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/global.php');
} else {
	@include_once( XOOPS_ROOT_PATH . '/language/english/admin/global.php');
}

if ( file_exists( XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin.php' ) ) {
	@include_once( XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin.php');
} else {
	@include_once( XOOPS_ROOT_PATH . '/modules/system/language/english/admin/admin.php');
}

if ( file_exists( XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin/preferences.php' ) ) {
	@include_once( XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin/preferences.php');
} else {
	@include_once( XOOPS_ROOT_PATH . '/modules/system/language/english/admin/preferences.php');
}

include_once( XOOPS_ROOT_PATH . '/modules/xoopsinfo/admin/menu.php');

$myts =& MyTextSanitizer::getInstance();

if ( basename($_SERVER['PHP_SELF']) == 'index.php') {
	XoopsInfo_UpdatedModule();
}
?>