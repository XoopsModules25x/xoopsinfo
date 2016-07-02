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
include_once(XOOPS_ROOT_PATH . '/class/xoopsformloader.php');

global $xoopsConfig;

$mid    = isset($_REQUEST['mid']) ? (int)$_REQUEST['mid'] : 1;
$status = isset($_REQUEST['status']) ? (int)$_REQUEST['status'] : 0;
$theme  = isset($_REQUEST['theme']) ? $_REQUEST['theme'] : $xoopsConfig['theme_set'];

xoops_cp_header();
$indexAdmin = new ModuleAdmin();
echo $indexAdmin->addNavigation(basename(__FILE__));
//echo $indexAdmin->renderIndex();

//if (defined("_PHPSYSINFO") && defined("_PHPSECINFO")) {
//    adminmenu(7);
//} elseif ((defined("_PHPSYSINFO") && !defined("_PHPSECINFO")) || (!defined("_PHPSYSINFO") && defined("_PHPSECINFO"))) {
//    adminmenu(6);
//} elseif (!defined("_PHPSYSINFO") && !defined("_PHPSECINFO")) {
//    adminmenu(5);
//}

$module_handler =& xoops_getHandler('module');

if ($mid > 0) {
    $modules[] = $module_handler->get($mid);
} else {
    $modules = $module_handler->getObjects();
}

$modules_select = Template_GetModulesList();

$theme_select = new XoopsFormSelect('', 'theme', $theme);
$theme_select->setExtra('onchange="document.location=this.options[this.selectedIndex].value"');
require_once(XOOPS_ROOT_PATH . '/class/xoopslists.php');
$dirlist = XoopsLists::getThemesList();
if (!empty($dirlist)) {
    asort($dirlist);
    foreach ($dirlist as $value) {
        $theme_select->addOption('templates.php?mid=' . $mid . '&status=' . $status . '&theme=' . $value, $value);
    }
    $theme_select->setValue('templates.php?mid=' . $mid . '&status=' . $status . '&theme=' . $theme);
}

$form_select = new XoopsFormSelect(_AM_XI_MIME_DISPLAY, 'status');
$form_select->setExtra('onchange="document.location=this.options[this.selectedIndex].value"');
$form_select->addOption('templates.php?mid=' . $mid . '&status=0&theme=' . $theme, _AM_XI_MIME_ALL);
$form_select->addOption('templates.php?mid=' . $mid . '&status=1&theme=' . $theme, _AM_XI_TPL_OVERRIDE_ON);
$form_select->addOption('templates.php?mid=' . $mid . '&status=2&theme=' . $theme, _AM_XI_TPL_OVERRIDE_OFF);
$form_select->setValue('templates.php?mid=' . $mid . '&status=' . $status . '&theme=' . $theme);

echo '<form action ="templates.php" method="post">';
echo '<table width="100%" class="outer">';
echo '<tr>';
echo '<td colspan="3" >';
//admintitle(_AM_XI_ADMENU6);
echo '</td>';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td colspan="3" >';
echo '<table width="100%" align="center">';
echo '<tr>';
echo '	<td>' . _AM_XI_MIME_MODULES . $modules_select->render() . '</td>';
echo '	<td>' . _AM_XI_TPL_THEMES . $theme_select->render() . '</td>';
echo '	<td>' . _AM_XI_MIME_DISPLAY . $form_select->render() . '</td>';
echo '</tr>';
echo '</table>';
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<th align="center">' . _AM_XI_MODULE_NAME . '</th>';
echo '<th align="center">' . _AM_XI_MODULE_TEMPLATE . '</th>';
echo '<th align="center">' . _AM_XI_MODULE_TEMPLATE_BLOCK . '</th>';
echo '</tr>';

