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

/**
 * @param int    $currentoption
 * @param string $breadcrumb
 */
function adminmenu($currentoption = 0, $breadcrumb = '')
{
    global $xoopsModule, $xoopsConfig, $modversion;
    /* Nice buttons styles */
    echo "<style type='text/css'>
			#buttontop { float:left; width:100%; background: #e7e7e7; font-size:93%; line-height:normal; border-top: 1px solid black; border-left: 1px solid black; border-right: 1px solid black; margin: 0; }
			#buttonbar { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/xoopsinfo/images/bg.png') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; }
			#buttonbar ul { margin:0; margin-top: 15px; padding:10px 0 0; list-style:none; white-space: nowrap; float:left; }
			#buttonbar li { display:inline; margin:0; padding:0; }
			#buttonbar a { float:left; background:url('" . XOOPS_URL . "/modules/xoopsinfo/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 5px; text-decoration:none; }
			#buttonbar a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/xoopsinfo/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
			/* Commented Backslash Hack hides rule from IE5-Mac \*/
			#buttonbar a span {float:none;}
			/* End IE5-Mac hack */
			#buttonbar a:hover span { color:#333; }
			#buttonbar #current a { background-position:0 -150px; border-width:0; }
			#buttonbar #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
			#buttonbar a:hover { background-position:0% -150px; }
			#buttonbar a:hover span { background-position:100% -150px; }

			#buttonbar2 { float:left; width:100%; background: #e7e7e7 url('" . XOOPS_URL . "/modules/xoopsinfo/images/bg.png') repeat-x left bottom; font-size:93%; line-height:normal; border-left: 1px solid black; border-right: 1px solid black; margin-bottom: 10px; }
			#buttonbar2 ul { margin:0; margin-top: 0px; padding:0px; list-style:none; white-space: nowrap; float:left; }
			#buttonbar2 li { display:inline; margin:0; padding:0; }
			#buttonbar2 a { float:left; background:url('" . XOOPS_URL . "/modules/xoopsinfo/images/left_both.png') no-repeat left top; margin:0; padding:0 0 0 5px; border-bottom:1px solid #000; text-decoration:none; }
			#buttonbar2 a span { float:left; display:block; background:url('" . XOOPS_URL . "/modules/xoopsinfo/images/right_both.png') no-repeat right top; padding:5px 15px 4px 6px; font-weight:bold; color:#765; }
			/* Commented Backslash Hack hides rule from IE5-Mac \*/
			#buttonbar2 a span {float:none;}
			/* End IE5-Mac hack */
			#buttonbar2 a:hover span { color:#333; }
			#buttonbar2 #current a { background-position:0 -150px; border-width:0; }
			#buttonbar2 #current a span { background-position:100% -150px; padding-bottom:5px; color:#333; }
			#buttonbar2 a:hover { background-position:0% -150px; }
			#buttonbar2 a:hover span { background-position:100% -150px; }
			</style>";

    if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/modinfo.php')) {
        include_once XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/modinfo.php';
    } else {
        include_once XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/english/modinfo.php';
    }
    include 'menu.php';

    echo '<h3 style="margin:0 0 10px 0; text-align:center;">' . $xoopsModule->name() . '  ' . _AM_XI_MODULEADMIN . '</h3>';
    echo '<div id="buttontop">';
    echo '<table style="width: 100%; padding: 0; " cellspacing="0"><tr>';
    echo '<td style="width: 100%; font-size: 10px; text-align: left; color: #2F5376; padding: 0 6px; line-height: 18px;">';

    for ($i = 0; $i < count($headermenu); $i++) {
        echo '<a class="nobutton" href="' . $headermenu[$i]['link'] . '">' . $headermenu[$i]['title'] . '</a> ';
        if ($i < count($headermenu) - 1) {
            echo '| ';
        }
    }
    echo '</td>';
    echo '</tr></table>';
    echo '</div>';

    $tblColors = array_fill(0, count($adminmenu), '');
    if ($currentoption >= 0) {
        $tblColors[$currentoption] = 'current';
    }

    if (defined('_PHPSYSINFO') && defined('_PHPSECINFO')) {
        $break = 4;
    } elseif ((defined('_PHPSYSINFO') && !defined('_PHPSECINFO')) || (!defined('_PHPSYSINFO') && defined('_PHPSECINFO'))) {
        $break = 3;
    } elseif (!defined('_PHPSYSINFO') && !defined('_PHPSECINFO')) {
        $break = 2;
    }

    echo '<div id="buttonbar">';
    echo '<ul>';
    for ($i = 0; $i < count($adminmenu); $i++) {
        echo '<li id="' . $tblColors[$i] . '"><a href="' . XOOPSINFO_URL . $adminmenu[$i]['link'] . '"><span>' . $adminmenu[$i]['title'] . '</span></a></li>';
        if ($i == $break) {
            echo '</ul></div><div id="buttonbar2"><ul>';
        }
    }
    echo '</ul></div>';
    echo '<div style="float:left; width:100%">';
}

