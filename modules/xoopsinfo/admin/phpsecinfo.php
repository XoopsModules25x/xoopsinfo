<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2001 - 2006 <http://www.xoops.org/>
*
* Module: xoopsinfo 2.13
* Licence : GPL
* Authors :
*              - Jmorris
*              - Marco
*              - Christian
*              - DuGris (http://www.dugris.info)
*/

global $xoops, $xoopsDB, $xoopsConfig, $xoopsModule;
include('admin_header.php');
$phpsecinfo_path  = XoopsInfo_moduleoption('xi_phpsecinfo_folder');
xoops_cp_header();
adminmenu(4);

echo '<table width="100%" class="outer">';

echo '<tr>';
echo '<td align="center">';
admintitle( _AM_XI_ADMENU9 );
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<td><iframe src="' . XOOPS_URL . $phpsecinfo_path . '/index.php?xoopsinfo" scrolling="auto" frameborder="1" width="100%" height="1024"></iframe></td>'
;echo '</tr>';

echo '</table>';
adminfooter();
xoops_cp_footer();
?>