foreach ($modules as $module) {
    unset($modversion);
    @include(XOOPS_ROOT_PATH . '/modules/' . $module->getVar('dirname') . '/xoops_version.php');
    $templates = $module->getInfo('templates');
    $blocks    = $module->getInfo('blocks');

    if ($templates || $blocks) {
        echo '<tr>';
        echo '<td class="odd">';
        if (array_key_exists('developer_website_url', $modversion) && $modversion['developer_website_url'] != '') {
            echo '<a target="_new" href="' . $modversion['developer_website_url'] . '">';
        }
        echo $module->getVar('name', 'E');
        if (array_key_exists('developer_website_url', $modversion) && $modversion['developer_website_url'] != '') {
            echo '</a>';
        }
        echo '</td>';

        echo '<td width="40%" class="odd" align="left" valign="top">';
        if ($templates) {
            echo '<table width="300px">';
            foreach ($templates as $tpl) {
                $img      = '';
                $override = check_override($module->getInfo('dirname'), $tpl['file'], $theme);
                $fileinfo = filemtime_override($module->getInfo('dirname'), $tpl['file'], $theme);
                if ($status == 0 && $override) {
                    $title = _AM_XI_TPL_OVERRIDE_ON . ' - ' . $fileinfo;
                    $img   = '<img src="../images/icons/override_on.gif" align="absmiddle" />';
                } elseif ($status == 0 && !$override) {
                    $title = _AM_XI_TPL_OVERRIDE_OFF . ' - ' . $fileinfo;
                    $img   = '<img src="../images/icons/override_off.gif" align="absmiddle" />';
                } elseif ($status == 1 && $override) {
                    $title = _AM_XI_TPL_OVERRIDE_OFF . ' - ' . $fileinfo;
                    $img   = '<img src="../images/icons/override_on.gif" align="absmiddle" />';
                } elseif ($status == 2 && !$override) {
                    $title = _AM_XI_TPL_OVERRIDE_OFF . ' - ' . $fileinfo;
                    $img   = '<img src="../images/icons/override_off.gif" align="absmiddle" />';
                }

                if ($img != '') {
                    echo '<tr>';
                    echo '<td align="left">';
                    echo '<a href="#" title="' . $title . '">' . $img . ' ' . $tpl['file'] . '</a>';
                    echo '</td>';
                    echo '</tr>';
                }
            }
            echo '</table>';
        }
        echo '</td>';

        echo '<td width="40%" class="odd" align="left" valign="top">';
        if ($blocks) {
            echo '<table width="300px">';
            foreach ($blocks as $block) {
                if (isset($block['template'])) {
                    $img      = '';
                    $override = check_override($module->getInfo('dirname'), $block['template'], $theme, true);
                    $fileinfo = filemtime_override($module->getInfo('dirname'), $block['template'], $theme, true);
                    if ($status == 0 && $override) {
                        $title = _AM_XI_TPL_OVERRIDE_ON . ' - ' . $fileinfo;
                        $img   = '<img src="../images/icons/override_on.gif" align="absmiddle" />';
                    } elseif ($status == 0 && !$override) {
                        $title = _AM_XI_TPL_OVERRIDE_OFF . ' - ' . $fileinfo;
                        $img   = '<img src="../images/icons/override_off.gif" align="absmiddle" />';
                    } elseif ($status == 1 && $override) {
                        $title = _AM_XI_TPL_OVERRIDE_ON . ' - ' . $fileinfo;
                        $img   = '<img src="../images/icons/override_on.gif" align="absmiddle" />';
                    } elseif ($status == 2 && !$override) {
                        $title = _AM_XI_TPL_OVERRIDE_OFF . ' - ' . $fileinfo;
                        $img   = '<img src="../images/icons/override_off.gif" align="absmiddle" />';
                    }

                    if ($img != '') {
                        echo '<tr>';
                        echo '<td align="left">';
                        echo '<a href="#" title="' . $title . '">' . $img . ' ' . $block['template'] . '</a>';
                        echo '</td>';
                        echo '</tr>';
                    }
                }
            }
            echo '</table>';
        }
        echo '</td>';
        echo '</tr>';
    }
}
echo '</table>';
echo '</form>';

//adminfooter();
//xoops_cp_footer();
include_once __DIR__ . '/admin_footer.php';