function adminfooter()
{
    echo '<div align="right"><br><a target="_blank" href="http://www.dugris.info/"><img src="' . XOOPS_URL . '/modules/xoopsinfo/images/xoopsinfo.gif" border="0" align="absmiddle"></a></div>';
    echo '</div>';
}

/**
 * @param string $title
 */
function admintitle($title = '')
{
    echo '<div style="margin:10px 0px 20px 0px;">';
    if ($title) {
        echo '<h3 style="margin:0px; font-weight:bold; text-align:center;">' . $title . '</h3>';
    }
    echo '</div>';
}

/**
 * @return XoopsFormSelect
 */
function Template_GetModulesList()
{
    global $mid, $theme, $status;

    $module_handler =& xoops_getHandler('module');
    $criteria       = new CriteriaCompo(new Criteria('hasmain', 1));
    $criteria->add(new Criteria('isactive', 1));
    $criteria->add(new Criteria('mid', 1), 'OR');
    $module_list     = $module_handler->getList($criteria);
    $module_list[-1] = _AM_XI_MIME_ALL;
    ksort($module_list);

    $modules_select = new XoopsFormSelect(_AM_XI_MIME_MODULES, 'mid', $mid);
    $modules_select->setExtra('onchange="document.location=this.options[this.selectedIndex].value"');
    foreach ($module_list as $key => $value) {
        $modules_select->addOption('templates.php?fct=templates&mid=' . $key . '&status=' . $status . '&theme=' . $theme, $value);
    }
    $modules_select->setValue('templates.php?fct=templates&mid=' . $mid . '&status=' . $status . '&theme=' . $theme);

    return $modules_select;
}

/**
 * @param string $dirname
 * @return mixed
 */
function &XoopsInfo_getModuleInfo($dirname = 'xoopsinfo')
{
    $hModule = &xoops_getHandler('module');
    $Module  = $hModule->getByDirname($dirname);

    return $Module;
}

/**
 * @param        $option
 * @param string $repmodule
 * @return bool|mixed
 */
function XoopsInfo_moduleoption($option, $repmodule = 'xoopsinfo')
{
    global $xoopsModuleConfig, $xoopsModule;
    static $tbloptions = array();
    if (is_array($tbloptions) && array_key_exists($option, $tbloptions)) {
        return $tbloptions[$option];
    }

    $retval = false;
    if (isset($xoopsModuleConfig) && (is_object($xoopsModule) && $xoopsModule->getVar('dirname') == $repmodule && $xoopsModule->getVar('isactive'))) {
        if (isset($xoopsModuleConfig[$option])) {
            $retval = $xoopsModuleConfig[$option];
        }
    } else {
        $module_handler =& xoops_getHandler('module');
        $module         =& $module_handler->getByDirname($repmodule);
        $config_handler =& xoops_getHandler('config');
        if ($module) {
            $moduleConfig =& $config_handler->getConfigsByCat(0, $module->getVar('mid'));
            if (isset($moduleConfig[$option])) {
                $retval = $moduleConfig[$option];
            }
        }
    }
    $tbloptions[$option] = $retval;

    return $retval;
}

