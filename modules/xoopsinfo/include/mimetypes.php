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
 * @return XoopsFormSelect
 */
function TypesMime_GetModulesList()
{
    global $mid;

    $module_handler =& xoops_getHandler('module');
    $criteria       = new CriteriaCompo(new Criteria('hasmain', 1));
    $criteria->add(new Criteria('isactive', 1));
    $criteria->add(new Criteria('mid', 1), 'OR');
    $module_list     = $module_handler->getList($criteria);
    $module_list[-1] = _AM_XI_MIME_NONE;
    ksort($module_list);

    $modules_select = new XoopsFormSelect(_AM_XI_MIME_MODULES, 'mid', $mid);
    $modules_select->setExtra('onchange="document.location=this.options[this.selectedIndex].value"');
    foreach ($module_list as $key => $value) {
        $modules_select->addOption('mimetypes.php?fct=mimetypes&mid=' . $key, $value);
    }
    $modules_select->setValue('mimetypes.php?fct=mimetypes&mid=' . $mid);

    return $modules_select;
}

/**
 * @return XoopsFormSelect
 */
function GetTypeList()
{
    global $mid, $status, $type;

    $mimetypes_Handler =& xoops_getHandler('mimetypes');
    $list_types        = $mimetypes_Handler->Get_TypeList();
    $list_types[-1]    = _AM_XI_MIME_ALL;
    ksort($list_types);

    $form = new XoopsFormSelect(_AM_XI_MIME_MTYPE, 'type', $type);
    $form->setExtra('onchange="document.location=this.options[this.selectedIndex].value"');
    foreach ($list_types as $key => $value) {
        $form->addOption('mimetypes.php?fct=mimetypes&mid=' . $mid . '&status=' . $status . '&type=' . $key, $value);
    }
    $form->setValue('mimetypes.php?fct=mimetypes&mid=' . $mid . '&status=' . $status . '&type=' . $type);

    return $form;
}

