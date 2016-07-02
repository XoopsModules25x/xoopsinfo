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
// The name of this module
define('_MI_XI_NAME', 'XOOPS Info');

define('_MI_XI_DIRNAME', basename(dirname(dirname(__DIR__))));
define('_MI_XI_HELP_HEADER', __DIR__.'/help/helpheader.html');
define('_MI_XI_BACK_2_ADMIN','Back to Administration of ');


// A brief description of this module
define('_MI_XI_DESC', 'Basic module for displaying XOOPS, Apache, MySQL, and PHP information.');

// Credit where credit is due
define('_MI_XI_AUTHOR', 'XOOPS Support Team - DuGris (XOOPS France)');
define('_MI_XI_CREDITS', 'XOOPS Core Team (http://www.xoops.org/) - DuGris (http://www.dugris.info/');

// Support
define('_MI_XI_SUPPORT', 'Post your support requests at http://xoops.org/');

// Names of admin menu items
define('_MI_XI_ADMENU1', 'Xoops Info.');
define('_MI_XI_ADMENU2', 'Server Info.');
define('_MI_XI_ADMENU3', 'MySql Info.');
define('_MI_XI_ADMENU4', 'Modules Info.');
define('_MI_XI_ADMENU5', 'Editors Info.');
define('_MI_XI_ADMENU6', 'Overriding Info.');
define('_MI_XI_ADMENU7', 'Mimetypes');

define('_MI_XI_XOOPS_DEBUG', 'Debug mode');
define('_MI_XI_XOOPS_THEME', 'Activate Theme by default');
define('_MI_XI_XOOPS_CACHE', 'Delete cache files');
define('_MI_XI_XOOPS_TEMPLATE', 'Delete template_c files');
define('_MI_XI_XOOPS_PROTECTOR', "<font color='#CC0000'>Protector : </font>Temporary disabled");
define('_MI_XI_XOOPS_PROTECTOR_IP', "<font color='#CC0000'>Protector : </font>Delete the banished IP");

define('_MI_XI_XOOPS_PASSWORD', 'Password');
define('_MI_XI_PASSWORD_ERROR', 'Incorect Password !!!');
define('_MI_XI_XOOPS_SUBMIT', 'Submit');
define('_MI_XI_YES', 'Yes');
define('_MI_XI_NO', 'No');

define('_MI_XI_UPDATE_MODULE', "<font color='#CC0000'>Update module</font>");
//define("_MI_XI_NEWVERSION", "<font color='#000099'>New module version</font>");
define('_MI_XI_NEWVERSION', 'New module version');
define('_MI_XI_HELP', 'Help');

define('_AM_XI_MODULE_LEGEND_UPDATE', 'The update of the module was not carried out !!!');
define('_AM_XI_MODULE_LEGEND_DOWNLOAD', 'A new version of the module is available in downloading');

// Options
define('_MI_XI_CHECK_TABLE', 'Tables to be controlled');
define('_MI_XI_CHECK_TABLE_DSC', "Separate the tables name by <font color='#CC0000'><b>|</b></font>");

define('_MI_XI_IMG_FONT', 'Font width');
define('_MI_XI_IMG_BACKGROUND', 'Background color');
define('_MI_XI_IMG_BORDER', 'Border color');
define('_MI_XI_IMG_CONSTANT', 'text color');
define('_MI_XI_IMG_DATA', 'Xoops infos color');

define('_MI_XI_PASSWORD', 'Password');
define('_MI_XI_PASSWORD_DSC', "If for a reason or the other one you don't have acces to your website.<br>
 Go to the sript :
 <a href='" . XOOPS_URL . "/modules/xoopsinfo/admin/rescue.php'><font color='#CC0000'><b>XOOPS_URL/modules/xoopsinfo/admin/rescue.php</b></font></a><br>
 <li>Choose debug mode</li>
 <li>Activate the default theme</li><br>
 <li>Input this password</li><br>
 Don't forget setting the password<br>
 If this option is blank, the script never work !!!
 ");

// Version 2.12
define('_MI_XI_REFERER', "Referers authorized for <font color='#CC0000'>xoopsinfo.php</font>");
define('_MI_XI_REFERER_DSC', "separated by <font color='#CC0000'><b>|</b></font>");

define('_MI_XI_ADMENU8', 'System info');

define('_MI_PHPSYSINFO_FOLDER', "[PHPSYSINFO] Folder containing <font color='#CC0000'>PHPSYSINFO</font>");
define('_MI_PHPSYSINFO_FOLDER_DSC', "For example <font color='#CC0000'><b>/phpsysinfo</b></font>, without the final <font color='#CC0000'><b>/</font></b><br>More information on <a target='_blank' href='http://phpsysinfo.sourceforge.net/'>phpsysinfo</a>");

define('_MI_PHPSYSINFO_LANG', '[PHPSYSINFO] Language by default');
define('_MI_PHPSYSINFO_LANG_DSC', 'The languages list is available in the file includes/lang of phpsysinfo');
define('_MI_PHPSYSINFO_LANG_DEF', 'en');

define('_MI_PHPSYSINFO_THEME', '[PHPSYSINFO] Theme by default');
define('_MI_PHPSYSINFO_THEME_DSC', 'The themes list is available in the file templates of phpsysinfo');

define('_MI_XI_XOOPS_SESSION_TABLE', 'Optimize session table');

// Version 2.13
define('_MI_XI_ADMENU9', 'PHP Security Information');

define('_MI_PHPSECINFO_FOLDER', "[PHPSECINFO] Folder containing <font color='#CC0000'>PHPSECINFO</font>");
define('_MI_PHPSECINFO_FOLDER_DSC', "For example <font color='#CC0000'><b>/phpsecinfo</b></font>, without the final <font color='#CC0000'><b>/</font></b><br>More information on <a target='_blank' href='http://phpsec.org/projects/phpsecinfo/index.html'>PHP Security Consortium: PHPSecInfo</a>");
