<?php

declare(strict_types=1);

/*
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

/**
 * @copyright    XOOPS Project http://xoops.org/
 * @license      GNU GPL 2 or later (http://www.gnu.org/licenses/gpl-2.0.html)
 * @since
 * @author       XOOPS Development Team
 */
if ('rescue.php' !== basename($_SERVER['PHP_SELF'])) {
    include '../../../include/cp_header.php';
}
define('XOOPSINFO_URL', XOOPS_URL . '/modules/xoopsinfo/');
define('XOOPSINFO_URL_IMAGE', XOOPS_URL . '/modules/xoopsinfo/images/');
define('XOOPSINFO_ADMIN_URL', XOOPS_URL . '/modules/xoopsinfo/admin/');
define('XOOPSINFO_PATH', XOOPS_ROOT_PATH . '/modules/xoopsinfo/');

include_once(XOOPS_ROOT_PATH . '/class/xoopsformloader.php');
include_once(XOOPS_ROOT_PATH . '/class/module.textsanitizer.php');

include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/functions.php');
include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php');

@include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/xoops_version.php');

if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
    include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/modinfo.php');
} else {
    include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/english/modinfo.php');
}

if (file_exists(XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/global.php')) {
    @include_once(XOOPS_ROOT_PATH . '/language/' . $xoopsConfig['language'] . '/global.php');
} else {
    @include_once(XOOPS_ROOT_PATH . '/language/english/admin/global.php');
}

if (file_exists(XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin.php')) {
    @include_once(XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin.php');
} else {
    @include_once(XOOPS_ROOT_PATH . '/modules/system/language/english/admin/admin.php');
}

if (file_exists(XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin/preferences.php')) {
    @include_once(XOOPS_ROOT_PATH . '/modules/system/language/' . $xoopsConfig['language'] . '/admin/preferences.php');
} else {
    @include_once(XOOPS_ROOT_PATH . '/modules/system/language/english/admin/preferences.php');
}

include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/admin/menu.php');

$myts = MyTextSanitizer::getInstance();

if ('index.php' === basename($_SERVER['PHP_SELF'])) {
    XoopsInfo_UpdatedModule();
}

//=========================================

$moduleDirName = basename(dirname(__DIR__));
include_once dirname(dirname(dirname(__DIR__))) . '/mainfile.php';
include_once $GLOBALS['xoops']->path('www/include/cp_functions.php');
include_once $GLOBALS['xoops']->path('www/include/cp_header.php');
include_once $GLOBALS['xoops']->path('www/class/xoopsformloader.php');

xoops_load('XoopsRequest');

//$moduleDirName = $GLOBALS['xoopsModule']->getVar('dirname');

$pathIcon16           = $GLOBALS['xoops']->url('www/' . $GLOBALS['xoopsModule']->getInfo('sysicons16'));
$pathIcon32           = $GLOBALS['xoops']->url('www/' . $GLOBALS['xoopsModule']->getInfo('sysicons32'));
$xoopsModuleAdminPath = $GLOBALS['xoops']->path('www/' . $GLOBALS['xoopsModule']->getInfo('dirmoduleadmin'));
require_once $xoopsModuleAdminPath . '/moduleadmin.php';

$myts = MyTextSanitizer::getInstance();
if (!isset($GLOBALS['xoopsTpl']) || !($GLOBALS['xoopsTpl'] instanceof XoopsTpl)) {
    include_once $GLOBALS['xoops']->path('class/template.php');

    $xoopsTpl = new XoopsTpl();
}

//Module specific elements
//include_once $GLOBALS['xoops']->path("modules/{$moduleDirName}/include/functions.php");
//include_once $GLOBALS['xoops']->path("modules/{$moduleDirName}/include/config.php");

//Handlers
//$XXXHandler =& xoops_getModuleHandler('XXX', $moduleDirName);

// Load language files
xoops_loadLanguage('admin', $moduleDirName);
xoops_loadLanguage('modinfo', $moduleDirName);
xoops_loadLanguage('main', $moduleDirName);

//xoops_cp_header();
$adminObject = new ModuleAdmin();
