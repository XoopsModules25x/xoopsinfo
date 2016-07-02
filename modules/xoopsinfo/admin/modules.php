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
xoops_cp_header();
$indexAdmin = new ModuleAdmin();
echo $indexAdmin->addNavigation(basename(__FILE__));
//if (defined("_PHPSYSINFO") && defined("_PHPSECINFO")) {
//    adminmenu(5);
//} elseif ((defined("_PHPSYSINFO") && !defined("_PHPSECINFO")) || (!defined("_PHPSYSINFO") && defined("_PHPSECINFO"))) {
//    adminmenu(4);
//} elseif (!defined("_PHPSYSINFO") && !defined("_PHPSECINFO")) {
//    adminmenu(3);
//}

$module_handler =& xoops_getHandler('module');
$installed_mods = $module_handler->getObjects();

echo '<table width="100%" class="outer">';
echo '<tr>';
echo '<td colspan="6" align="center">';
//admintitle(_AM_XI_ADMENU4);
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<th align="center" rowspan="2">' . _AM_XI_MODULE_NAME . '</th>';
echo '<th align="center" rowspan="2" width="60px">' . _AM_XI_MODULE_ACTION . '</th>';
echo '<th align="center" rowspan="2" width="80px">' . _AM_XI_MODULE_SUPPORT . '</th>';
echo '<th align="center" colspan="3">' . _AM_XI_MODULE_VERSION . '</th>';
echo '</tr>';

echo '<tr>';
echo '<th align="center" width="60px">' . _AM_XI_MODULE_XOOPS . '</th>';
echo '<th align="center" width="60px">' . _AM_XI_MODULE_TABLE . '</th>';
echo '<th align="center" width="60px">' . _AM_XI_MODULE_NEW . '</th>';
echo '</tr>';

foreach ($installed_mods as $module) {
    unset($modversion);
    @include(XOOPS_ROOT_PATH . '/modules/' . $module->getVar('dirname') . '/xoops_version.php');

    $action      = 0;
    $new_version = false;
    if (!array_key_exists('status_fileinfo', $modversion)) {
        $file = XOOPS_ROOT_PATH . '/modules/xoopsinfo/plugins/modules/' . $module->getVar('dirname') . '.php';
        if (file_exists($file)) {
            include_once($file);
            if ($modversion['status_fileinfo']) {
                $new_version = @file_get_contents($modversion['status_fileinfo']);
            }
        }
    } else {
        if ($modversion['status_fileinfo']) {
            $new_version = @file_get_contents($modversion['status_fileinfo']);
        }
    }

    if ($modversion['version'] != ($module->getVar('version') / 100)) {
        $action = 1;
        $class  = '';
        $style  = ' style="background : #ffa9a9;"';
    } elseif ($modversion['version'] == ($module->getVar('version') / 100) && ($modversion['version'] < $new_version && $new_version)) {
        $action = 2;
        $class  = '';
        $style  = ' style="background : #b5d1fe;"';
    } elseif ($modversion['version'] == ($module->getVar('version') / 100) && ($modversion['version'] == $new_version && $new_version)) {
        $action = 3;
        $class  = 'odd';
        $style  = '';
    } else {
        $action = 0;
        $class  = 'odd';
        $style  = '';
    }

    echo '<tr>';
    echo '<td class="' . $class . '"' . $style . '>';
    if (array_key_exists('developer_website_url', $modversion) && $modversion['developer_website_url'] != '') {
        echo '<a target="_new" href="' . $modversion['developer_website_url'] . '">';
    }
    echo $module->getVar('name', 'E');
    if (array_key_exists('developer_website_url', $modversion) && $modversion['developer_website_url'] != '') {
        echo '</a>';
    }
    echo '</td>';

    echo '<td class="' . $class . '"' . $style . ' align="center">';

    echo '<a href="' . XOOPS_URL . '/modules/system/admin.php?fct=modulesadmin&op=update&module=' . $module->getVar('dirname') . '">
			<img src="../images/icons/update.gif" alt="' . _AM_XI_MODULE_UPDATE . '"align="absmiddle" />
			</a>&nbsp;';

    if ($action == 2 || $action == 0) {
        if (array_key_exists('download_website', $modversion) && $modversion['download_website'] != '') {
            echo '<a target="_blank" href="' . $modversion['download_website'] . '">';
            echo '<img src="../images/icons/download.gif" alt="' . _AM_XI_MODULE_DOWNLOAD . '"align="absmiddle" />';
            echo '</a>';
        } else {
            echo '<img src="../images/blank.png" alt="" width="22" height="22" />';
        }
    } else {
        echo '<img src="../images/blank.png" alt="" width="22" height="22" />';
    }
    echo '</td>';

    echo '<td class="' . $class . '"' . $style . ' align="center">';
    if (array_key_exists('support_site_url', $modversion) && $modversion['support_site_url'] != '') {
        echo '<a target="_blank" href="' . $modversion['support_site_url'] . '">';
        echo '<img src="../images/icons/forum.gif" alt="' . _AM_XI_MODULE_FORUM . '"/>';
        echo '</a>&nbsp;';
    } else {
        echo '<img src="../images/blank.png" alt="" width="20" height="20"/>&nbsp;';
    }
    if (array_key_exists('submit_feature', $modversion) && $modversion['submit_feature'] != '') {
        echo '<a target="_blank" href="' . $modversion['submit_feature'] . '">';
        echo '<img src="../images/icons/feature.gif" alt="' . _AM_XI_MODULE_FEATURE . '"/>';
        echo '</a>&nbsp;';
    } else {
        echo '<img src="../images/blank.png" alt="" width="20" height="20"/>&nbsp;';
    }
    if (array_key_exists('submit_bug', $modversion) && $modversion['submit_bug'] != '') {
        echo '<a target="_blank" href="' . $modversion['submit_bug'] . '">';
        echo '<img src="../images/icons/bugs.gif" alt="' . _AM_XI_MODULE_BUG . '"/>';
        echo '</a>';
    } else {
        echo '<img src="../images/blank.png" alt="" width="20" height="20"/>';
    }
    echo '</td>';

    echo '<td class="' . $class . '"' . $style . ' align="center">';
    if ($action == 1) {
        echo '<b>';
    }

    echo number_format($modversion['version'], 2);
    if ($action == 1) {
        echo '</b>';
    }
    echo '</td>';

    echo '<td class="' . $class . '"' . $style . ' align="center">';
    if ($action == 1) {
        echo '<b>';
    }
    echo number_format($module->getVar('version') / 100, 2);
    if ($action == 1) {
        echo '</b>';
    }
    echo '</td>';

    echo '<td class="' . $class . '"' . $style . ' align="center">';
    if ($new_version) {
        if ($action == 2) {
            echo '<b>';
        }
        echo number_format($new_version, 2);
        if ($action == 2) {
            echo '</b>';
        }
    }
    echo '</td>';

    echo '</tr>';
}
echo '</table>';
echo '<br>';

echo '<table width="70%" align="center">';
echo '<tr>';
echo '<td style="width:10%;background : #ffa9a9;">&nbsp;</td>';

echo '<td><b>';
echo _AM_XI_MODULE_LEGEND_UPDATE;
echo '</b></td>';
echo '</tr>';

echo '<tr>';
echo '<td style="width:10%;background : #b5d1fe;">&nbsp;</td>';

echo '<td><b>';
echo _AM_XI_MODULE_LEGEND_DOWNLOAD;
echo '</b></td>';
echo '</tr>';
echo '</table>';

//adminfooter();
//xoops_cp_footer();
include_once __DIR__ . '/admin_footer.php';