function list_mimetypes()
{
    global $uri, $status, $mid, $start, $type;
    $mimetypes_Handler =& xoops_getHandler('mimetypes');
    if ($type != -1) {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('mime_types', '%' . $type . '%', 'LIKE'));
        $mimetypes_list = $mimetypes_Handler->get_mimetypes(20, $start, $status, $criteria);

        if ($status == -1) {
            $mimetypes_count = $mimetypes_Handler->getCount($criteria);
        } else {
            $criteria->add(new Criteria('mime_status', $status, '='));
            $mimetypes_count = $mimetypes_Handler->getCount($criteria);
        }
    } else {
        $mimetypes_list = $mimetypes_Handler->get_mimetypes(20, $start, $status);
        if ($status == -1) {
            $mimetypes_count = $mimetypes_Handler->getCount();
        } else {
            $mimetypes_count = $mimetypes_Handler->getCount(new Criteria('mime_status', $status, '='));
        }
    }

    $form_select = new XoopsFormSelect(_AM_XI_MIME_DISPLAY, 'status');
    $form_select->setExtra('onchange="document.location=this.options[this.selectedIndex].value"');
    $form_select->addOption('mimetypes.php?mid=' . $mid . '&status=-1&type=' . $type, _AM_XI_MIME_ALL);
    $form_select->addOption('mimetypes.php?mid=' . $mid . '&status=0&type=' . $type, _AM_XI_MIME_HIDE);
    $form_select->addOption('mimetypes.php?mid=' . $mid . '&status=1&type=' . $type, _AM_XI_MIME_VIEW);
    $form_select->setValue('mimetypes.php?mid=' . $mid . '&status=' . $status . '&type=' . $type);

    $modules_select = TypesMime_GetModulesList();
    $types_select   = GetTypeList();

    $button_tray = new XoopsFormElementTray('', '');
    $hidden      = new XoopsFormHidden('new', 'new');
    $button_tray->addElement($hidden);
    $butt_new = new XoopsFormButton('', '', _AM_XI_MIME_NEW, 'submit');
    $butt_new->setExtra('onclick="this.form.elements.new.value=\'new\'"');
    $button_tray->addElement($butt_new);

    $hidden_mid = new XoopsFormHidden('mid', -1);

    echo '<form action ="mimetypes.php" method="post">';
    echo '<table width="100%" align="center" class="outer">';
    echo '<tr>';
    echo '	<td colspan="4" align="center">';
    admintitle(_AM_XI_ADMENU7);
    echo '	</td>';
    echo '</tr>';

    echo '<tr>';
    echo '	<td colspan="4" align="center">';
    echo '	<table width="100%" align="center">';
    echo '	<td>' . _AM_XI_MIME_MODULES . $modules_select->render() . '</td>';
    echo '	<td>' . _AM_XI_MIME_MTYPE . $types_select->render() . '</td>';
    echo '	<td>' . _AM_XI_MIME_DISPLAY . $form_select->render() . '</td>';
    echo '	<td align="right">' . $button_tray->render() . '</td>';
    echo '	</table>';
    echo '	</td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th align="center">' . _AM_XI_MIME_EXT . '</th>';
    echo '<th align="center">' . _AM_XI_MIME_NAME . '</th>';
    echo '<th align="center">' . _AM_XI_MIME_STATUS . '</th>';
    echo '<th align="center">' . _AM_XI_MIME_ACTION . '</th>';
    echo '</tr>';

    if ($mimetypes_count > 0) {
        foreach ($mimetypes_list as $key => $mimetypes) {
            if ($mimetypes->mime_status()) {
                $status = '<a href="mimetypes.php?' . $uri . '&mime_id=' . $mimetypes->mime_id() . '&op=hide" /><img src="' . XOOPS_URL . '/modules/xoopsinfo/images/icons/mimetypes.on.gif" align="absmiddle"  alt="' . _AM_XI_MIME_VIEW . '->' . _AM_XI_MIME_HIDE . '" /></a>';
            } else {
                $status = '<a href="mimetypes.php?' . $uri . '&mime_id=' . $mimetypes->mime_id() . '&op=view" /><img src="' . XOOPS_URL . '/modules/xoopsinfo/images/icons/mimetypes.off.gif" align="absmiddle" alt="' . _AM_XI_MIME_HIDE . '->' . _AM_XI_MIME_VIEW . '" /></a>';
            }

            $edit = '<a href="mimetypes.php?' . $uri . '&mime_id=' . $mimetypes->mime_id() . '&op=edit" /><img src="' . XOOPS_URL . '/modules/xoopsinfo/images/icons/edit.gif" align="absmiddle"  alt="' . _AM_XI_MIME_EDIT . '" /></a>';
            $dele = '<a href="mimetypes.php?' . $uri . '&mime_id=' . $mimetypes->mime_id() . '&op=dele" /><img src="' . XOOPS_URL . '/modules/xoopsinfo/images/icons/dele.gif" align="absmiddle"  alt="' . _AM_XI_MIME_DELE . '" /></a>';

            echo '<tr>';
            echo '<td align="center" class="even"><b>' . $mimetypes->mime_ext() . '</b></td>';
            echo '<td align="left"class="odd">' . $mimetypes->mime_name() . '</td>';
            echo '<td align="center" class="odd">' . $status . '</td>';
            echo '<td align="center" class="odd">' . $edit . '&nbsp;&nbsp;&nbsp;' . $dele . '</td>';
            echo '</tr>';
        }
    }
    echo '</table>';

    $pagenav = new XoopsPageNav($mimetypes_count, 20, $start, 'start', $uri);
    echo '<br><div style="text-align:right;">' . $pagenav->renderNav() . '</div>';
    echo '</div>';
    echo $hidden_mid->render();
    echo '</form>';
}

