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
xoops_cp_header();
$indexAdmin = new ModuleAdmin();
echo $indexAdmin->addNavigation(basename(__FILE__));
//if (defined("_PHPSYSINFO") && defined("_PHPSECINFO")) {
//    adminmenu(6);
//} elseif ((defined("_PHPSYSINFO") && !defined("_PHPSECINFO")) || (!defined("_PHPSYSINFO") && defined("_PHPSECINFO"))) {
//    adminmenu(5);
//} elseif (!defined("_PHPSYSINFO") && !defined("_PHPSECINFO")) {
//    adminmenu(4);
//}

//echo ('<h3>'._MI_XI_ADMENU4.'</h3>');

$path = XOOPSINFO_PATH . 'plugins/editors/';
$d    = dir($path);
while (false !== ($entry = $d->read())) {
    $file = $path . $entry;

    if ('.' !== $entry && '..' !== $entry && 'index.html' !== basename($file)) {
        include_once($file);

        $editors[] = $editor;

        unset($editor);
    }
}
$d->close();

echo '<table width="100%" class="outer">';

echo '<tr>';
echo '<td colspan="2" align="center">';
//admintitle(_AM_XI_ADMENU5);
echo '</td>';
echo '</tr>';

echo '<tr>';
echo '<th align="center">' . _AM_XI_EDITOR_CHECK . '</th>';
echo '<th align="center">' . _AM_XI_EDITOR_NAME . '</th>';
echo '</tr>';

foreach ($editors as $key => $editor) {
    $isModule = false;

    if ($editor['dirname']) {
        $isModule = XoopsInfo_getModuleInfo($editor['dirname']);
    }

    echo '<tr>';

    // Check editor class file
    echo '<td class="even" align="center">';

    if ($editor['class'] && is_readable(XOOPS_ROOT_PATH . $editor['class']) && $isModule) {
        echo '<img src="../images/icons/on.gif" alt="' . _AM_XI_EDITOR_OK . '"align="absmiddle" />';
    } elseif ($editor['class'] && is_readable(XOOPS_ROOT_PATH . $editor['class']) && $editor['dirname'] && !$isModule) {
        echo '<img src="../images/icons/notinstalled.gif" alt="' . _AM_XI_EDITOR_MODULE . '"align="absmiddle" />';
    } elseif ($editor['class'] && !is_readable(XOOPS_ROOT_PATH . $editor['class']) && $isModule) {
        echo '<img src="../images/icons/noclass.gif" alt="' . _AM_XI_EDITOR_CLASS . '"align="absmiddle" />';
    } elseif ($editor['class'] && !is_readable(XOOPS_ROOT_PATH . $editor['class']) && !$isModule) {
        echo '<img src="../images/icons/off.gif" alt="' . _AM_XI_EDITOR_ERROR . '"align="absmiddle" />';
    } else {
        echo '<img src="../images/icons/on.gif" alt="' . _AM_XI_EDITOR_OK . '"align="absmiddle" />';
    }

    echo '</td>';

    // Editor's name
    echo '<td class="odd">';

    if ($editor['project']) {
        echo '<a target="_blank" href="' . $editor['project'] . '">';
    }

    echo $editor['name'];

    if ($editor['project']) {
        echo '</a>';
    }

    echo '<br>' . $editor['class'] . '</td>';

    echo '</tr>';
}
echo '</table>';
echo '<br>';

echo '<table width="80%" align="center" border="0" cellpadding="5" cellspacing="0">';

echo '<tr>
<td width="50%"><img src="../images/icons/on.gif" alt=""align="absmiddle" />&nbsp;' . _AM_XI_EDITOR_OK . '</th>
<td width="50%"><img src="../images/icons/off.gif" alt=""align="absmiddle" />&nbsp;' . _AM_XI_EDITOR_ERROR . '</th>
</tr>';

echo '<tr>
<td width="50%"><img src="../images/icons/notinstalled.gif" alt=""align="absmiddle" />&nbsp;' . _AM_XI_EDITOR_MODULE . '</th>
<td width="50%"><img src="../images/icons/noclass.gif" alt=""align="absmiddle" />&nbsp;' . _AM_XI_EDITOR_CLASS . '</th>
</tr>';

echo '</table>';

//adminfooter();
//xoops_cp_footer();
include_once __DIR__ . '/admin_footer.php';
