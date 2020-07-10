<?php

declare(strict_types=1);

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
$phpsysinfo_path  = XoopsInfo_moduleoption('xi_phpsysinfo_folder');
$phpsysinfo_lang  = XoopsInfo_moduleoption('xi_phpsysinfo_lang');
$phpsysinfo_theme = XoopsInfo_moduleoption('xi_phpsysinfo_theme');
xoops_cp_header();
//adminmenu(3);
$indexAdmin = new ModuleAdmin();
echo $indexAdmin->addNavigation(basename(__FILE__));

echo '<table width="100%" class="outer">';

echo '<tr>';
echo '<td align="center">';
//admintitle(_AM_XI_ADMENU8);
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td><iframe src="' . XOOPS_URL . $phpsysinfo_path . '/index.php?lng=' . $phpsysinfo_lang . '&template=' . $phpsysinfo_theme . '" scrolling="auto" frameborder="1" width="100%" height="1024"></iframe></td>';
echo '</tr>';

echo '</table>';
//adminfooter();
//xoops_cp_footer();
include_once __DIR__ . '/admin_footer.php';
