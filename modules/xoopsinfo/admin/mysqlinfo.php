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
//adminmenu(2);

$confirm = isset($_REQUEST['confirm']) ? trim($_REQUEST['confirm']) : 0;
$action  = isset($_REQUEST['optimize']) ? 1 : 0;
$action  = isset($_REQUEST['repair']) ? 2 : $action;
$action  = isset($_REQUEST['check']) ? 3 : $action;
$action  = isset($_REQUEST['analyze']) ? 4 : $action;

if ($confirm == 0 && $action > 0) {
    switch ($action) {
        case 1:
            xoops_confirm(array('optimize' => $_REQUEST['optimize'], 'confirm' => 1), 'mysqlinfo.php', _AM_XI_MYSQL_OPTIMIZE, _AM_XI_CONFIRM);
            break;

        case 2:
            xoops_confirm(array('repair' => $_REQUEST['repair'], 'confirm' => 1), 'mysqlinfo.php', _AM_XI_MYSQL_REPAIR, _AM_XI_CONFIRM);
            break;

        case 3:
            xoops_confirm(array('check' => $_REQUEST['check'], 'confirm' => 1), 'mysqlinfo.php', _AM_XI_MYSQL_CHECK, _AM_XI_CONFIRM);
            break;

        case 4:
            xoops_confirm(array('analyze' => $_REQUEST['analyze'], 'confirm' => 1), 'mysqlinfo.php', _AM_XI_MYSQL_ANALYZE, _AM_XI_CONFIRM);
            break;
    }
    //adminfooter();
    //xoops_cp_footer();
    include_once __DIR__ . '/admin_footer.php';
    exit();
}

$check_tables = explode('|', $xoopsModuleConfig['xi_check_table']);
$db_table     = 0;
$db_table_c   = 0;

$db_length   = 0;
$db_length_c = 0;

$db_rows   = 0;
$db_rows_c = 0;

$db_data_free   = 0;
$db_data_free_c = 0;
$$i             = 0;

$sql = 'SHOW TABLE STATUS';
$res = $xoopsDB->queryF($sql);

while ($row = $xoopsDB->fetchArray($res)) {
    $row_name = str_replace($xoopsDB->prefix() . '_', '', $row['Name']);

    $db_table++;
    $db_length += $row['Data_length'] + $row['Index_length'];
    $db_rows += $row['Rows'];
    $db_data_free += $row['Data_free'];

    if (in_array($row_name, $check_tables)) {
        $tables[$i]['Name']      = $row_name;
        $tables[$i]['Engine']    = isset($row['Engine']) ? $row['Engine'] : 'MyISAM';
        $tables[$i]['Collation'] = isset($row['Collation']) ? $row['Collation'] : 'None';
        $tables[$i]['Rows']      = $row['Rows'];
        $tables[$i]['Lenght']    = $row['Data_length'] + $row['Index_length'];
        $tables[$i]['Data_free'] = $row['Data_free'];

        $db_table_c++;
        $db_length_c += $row['Data_length'] + $row['Index_length'];
        $db_rows_c += $row['Rows'];
        $db_data_free_c += $row['Data_free'];
    }

    if ($confirm) {
        switch ($action) {
            case 1:
                $sql = 'OPTIMIZE TABLE ' . $row['Name'];
                break;

            case 2:
                $sql = 'REPAIR TABLE ' . $row['Name'];
                break;

            case 3:
                $sql = 'CHECK TABLE ' . $row['Name'];
                break;

            case 4:
                $sql = 'ANALYZE TABLE ' . $row['Name'];
                break;
        }
        $result                 = $xoopsDB->queryF($sql);
        $action_row             = $xoopsDB->fetchArray($result);
        $tables[$i]['Name']     = $row_name;
        $tables[$i]['Op']       = $action_row['Op'];
        $tables[$i]['Msg_type'] = $action_row['Msg_type'];
        $tables[$i]['Msg_text'] = $action_row['Msg_text'];
    }
    $i++;
}

