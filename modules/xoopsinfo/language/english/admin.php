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


// Names of admin menu items
define("_AM_XI_ADMENU1","Xoops information");
define("_AM_XI_ADMENU2","Server Information");
define("_AM_XI_ADMENU3","MySql Information");
define("_AM_XI_ADMENU4","Modules Information");
define("_AM_XI_ADMENU5","Editors Information");
define("_AM_XI_ADMENU6","Overriding Information");
define("_AM_XI_ADMENU7","Mimetypes Management");

define("_AM_XI_GOTOHOMEPAGE","Back to User Side");
define("_AM_XI_MODULEADMIN","- Informations on your Xoopsenvironment");

define("_AM_XI_DOWN_SAFEMODESTATUS", "Statut safe mode");
define("_AM_XI_DOWN_REGISTERGLOBALS", "Register Globals");
define("_AM_XI_DOWN_ALLOW_URL_FOPEN","allow_url_fopen");
define("_AM_XI_DOWN_USE_TRANS_SID","session.use_trans_sid");
define("_AM_XI_DOWN_SERVERUPLOADSTATUS","Upload Statut");
define("_AM_XI_DOWN_MAXUPLOADSIZE", "Max upload size");
define("_AM_XI_DOWN_SAFEMODEPROBLEMS", " This May Cause Problems");
define("_AM_XI_DOWN_GDLIBSTATUS", "GD librairie Support");
define("_AM_XI_DOWN_GDLIBVERSION", "GD libraire Version");
define("_AM_XI_DOWN_GDON", " thumbs available");
define("_AM_XI_DOWN_GDOFF", " thumbs disabel");
define("_AM_XI_DOWN_OFF", "OFF");
define("_AM_XI_DOWN_ON", "ON");

define("_AM_XI_EDITOR_CHECK","Status");
define("_AM_XI_EDITOR_NAME", "Editor's name");

define("_AM_XI_EDITOR_NONE","");
define("_AM_XI_EDITOR_INSTALL_OK","Module installed");
define("_AM_XI_EDITOR_NO_INSTALL","Module not installed");

define("_AM_XI_EDITOR_OK","Editor OK");
define("_AM_XI_EDITOR_ERROR","File not found : class/... ");
define("_AM_XI_EDITOR_MODULE","Module not installed - File found : class/... ");
define("_AM_XI_EDITOR_CLASS","Module installed - File not found : class/... ");

define("_AM_XI_MODULE_NAME","Modules");
define("_AM_XI_MODULE_STATUS","Status");
define("_AM_XI_MODULE_ACTION","Action");
define("_AM_XI_MODULE_VERSION","Version");
define("_AM_XI_MODULE_XOOPS","xoops_version");
define("_AM_XI_MODULE_TABLE","Table module");
define("_AM_XI_MODULE_NEW","Latest");
define("_AM_XI_MODULE_UPDATE","Update module");
define("_AM_XI_MODULE_DOWNLOAD","Download new version");
define("_AM_XI_MODULE_SUPPORT","Support");
define("_AM_XI_MODULE_FORUM","Forums");
define("_AM_XI_MODULE_BUG","Bug report");
define("_AM_XI_MODULE_FEATURE","Feature");

define("_AM_XI_XOOPS_VERSION", "Xoops version");
define("_AM_XI_XOOPS_URL","Website URL");
define("_AM_XI_XOOPS_ROOT_PATH","XOOPS Physical Path");
define("_AM_XI_XOOPS_THEME", "Default theme");
define("_AM_XI_XOOPS_TEMPLATE","Default template set");
define("_AM_XI_XOOPS_DEBUG","Debug mode");
define("_AM_XI_XOOPS_STARTPAGE","Module for your start page");
define("_AM_XI_XOOPS_THEME_FROMFILE","Check templates for modifications ?");

define("_AM_XI_PROTECTOR_MODULE","Protector module");
define("_AM_XI_PROTECTOR_MODULE_NOT","Not installed");
define("_AM_XI_PROTECTOR_MODULE_OK","Installed");
define("_AM_XI_PROTECTOR_PRECHECK","Pre check ");
define("_AM_XI_PROTECTOR_CHECK_ERR"," You should edit your mainfile.php like written in <a target='_blank' href='" . XOOPS_URL . "/modules/protector/docs/README'>README</a>");
define("_AM_XI_PROTECTOR_PRECHECK_MSG","missing precheck");
define("_AM_XI_PROTECTOR_POSTCHECK", "Post check");
define("_AM_XI_PROTECTOR_POSTCHECK_MSG","missing postcheck");
define("_AM_XI_PROTECTOR","<font color='#CC0000'>Protector : </font>Temporary disabled");

