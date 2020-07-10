<?php

declare(strict_types=1);

/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2001 - 2006 <http://www.xoops.org/>
 *
 * Module: xoopsinfo 2.0
 * Licence : GPL
 * Authors :
 *           - Jmorris
 *            - Marco
 *            - Christian
 *            - DuGris (http://www.dugris.info)
 */

$modversion['version']       = 2.20;
$modversion['module_status'] = 'Alpha 1';
$modversion['release_date']  = '2020/08/10';
$modversion['name']          = _MI_XI_NAME;
$modversion['description']   = _MI_XI_DESC;
$modversion['author']        = _MI_XI_AUTHOR;
$modversion['credits']       = _MI_XI_CREDITS;
//$modversion['help']        = _MI_XI_SUPPORT;
$modversion['help']                = 'page=help';
$modversion['license']             = 'GNU GPL 2.0 or later';
$modversion['license_url']         = 'www.gnu.org/licenses/gpl-2.0.html';
$modversion['official']            = 1;
$modversion['image']               = 'images/logoModule.png';
$modversion['dirname']             = 'xoopsinfo';
$modversion['dirmoduleadmin']      = 'Frameworks/moduleclasses/moduleadmin';
$modversion['sysicons16']          = 'Frameworks/moduleclasses/icons/16';
$modversion['sysicons32']          = 'Frameworks/moduleclasses/icons/32';
$modversion['modicons16']          = 'assets/images/icons/16';
$modversion['modicons32']          = 'assets/images/icons/32';
$modversion['module_website_url']  = 'www.xoops.org';
$modversion['module_website_name'] = 'XOOPS';
$modversion['min_php']             = '7.1';
$modversion['min_xoops']           = '2.5.10';
$modversion['min_admin']           = '1.2';
$modversion['min_db']              = ['mysql' => '5.5'];
// XoopsInfo
$modversion['developer_website_url']  = 'http://www.dugris.info/';
$modversion['developer_website_name'] = 'DuGris Website';
$modversion['download_website']       = 'http://www.dugris.info/modules/wfdownloads/singlefile.php?cid=1&lid=31';
$modversion['status_fileinfo']        = 'http://www.dugris.info/version/xoopsinfo.version';
$modversion['status_version']         = '';
$modversion['status']                 = '';
$modversion['date']                   = '';
$modversion['demo_site_url']          = '';
$modversion['demo_site_name']         = '';
$modversion['support_site_url']       = '';
$modversion['support_site_name']      = '';
$modversion['submit_bug']             = '';
$modversion['submit_feature']         = '';
// XoopsInfo

//install
// $modversion['onInstall'] = 'include/onInstall_xoopsinfo.php';

//update
// $modversion['onUpdate'] = 'include/onUpdate_xoopsinfo.php';

include_once(XOOPS_ROOT_PATH . '/class/uploader.php');
if (defined('_XI_MIMETYPE')) {
    $modversion['sqlfile']['mysql'] = 'sql/mysql.sql';
    $modversion['tables'][0]        = 'content_' . $modversion['dirname'];

    // Tables created by sql file (without prefix!)
    $modversion['tables'][0] = 'mimetypes';
    $modversion['tables'][1] = 'mimetypes_perms';
}

// Admin things
$modversion['hasAdmin']    = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex']  = 'admin/index.php';
$modversion['adminmenu']   = 'admin/menu.php';

// Menu
$modversion['hasMain'] = 0;

// Options
$i                                       = 1;
$modversion['config'][$i]['name']        = 'xi_check_table';
$modversion['config'][$i]['title']       = '_MI_XI_CHECK_TABLE';
$modversion['config'][$i]['description'] = '_MI_XI_CHECK_TABLE_DSC';
$modversion['config'][$i]['formtype']    = 'textarea';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'session|online|priv_msgs|protector_access|protector_log';

$i++;
$modversion['config'][$i]['name']        = 'xi_img_font';
$modversion['config'][$i]['title']       = '_MI_XI_IMG_FONT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'select';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '3';
$modversion['config'][$i]['options']     = [
    3 => '3',
    4 => '4',
    5 => '5'
];

$i++;
$modversion['config'][$i]['name']        = 'xi_img_background';
$modversion['config'][$i]['title']       = '_MI_XI_IMG_BACKGROUND';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'DCDCDC';

$i++;
$modversion['config'][$i]['name']        = 'xi_img_border';
$modversion['config'][$i]['title']       = '_MI_XI_IMG_BORDER';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'FF0000';

$i++;
$modversion['config'][$i]['name']        = 'xi_img_constant';
$modversion['config'][$i]['title']       = '_MI_XI_IMG_CONSTANT';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '000000';

$i++;
$modversion['config'][$i]['name']        = 'xi_img_data';
$modversion['config'][$i]['title']       = '_MI_XI_IMG_DATA';
$modversion['config'][$i]['description'] = '';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '0000FF';

$i++;
$modversion['config'][$i]['name']        = 'xi_img_referer';
$modversion['config'][$i]['title']       = '_MI_XI_REFERER';
$modversion['config'][$i]['description'] = '_MI_XI_REFERER_DSC';
$modversion['config'][$i]['formtype']    = 'textarea';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'www.frxoops.org|www.xoops.org';

$i++;
$modversion['config'][$i]['name']        = 'xi_password';
$modversion['config'][$i]['title']       = '_MI_XI_PASSWORD';
$modversion['config'][$i]['description'] = '_MI_XI_PASSWORD_DSC';
$modversion['config'][$i]['formtype']    = 'password';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '';

$i++;
$modversion['config'][$i]['name']        = 'xi_phpsysinfo_folder';
$modversion['config'][$i]['title']       = '_MI_PHPSYSINFO_FOLDER';
$modversion['config'][$i]['description'] = '_MI_PHPSYSINFO_FOLDER_DSC';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '/phpsysinfo';

$i++;
$modversion['config'][$i]['name']        = 'xi_phpsysinfo_lang';
$modversion['config'][$i]['title']       = '_MI_PHPSYSINFO_LANG';
$modversion['config'][$i]['description'] = '_MI_PHPSYSINFO_LANG_DSC';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = _MI_PHPSYSINFO_LANG_DEF;

$i++;
$modversion['config'][$i]['name']        = 'xi_phpsysinfo_theme';
$modversion['config'][$i]['title']       = '_MI_PHPSYSINFO_THEME';
$modversion['config'][$i]['description'] = '_MI_PHPSYSINFO_THEME_DSC';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = 'classic';

$i++;
$modversion['config'][$i]['name']        = 'xi_phpsecinfo_folder';
$modversion['config'][$i]['title']       = '_MI_PHPSECINFO_FOLDER';
$modversion['config'][$i]['description'] = '_MI_PHPSECINFO_FOLDER_DSC';
$modversion['config'][$i]['formtype']    = 'text';
$modversion['config'][$i]['valuetype']   = 'text';
$modversion['config'][$i]['default']     = '/phpsecinfo';

if (!empty($_POST['fct']) && !empty($_POST['op']) && 'modulesadmin' === $_POST['fct'] && 'update_ok' === $_POST['op'] && $_POST['dirname'] == $modversion['dirname']) {
}