if (!$confirm) {
    $queries[] = 'LIKE "version"';
    $queries[] = 'LIKE "version_compile_os"';
    $queries[] = 'LIKE "max_connections"';
    $queries[] = 'LIKE "connect_timeout"';
    $queries[] = 'LIKE "character_set_database"';
    $queries[] = 'LIKE "character_set_system"';
    $queries[] = 'LIKE "collation%"';
    $queries[] = 'LIKE "InnoDB"';
    $queries[] = 'LIKE "storage_engine"';

    echo '<table width="100%" class="outer">';

    echo '<tr>';
    echo '<td colspan="3" align="center">';
//    admintitle(_AM_XI_ADMENU3);
    echo '</td>';
    echo '</tr>';

    foreach ($queries as $query) {
        $sql = 'SHOW VARIABLES ' . $query;
        $res = $xoopsDB->queryF($sql);
        while ($row = $xoopsDB->fetchArray($res)) {
            echo '<tr>';
            echo '<td class="even">';
            echo $row['Variable_name'];
            echo '</td>';

            echo '<td class="odd">';
            echo $row['Value'];
            echo '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';
}

echo '<table width="100%" class="outer">';
echo '<tr>';
if (!$confirm) {
    echo '<td colspan="6" align="center">';
//    admintitle(_MI_XI_CHECK_TABLE);
    echo '</td>';
} else {
    echo '<td colspan="4" align="center">';
//    admintitle(_AM_XI_ADMENU3);
    echo '</td>';
    echo '</tr>';
    echo '<tr>';
    echo '<th colspan="4" align="center">' . _AM_XI_MYSQL_ACTION;
    switch ($action) {
        case 1:
            echo _AM_XI_MYSQL_OPTIMIZE . '</td>';
            break;

        case 2:
            echo _AM_XI_MYSQL_REPAIR . '</td>';
            break;

        case 3:
            echo _AM_XI_MYSQL_CHECK . '</td>';
            break;

        case 4:
            echo _AM_XI_MYSQL_ANALYZE . '</td>';
            break;
    }
}
echo '</tr>';

echo '<tr>';
echo '	<th align="center">' . _MI_XI_MYSQL_TABLE . '</th>';
if (!$confirm) {
    echo '	<th align="center">' . _MI_XI_MYSQL_TYPE . '</th>';
    echo '	<th align="center">' . _MI_XI_MYSQL_COLLATION . '</th>';
    echo '	<th align="center">' . _MI_XI_MYSQL_RECORDS . '</th>';
    echo '	<th align="center">' . _MI_XI_MYSQL_SIZE . ' (' . _AM_XI_MYSQL_KOCTETS . ')</th>';
    echo '	<th align="center">' . _MI_XI_MYSQL_OVERHEAD . ' (' . _AM_XI_MYSQL_KOCTETS . ')</th>';
} else {
    echo '	<th align="center">Op</th>';
    echo '	<th align="center">Msg_type</th>';
    echo '	<th align="center">Msg_text</th>';
}
echo '</tr>';

foreach ($tables as $key => $table) {
    echo '<tr>';
    echo '<td class="even">';
    echo $table['Name'];
    echo '</td>';

    if (!$confirm) {
        echo '<td class="odd" align="center">';
        echo $table['Engine'];
        echo '</td>';

        echo '<td class="odd" align="center">';
        echo $table['Collation'];
        echo '</td>';

        echo '<td class="odd" align="right">';
        echo $table['Rows'];
        echo '</td>';

        echo '<td class="odd" align="right">';
        echo number_format($table['Lenght'] / 1000, 2, ',', ' ');
        echo '</td>';

        echo '<td class="odd" align="right">';
        echo number_format($table['Data_free'] / 1000, 2, ',', ' ');
        echo '</td>';
        echo '</tr>';
    } else {
        echo '<td class="odd" align="center">';
        echo $table['Op'];
        echo '</td>';

        echo '<td class="odd" align="center">';
        echo $table['Msg_type'];
        echo '</td>';

        echo '<td class="odd" align="center">';
        echo $table['Msg_text'];
        echo '</td>';
    }
}

if (!$confirm) {
    echo '<tr class="even">';
    echo '	<td align="center"><b><font color="#CC0000">' . $db_table_c . '</font> / ' . $db_table . _MI_XI_MYSQL_TABLE_TXT . '</b></td>';
    echo '	<td align="center" colspan="2"><b>' . _MI_XI_MYSQL_SUM . '</b></td>';
    echo '	<td align="right"><b><font color="#CC0000">' . $db_rows_c . '</font> / ' . $db_rows . '</b></td>';
    echo '	<td align="right"><b><font color="#CC0000">' . number_format($db_length_c / 1000, 2, ',', ' ') . '</font> / ' . number_format($db_length / 1000, 2, ',', ' ') . '</b></td>';
    echo '	<td align="right"><b><font color="#CC0000">' . number_format($db_data_free_c / 1000, 2, ',', ' ') . '</font> / ' . number_format($db_data_free / 1000, 2, ',', ' ') . '</b></td>';
    echo '</tr>';
}
echo '</table>';

echo '<center><hr></center>';

if (!$confirm) {
    echo '<table width="100%" class="outer">';

    echo '<td colspan="5" align="center">';
//    admintitle(_AM_XI_ADMENU3);
    echo '</td>';

    echo '<tr>';
    echo '<th align="center">' . _AM_XI_MYSQL_ID . '</th>';
    echo '<th align="center">' . _AM_XI_MYSQL_DB . '</th>';
    echo '<th align="center">' . _AM_XI_MYSQL_INFO . '</th>';
    echo '<th align="center">' . _AM_XI_MYSQL_TIME . '</th>';
    echo '<th align="center">' . _AM_XI_MYSQL_STATUS . '</th>';
    echo '</tr>';

    $sql = 'SHOW FULL PROCESSLIST';
    $res = $xoopsDB->queryF($sql);
    while ($row = $xoopsDB->fetchArray($res)) {
        echo '<tr>';
        echo '<td class="even" align="center">';
        echo $row['Id'];
        echo '</td>';

        echo '<td class="odd">';
        echo $row['db'];
        echo '</td>';

        echo '<td class="odd">';
        echo $row['Info'];
        echo '</td>';

        echo '<td class="odd" align="right">';
        echo $row['Time'];
        echo '</td>';

        echo '<td class="odd" align="center">';
        echo $row['State'];
        echo '</td>';

        echo '</tr>';
    }
    echo '</table>';

    echo '<center><hr></center>';

    $tray_button = new XoopsFormElementTray('', '');
    $tray_button->addElement(new XoopsFormButton('', 'optimize', _AM_XI_MYSQL_OPTIMIZE, 'submit'));
    $tray_button->addElement(new XoopsFormButton('', 'repair', _AM_XI_MYSQL_REPAIR, 'submit'));
    $tray_button->addElement(new XoopsFormButton('', 'check', _AM_XI_MYSQL_CHECK, 'submit'));
    $tray_button->addElement(new XoopsFormButton('', 'analyze', _AM_XI_MYSQL_ANALYZE, 'submit'));

    echo '<table width="100%" class="outer">';
    echo '<tr>';
    echo '<td class="even" align="center">';
    echo '<form action="' . XOOPSINFO_ADMIN_URL . '/mysqlinfo.php" method="post" style="margin: auto;">';
    echo $tray_button->render();
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
} else {
    $tray_button = new XoopsFormElementTray('', '');
    $tray_button->addElement(new XoopsFormButton('', 'op', _AM_XI_MYSQL_RETURN, 'submit'));

    echo '<table width="100%" class="outer">';
    echo '<tr>';
    echo '<td class="even" align="center">';
    echo '<form action="' . XOOPSINFO_ADMIN_URL . '/mysqlinfo.php" method="post" style="margin: auto;">';
    echo $tray_button->render();
    echo '</form>';
    echo '</td>';
    echo '</tr>';
    echo '</table>';
}
//adminfooter();
//xoops_cp_footer();
include_once __DIR__ . '/admin_footer.php';