define("_AM_XI_SERVER_SOFTWARE","Software server");
define("_AM_XI_SERVER_PHP","PHP version");
define("_AM_XI_SERVER_MYSQL","MySql version");

define("_AM_XI_BROWSER","Browser");

define("_AM_XI_SAVE","Save");

define("_AM_XI_MYSQL_ID","Id");
define("_AM_XI_MYSQL_DB","Database");
define("_AM_XI_MYSQL_INFO","Information");
define("_AM_XI_MYSQL_TIME","Time");
define("_AM_XI_MYSQL_STATUS","Status");
define("_AM_XI_MYSQL_DB_LENGTH","Data Base length");
define("_AM_XI_MYSQL_OCTETS","Octets");
define("_AM_XI_MYSQL_KOCTETS","Ko");

global $xoopsModule;
define("_AM_XI_MAKE_UPDATE", "The update of the module was not made : ");
define("_AM_XI_MAKE_UPGRADE", "A new version of <font color='#CC0000'>" . $xoopsModule->name() . "</font> is available<br />in downloading on this address :");
define("_AM_XI_NO_UPGRADE", "You have the last version !!!");

define("_AM_XI_MIME_ID","Id");
define("_AM_XI_MIME_EXT","Extension");
define("_AM_XI_MIME_TYPES","Types Mime");
define("_AM_XI_MIME_NAME","Application type");
define("_AM_XI_MIME_TYPE","Mimetypes<br /><br /><span style='font-weight: normal;'>Enter each mimetype associated with the file extension. Each mimetype must be seperated with <font color='#CC0000'><b>|</b></font>.</span>");
define("_AM_XI_MIME_GROUPS","Groups");
define("_AM_XI_MIME_MODULES","Module : ");
define("_AM_XI_MIME_MTYPE","Type : ");
define("_AM_XI_MIME_STATUS","Display");
define("_AM_XI_MIME_WIDTH", "Maximum width of the file");
define("_AM_XI_MIME_HEIGHT","Maximum height of the file");
define("_AM_XI_MIME_SIZE","Maximum size of the file");
define("_AM_XI_MIME_ACTION","Action");
define("_AM_XI_MIME_DISPLAY","Display : ");
define("_AM_XI_MIME_ALL","All");
define("_AM_XI_MIME_VIEW","Display");
define("_AM_XI_MIME_HIDE","Hidden");
define("_AM_XI_MIME_EDIT","Edit");
define("_AM_XI_MIME_DELE","Delete");
define("_AM_XI_MIME_DELETETHIS","Delete this mime type");
define("_AM_XI_MIME_NONE","None");

define("_AM_XI_MIME_NEW","New mimetype");
define("_AM_XI_MIME_MODIFY","Modify");
define("_AM_XI_MIME_CREATE","Create");
define("_AM_XI_MIME_CANCEL","Cancel");
define("_AM_XI_MIME_SAVEALL","Save");

define("_AM_XI_MODULE_TEMPLATE","Templates");
define("_AM_XI_MODULE_TEMPLATE_BLOCK","Templates (blocks)");
define("_AM_XI_TPL_OVERRIDE_ON","Template override on");
define("_AM_XI_TPL_OVERRIDE_OFF","Template override off");
define("_AM_XI_TPL_THEMES","Theme : ");



// Version 2.12
define("_AM_XI_ADMENU8", "System Informations");
define("_AM_XI_CONFIRM","Confirm");

define("_AM_XI_MYSQL_ACTION", "ACTION : ");
define("_AM_XI_MYSQL_OPTIMIZE", "Optimize tables");
define("_AM_XI_MYSQL_REPAIR", "Repair tables");
define("_AM_XI_MYSQL_CHECK", "Check tables");
define("_AM_XI_MYSQL_ANALYZE", "Analyze tables");

define("_AM_XI_MYSQL_RETURN","Return to : " . _AM_XI_ADMENU3);

define("_MI_XI_MYSQL_TABLE","Table");
define("_MI_XI_MYSQL_TABLE_TXT"," Table(s)");
define("_MI_XI_MYSQL_TYPE","Type");
define("_MI_XI_MYSQL_COLLATION","Collation");
define("_MI_XI_MYSQL_RECORDS","Records");
define("_MI_XI_MYSQL_SIZE","Size");
define("_MI_XI_MYSQL_OVERHEAD","Overhead");
define("_MI_XI_MYSQL_SUM","Sum");

// Version 2.13
define("_AM_XI_ADMENU9", "PHP Security Information");
?>