/**
 * @param        $dirname
 * @param        $template
 * @param string $theme
 * @param bool   $block
 * @return bool|int
 */
function check_override($dirname, $template, $theme = '', $block = false)
{
    global $xoopsConfig;
    $themeset = ($theme == '') ? $xoopsConfig['theme_set'] : $theme;

    if ($block) {
        if (file_exists(XOOPS_ROOT_PATH . '/themes/' . $themeset . '/modules/' . $dirname . '/blocks/' . $template)) {
            return true;
        }
    } else {
        if (file_exists(XOOPS_ROOT_PATH . '/themes/' . $themeset . '/modules/' . $dirname . '/' . $template)) {
            return true;
        }
    }

    return 0;
}

/**
 * @param        $dirname
 * @param        $template
 * @param string $theme
 * @param bool   $block
 * @return bool|string
 */
function filemtime_override($dirname, $template, $theme = '', $block = false)
{
    global $xoopsConfig;
    $themeset = ($theme == '') ? $xoopsConfig['theme_set'] : $theme;

    if ($block) {
        if (file_exists(XOOPS_ROOT_PATH . '/themes/' . $themeset . '/modules/' . $dirname . '/blocks/' . $template)) {
            $filename = XOOPS_ROOT_PATH . '/themes/' . $themeset . '/modules/' . $dirname . '/blocks/' . $template;
        } else {
            $filename = XOOPS_ROOT_PATH . '/modules/' . $dirname . '/templates/blocks/' . $template;
        }
    } else {
        if (file_exists(XOOPS_ROOT_PATH . '/themes/' . $themeset . '/modules/' . $dirname . '/' . $template)) {
            $filename = XOOPS_ROOT_PATH . '/themes/' . $themeset . '/modules/' . $dirname . '/' . $template;
        } else {
            $filename = XOOPS_ROOT_PATH . '/modules/' . $dirname . '/templates/' . $template;
        }
    }

    return date(_DATESTRING, filemtime($filename));
}

function XoopsInfo_GetLastVersion()
{
    global $modversion;
    $version = @file_get_contents($modversion['status_fileinfo']);
    if ($version) {
        include_once('../xoops_version.php');
        if ($version > ($GLOBALS['xoopsModule']->getVar('version') / 100)) {
            echo '<div class="bg1" style="margin:20px 100px; padding:5px; border:2px solid #FF0000; text-align:center; font-weight:bold;">';
            echo _AM_XI_MAKE_UPGRADE . '<a href="';
            if (array_key_exists('download_website', $modversion) && $modversion['download_website'] != '') {
                echo $modversion['download_website'] . '" target="_blank"><br><br><font color="#0000CC">' . $modversion['developer_website_name'];
            } else {
                echo $modversion['developer_website_url'] . '" target="_blank"><br><br><font color="#0000CC">' . $modversion['developer_website_name'];
            }
            echo '</font></a>';
            echo '</div>';
        } else {
            echo '<div class="bg1" style="margin:20px 100px; padding:5px; border:2px solid #FF0000; text-align:center; font-weight:bold;">';
            echo _AM_XI_NO_UPGRADE;
            echo '</div>';
        }
    }
}

function XoopsInfo_UpdatedModule()
{
    global $modversion;
    if ($modversion['version'] != ($GLOBALS['xoopsModule']->getVar('version') / 100)) {
        $redirect = XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $GLOBALS['xoopsModule']->getVar('dirname');
        redirect_header($redirect, 3, _AM_XI_MAKE_UPDATE);
    }
}