function edit_mimetypes()
{
    global $status, $mid, $start;
    $mime_id = isset($_REQUEST['mime_id']) ? (int)$_REQUEST['mime_id'] : 0;
    $mime    = new XoopsMimetypes($mime_id);

    $forminfo = ($mime_id == 0) ? _AM_XI_MIME_CREATE : _AM_XI_MIME_MODIFY;
    $sform    = new XoopsThemeForm($forminfo, 'mimetype', 'mimetypes.php?');
    $sform->addElement(new XoopsFormText(_AM_XI_MIME_EXT, 'mime_ext', 5, 60, $mime->getVar('mime_ext', 'e')), true);
    $sform->addElement(new XoopsFormText(_AM_XI_MIME_NAME, 'mime_name', 50, 255, $mime->getVar('mime_name', 'e')), true);
    $sform->addElement(new XoopsFormTextArea(_AM_XI_MIME_TYPE, 'mime_types', $mime->getVar('mime_types', 'e'), 7, 60), true);
    $sform->addElement(new XoopsFormRadioYN(_AM_XI_MIME_STATUS, 'mime_status', $mime->getVar('mime_status'), ' ' . _YES . '', ' ' . _NO . ''));

    $button_tray = new XoopsFormElementTray('', '');
    $hidden      = new XoopsFormHidden('op', 'save');
    $button_tray->addElement($hidden);

    if (!$mime_id) {
        $butt_create = new XoopsFormButton('', '', _AM_XI_MIME_CREATE, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'save\'"');
        $button_tray->addElement($butt_create);

        $butt_cancel = new XoopsFormButton('', '', _AM_XI_MIME_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    } else {
        $sform->addElement(new XoopsFormHidden('mime_id', $mime->getVar('mime_id')));
        $sform->addElement(new XoopsFormHidden('mid', $mid));
        $sform->addElement(new XoopsFormHidden('start', $start));
        $sform->addElement(new XoopsFormHidden('status', $status));

        $sform->addElement(new XoopsFormHidden('mime_id', $mime_id));
        $butt_create = new XoopsFormButton('', '', _AM_XI_MIME_MODIFY, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'save\'"');
        $button_tray->addElement($butt_create);

        $butt_cancel = new XoopsFormButton('', '', _AM_XI_MIME_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    }

    $sform->addElement($button_tray);
    $sform->display();
}

function list_mimetypes_perms()
{
    global $xoopsModule, $uri, $status, $mid, $start, $type;
    $mimetypes_Handler =& xoops_getHandler('mimetypes_perms');
    if ($type != -1) {
        $criteria = new CriteriaCompo();
        $criteria->add(new Criteria('mime_types', '%' . $type . '%', 'LIKE'));

        if ($status != -1) {
            $criteria->add(new Criteria('mperm_status', $status, '='));
        }
        $mimetypes_list  = $mimetypes_Handler->get_mimetypes(10, $start, $mid, $criteria);
        $mimetypes_count = $mimetypes_Handler->getCount($criteria);
    } else {
        $criteria = new CriteriaCompo(new Criteria('mperm_module', $mid, '='));
        if ($status != -1) {
            $criteria->add(new Criteria('mperm_status', $status, '='));
        }
        $mimetypes_list  = $mimetypes_Handler->get_mimetypes(10, $start, $mid, $criteria);
        $mimetypes_count = $mimetypes_Handler->getCount($criteria);
    }

    $form_select = new XoopsFormSelect(_AM_XI_MIME_DISPLAY, 'status');
    $form_select->setExtra('onchange="document.location=this.options[this.selectedIndex].value"');
    $form_select->addOption('mimetypes.php?mid=' . $mid . '&status=-1&type=' . $type, _AM_XI_MIME_ALL);
    $form_select->addOption('mimetypes.php?mid=' . $mid . '&status=0&type=' . $type, _AM_XI_MIME_HIDE);
    $form_select->addOption('mimetypes.php?mid=' . $mid . '&status=1&type=' . $type, _AM_XI_MIME_VIEW);
    $form_select->setValue('mimetypes.php?mid=' . $mid . '&status=' . $status . '&type=' . $type);

    $modules_select = TypesMime_GetModulesList();
    $types_select   = GetTypeList();

    $butt_new = new XoopsFormButton('', 'new', _AM_XI_MIME_NEW, 'submit');
    $butt_new->setExtra('onclick="this.form.elements.new.value=\'new\'"');

    $hidden_mid = new XoopsFormHidden('mid', $mid);

    echo '<form action ="mimetypes.php" method="post">';
    echo '<table width="100%" align="center" class="outer">';
    echo '<tr>';
    echo '	<td colspan="5" align="center">';
    admintitle(_AM_XI_ADMENU7 . '<br>' . _AM_XI_MIME_MODULES . ' <font color="#CC0000">' . $mimetypes_Handler->mime_module($mid) . '</font>');
    echo '	</td>';
    echo '</tr>';

    echo '<tr>';
    echo '    <td colspan="5" align="center">';
    echo '    <table width="100%" align="center">';

    if ($xoopsModule->dirname() === 'xoopsinfo') {
        echo '<td>' . _AM_XI_MIME_MODULES . $modules_select->render() . '</td>';
    }
    echo '    <td>' . _AM_XI_MIME_MTYPE . $types_select->render() . '</td>';
    echo '    <td>' . _AM_XI_MIME_DISPLAY . $form_select->render() . '</td>';
    echo '    <td align="right">' . $butt_new->render() . '</td>';
    echo '    </table>';
    echo '    </td>';
    echo '</tr>';

    echo '<tr>';
    echo '<th align="center" width="50px">' . _AM_XI_MIME_EXT . '</th>';
    echo '<th align="center">' . _AM_XI_MIME_NAME . '</th>';
    echo '<th align="center" width="180px">' . _AM_XI_MIME_GROUPS . '</th>';
    echo '<th align="center" width="50px">' . _AM_XI_MIME_STATUS . '</th>';
    echo '<th align="center" width="50px">' . _AM_XI_MIME_ACTION . '</th>';
    echo '</tr>';

    if ($mimetypes_count > 0) {
        foreach ($mimetypes_list as $key => $mimetypes) {
            $groups_select = new XoopsFormSelectGroup('', 'mperm_groups[' . $mimetypes->mime_id() . ']', true, $mimetypes->GetGroups(), 5, true);

            $form_mperm_id     = new XoopsFormHidden('mperm_id[' . $mimetypes->mime_id() . ']', $mimetypes->mime_id());
            $form_mperm_mime   = new XoopsFormHidden('mperm_mime[' . $mimetypes->mime_id() . ']', $mimetypes->getVar('mperm_mime'));
            $form_mperm_module = new XoopsFormHidden('mperm_module[' . $mimetypes->mime_id() . ']', $mimetypes->getVar('mperm_module'));

            $mperm_maxwidth = $mimetypes->getVar('mperm_maxwidth') ? $mimetypes->getVar('mperm_maxwidth') : 120;
            $form_maxwidth  = new XoopsFormText(_AM_XI_MIME_WIDTH, 'mperm_maxwidth[' . $mimetypes->mime_id() . ']', 3, 4, $mperm_maxwidth);

            $mperm_maxheight = $mimetypes->getVar('mperm_maxheight') ? $mimetypes->getVar('mperm_maxheight') : 120;
            $form_maxheight  = new XoopsFormText(_AM_XI_MIME_HEIGHT, 'mperm_maxheight[' . $mimetypes->mime_id() . ']', 3, 4, $mperm_maxheight);

            $mperm_maxsize = $mimetypes->getVar('mperm_maxsize') ? $mimetypes->getVar('mperm_maxsize') : 50000;
            $form_maxsize  = new XoopsFormText(_AM_XI_MIME_SIZE, 'mperm_maxsize[' . $mimetypes->mime_id() . ']', 8, 10, $mperm_maxsize);

            if ($mimetypes->mperm_status()) {
                $status = '<a href="mimetypes.php?' . $uri . '&mime_id=' . $mimetypes->mperm_mime() . '&op=hide" /><img src="' . XOOPS_URL . '/modules/xoopsinfo/images/icons/mimetypes.on.gif" align="absmiddle"  alt="' . _AM_XI_MIME_VIEW . '->' . _AM_XI_MIME_HIDE . '" /></a>';
            } else {
                $status = '<a href="mimetypes.php?' . $uri . '&mime_id=' . $mimetypes->mperm_mime() . '&op=view" /><img src="' . XOOPS_URL . '/modules/xoopsinfo/images/icons/mimetypes.off.gif" align="absmiddle" alt="' . _AM_XI_MIME_HIDE . '->' . _AM_XI_MIME_VIEW . '" /></a>';
            }

            $edit = '<a href="mimetypes.php?' . $uri . '&mime_id=' . $mimetypes->mime_id() . '&op=edit" /><img src="' . XOOPS_URL . '/modules/xoopsinfo/images/icons/edit.gif" align="absmiddle"  alt="' . _AM_XI_MIME_EDIT . '" /></a>';
            $dele = '<a href="mimetypes.php?' . $uri . '&mime_id=' . $mimetypes->mime_id() . '&op=dele" /><img src="' . XOOPS_URL . '/modules/xoopsinfo/images/icons/dele.gif" align="absmiddle"  alt="' . _AM_XI_MIME_DELE . '" /></a>';

            echo '<tr>';
            echo '<td align="center" class="even"><b>' . $mimetypes->mime_ext() . '</b></td>';
            echo '<td align="left"class="odd"><b>' . $mimetypes->mime_name() . '</b><br><div style="text-align:right">' . _AM_XI_MIME_WIDTH . ' : ' . $form_maxwidth->render() . '<br>' . _AM_XI_MIME_HEIGHT . ' : ' . $form_maxheight->render() . '<br>' . _AM_XI_MIME_SIZE . ' : '
                 . $form_maxsize->render() . $form_mperm_id->render() . $form_mperm_mime->render() . $form_mperm_module->render() . '</div></td>';
            echo '<td align="center" class="odd">' . $groups_select->render() . '</td>';
            echo '<td align="center" class="odd">' . $status . '</td>';
            echo '<td align="center" class="odd">' . $edit . '&nbsp;&nbsp;&nbsp;' . $dele . '</td>';
            echo '</tr>';
        }
    }
    $butt_create = new XoopsFormButton('', 'op', _AM_XI_MIME_SAVEALL, 'submit');
    $butt_create->setExtra('onclick="this.form.elements.op.value=\'saveall\'"');

    echo '<tr>';
    echo '   <td colspan="5" align="center" class="even">';
    echo $butt_create->render();
    echo '   </td>';
    echo '<tr>';

    echo '</table>';

    $pagenav = new XoopsPageNav($mimetypes_count, 20, $start, 'start', $uri);
    echo '<br><div style="text-align:right;">' . $pagenav->renderNav() . '</div>';
    echo '</div>';
    echo $hidden_mid->render();
    echo '</form>';
}

function edit_mimetypes_modules()
{
    global $status, $mid, $start;
    $mime_id      = isset($_REQUEST['mime_id']) ? (int)$_REQUEST['mime_id'] : 0;
    $mime         = new XoopsMimetypes_perms($mime_id);
    $mime_Handler =& xoops_getHandler('mimetypes_perms');

    admintitle(_AM_XI_MIME_MODULES . ' <font color="#CC0000">' . $mime_Handler->mime_module($mid) . '</font>');

    $forminfo = ($mime_id == 0) ? _AM_XI_MIME_CREATE : _AM_XI_MIME_MODIFY;
    $sform    = new XoopsThemeForm($forminfo, 'mimetype', 'mimetypes.php?');

    $mimetypes_Handler =& xoops_getHandler('mimetypes');
    $sform->addElement($mimetypes_Handler->XoopsFormSelectMime(_AM_XI_MIME_NAME, 'mperm_mime', $mime->getVar('mperm_mime')));

    $groups = $mime->GetGroups() ? $mime->GetGroups() : array(XOOPS_GROUP_ADMIN);
    $sform->addElement(new XoopsFormSelectGroup(_AM_XI_MIME_GROUPS, 'mperm_groups', true, $groups, 5, true));
    $sform->addElement(new XoopsFormRadioYN(_AM_XI_MIME_STATUS, 'mperm_status', $mime->getVar('mperm_status'), ' ' . _YES . '', ' ' . _NO . ''));

    $mperm_maxwidth  = $mime->getVar('mperm_maxwidth') ? $mime->getVar('mperm_maxwidth') : 120;
    $mperm_maxheight = $mime->getVar('mperm_maxheight') ? $mime->getVar('mperm_maxheight') : 120;
    $mperm_maxsize   = $mime->getVar('mperm_maxsize') ? $mime->getVar('mperm_maxsize') : 50000;
    $sform->addElement(new XoopsFormText(_AM_XI_MIME_WIDTH, 'mperm_maxwidth', 3, 4, $mperm_maxwidth));
    $sform->addElement(new XoopsFormText(_AM_XI_MIME_HEIGHT, 'mperm_maxheight', 3, 4, $mperm_maxheight));
    $sform->addElement(new XoopsFormText(_AM_XI_MIME_SIZE, 'mperm_maxsize', 8, 10, $mperm_maxsize), true);

    $button_tray = new XoopsFormElementTray('', '');
    $hidden      = new XoopsFormHidden('op', 'save');
    $button_tray->addElement($hidden);

    $sform->addElement(new XoopsFormHidden('mperm_id', $mime->getVar('mperm_id')));
    $sform->addElement(new XoopsFormHidden('mperm_module', $mid));
    $sform->addElement(new XoopsFormHidden('mid', $mid));
    if (!$mime_id) {
        $butt_create = new XoopsFormButton('', '', _AM_XI_MIME_CREATE, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'save\'"');
        $button_tray->addElement($butt_create);

        $butt_cancel = new XoopsFormButton('', '', _AM_XI_MIME_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    } else {
        $sform->addElement(new XoopsFormHidden('start', $start));
        $sform->addElement(new XoopsFormHidden('status', $status));

        $sform->addElement(new XoopsFormHidden('mime_id', $mime_id));
        $butt_create = new XoopsFormButton('', '', _AM_XI_MIME_MODIFY, 'submit');
        $butt_create->setExtra('onclick="this.form.elements.op.value=\'save\'"');
        $button_tray->addElement($butt_create);

        $butt_cancel = new XoopsFormButton('', '', _AM_XI_MIME_CANCEL, 'button');
        $butt_cancel->setExtra('onclick="history.go(-1)"');
        $button_tray->addElement($butt_cancel);
    }

    $sform->addElement($button_tray);
    $sform->display();
}

/**
 * @param string $dirname
 */
function install_MimeTypes($dirname = '')
{
    include_once(XOOPS_ROOT_PATH . '/kernel/mimetypes.php');
    $hModule = &xoops_getHandler('module');

    if ($ModuleInfo = $hModule->getByDirname($dirname)) {
        if (($hModule->getByDirName('xoopsinfo') && substr(XOOPS_VERSION, 6, 3) == '2.0' && substr(XOOPS_VERSION, 10, 2) < 16)
            || ($hModule->getByDirName('xoopsinfo') && substr(XOOPS_VERSION, 6, 3) == '2.2')
        ) {
            $newmid    = $ModuleInfo->mid();
            $mimeTypes = $ModuleInfo->getInfo('mimetypes');
            if ($mimeTypes != false) {
                $mymsgs[]          = 'Adding module mimetypes data...';
                $mime_handler      =& xoops_getHandler('mimetypes');
                $mimeperms_handler =& xoops_getHandler('mimetypes_perms');
                $mime_id           = 0;
                foreach ($mimeTypes as $key => $mimeType) {
                    $mimetypeObj = $mime_handler->get_byExt($mimeType['mime_ext']);
                    if (count($mimetypeObj) == 0) {
                        $mimetypeObj = new xoopsmimetypes();
                        $mimetypeObj->setVar('mime_id', 0);
                        $mimetypeObj->setVar('mime_ext', $mimeType['mime_ext']);
                        $mimetypeObj->setVar('mime_types', $mimeType['mime_types']);
                        $mimetypeObj->setVar('mime_name', $mimeType['mime_name']);
                        $mimetypeObj->setVar('mime_status', $mimeType['mime_status']);
                        if ($mime_handler->insert($mimetypeObj, true)) {
                            $mymsgs[] = '&nbsp;&nbsp;Adding Mimetype <b>' . $mimeType['mime_ext'] . '</b> to the database.';
                            $mime_id  = $mimetypeObj->getVar('mime_id');
                        } else {
                            $mymsgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Could not insert Mimetype <b>' . $mimeType['mime_ext'] . '</b> to the database.</span>';
                        }
                    } else {
                        $mymsgs[]    = '&nbsp;&nbsp;Mimetype <b>' . $mimeType['mime_ext'] . '</b> already existing.';
                        $mimetypeObj = new xoopsmimetypes();
                        $mimetypeObj->load_byExt($mimeType['mime_ext']);
                        $mime_id = $mimetypeObj->getVar('mime_id');
                    }
                    unset($mimetypeObj);

                    $mimetype_permsObj = $mimeperms_handler->get_byMimeModule($mime_id, $newmid);
                    if (count($mimetype_permsObj) == 0) {
                        $mimetype_permsObj = new xoopsmimetypes_perms();
                        $mimetype_permsObj->setVar('mperm_id', 0);
                        $mimetype_permsObj->setVar('mperm_mime', $mime_id);
                        $mimetype_permsObj->setVar('mperm_module', $newmid);
                        $mimetype_permsObj->setVar('mperm_groups', XOOPS_GROUP_ADMIN);
                        $mimetype_permsObj->setVar('mperm_status', $mimeType['mime_status']);
                        $mimetype_permsObj->setVar('mperm_maxwidth', $mimeType['mperm_maxwidth']);
                        $mimetype_permsObj->setVar('mperm_maxheight', $mimeType['mperm_maxheight']);
                        $mimetype_permsObj->setVar('mperm_maxsize', $mimeType['mperm_maxsize']);
                        if (!$mimeperms_handler->insert($mimetype_permsObj, true)) {
                            $mymsgs[] = '&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Could not insert Mimetype permission <b>' . $mimeType['mime_ext'] . '</b> to the database.</span>';
                        } else {
                            $mymsgs[] = '&nbsp;&nbsp;&nbsp;&nbsp;Adding Mimetype permission <b>' . $mimeType['mime_ext'] . '</b> to the database.';
                        }
                    } else {
                        $mymsgs[] = '&nbsp;&nbsp;&nbsp;&nbsp;Mimetype Permissions<b>' . $mimeType['mime_ext'] . '</b> already existing.';
                    }
                    unset($mimetype_permsObj);
                }
            }
        }
    }
}

/**
 * @param string $dirname
 */
function uninstall_MimeTypes($dirname = '')
{
    include_once(XOOPS_ROOT_PATH . '/kernel/mimetypes.php');
    $hModule = &xoops_getHandler('module');

    if ($ModuleInfo = $hModule->getByDirname($dirname)) {
        if (($hModule->getByDirName('xoopsinfo') && substr(XOOPS_VERSION, 6, 3) == '2.0' && substr(XOOPS_VERSION, 10, 2) < 16)
            || ($hModule->getByDirName('xoopsinfo') && substr(XOOPS_VERSION, 6, 3) == '2.2')
        ) {
            $newmid    = $ModuleInfo->mid();
            $mimeTypes = $ModuleInfo->getInfo('mimetypes');
            if ($mimeTypes != false) {
                $msgs[]            = 'Deleting Mime Types permission...';
                $mime_handler      =& xoops_getHandler('mimetypes');
                $mimeperms_handler =& xoops_getHandler('mimetypes_perms');
                $mime_id           = 0;
                foreach ($mimeTypes as $key => $mimeType) {
                    $mimetypeObj = new xoopsmimetypes();
                    $mimetypeObj->load_byExt($mimeType['mime_ext']);
                    $mime_id = $mimetypeObj->getVar('mime_id');

                    $mimetype_permsObj = $mimeperms_handler->get_byMimeModule($mime_id, $ModuleInfo->getVar('mid'));
                    if (!$mimeperms_handler->delete($mimetype_permsObj[0], true)) {
                        $msgs[] = '&nbsp;&nbsp;<span style="color:#ff0000;">ERROR: Could not delete Mime Type permission from the database. Extension : <b>' . $mimeType['mime_ext'] . '</b></span>';
                    } else {
                        $msgs[] = '&nbsp;&nbsp;Mime Type permission deleted from the database. Extension : <b>' . $mimeType['mime_ext'] . '</b>';
                    }
                }
            }
        }
    }
}
