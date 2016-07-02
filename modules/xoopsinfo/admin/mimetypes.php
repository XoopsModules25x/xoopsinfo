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

include_once(XOOPS_ROOT_PATH . '/kernel/mimetypes.php');
include_once(XOOPS_ROOT_PATH . '/class/pagenav.php');
include_once(XOOPS_ROOT_PATH . '/class/xoopsformloader.php');
include_once(XOOPS_ROOT_PATH . '/class/uploader.php');

$op       = isset($_REQUEST['op']) ? trim($_REQUEST['op']) : '';
$create   = isset($_REQUEST['new']) ? true : false;
$start    = isset($_REQUEST['start']) ? (int)$_REQUEST['start'] : 0;
$status   = isset($_REQUEST['status']) ? (int)$_REQUEST['status'] : -1;
$mid      = isset($_REQUEST['mid']) ? (int)$_REQUEST['mid'] : -1;
$confirm  = isset($_REQUEST['confirm']) ? (int)$_REQUEST['confirm'] : 0;
$mime_id  = isset($_REQUEST['mime_id']) ? (int)$_REQUEST['mime_id'] : 0;
$mperm_id = isset($_REQUEST['mperm_id']) ? (int)$_REQUEST['mperm_id'] : 0;
$type     = isset($_REQUEST['type']) ? $_REQUEST['type'] : -1;

$uri = 'mid=' . $mid . '&start=' . $start . '&status=' . $status . '&type=' . $type;

if ($create) {
    $op = 'edit';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$create) {
    if ($op === 'save') {
        if ($mid < 0) {
            $mime_id     = isset($_REQUEST['mime_id']) ? (int)$_REQUEST['mime_id'] : 0;
            $mime_ext    = isset($_REQUEST['mime_ext']) ? $_REQUEST['mime_ext'] : '';
            $mime_types  = isset($_REQUEST['mime_types']) ? $_REQUEST['mime_types'] : '';
            $mime_name   = isset($_REQUEST['mime_name']) ? $_REQUEST['mime_name'] : '';
            $mime_status = isset($_REQUEST['mime_status']) ? (int)$_REQUEST['mime_status'] : 0;

            $mimetypes_Handler = xoops_getHandler('mimetypes');
            $mimeObj           = new XoopsMimetypes($mime_id);
            $mimeObj->setVar('mime_id', $mime_id);
            $mimeObj->setVar('mime_ext', $mime_ext);
            $mimeObj->setVar('mime_types', $mime_types);
            $mimeObj->setVar('mime_name', $mime_name);
            $mimeObj->setVar('mime_status', $mime_status);
            if (!$mimetypes_Handler->insert($mimeObj, true)) {
                redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
            }
        } else {
            $mperm_id        = isset($_REQUEST['mperm_id']) ? (int)$_REQUEST['mperm_id'] : 0;
            $mperm_mime      = isset($_REQUEST['mperm_mime']) ? $_REQUEST['mperm_mime'] : '';
            $mperm_module    = isset($_REQUEST['mperm_module']) ? $_REQUEST['mperm_module'] : '';
            $mperm_groups    = isset($_REQUEST['mperm_groups']) ? $_REQUEST['mperm_groups'] : array();
            $mperm_status    = isset($_REQUEST['mperm_status']) ? (int)$_REQUEST['mperm_status'] : 0;
            $mperm_maxwidth  = isset($_REQUEST['mperm_maxwidth']) ? (int)$_REQUEST['mperm_maxwidth'] : 0;
            $mperm_maxheight = isset($_REQUEST['mperm_maxheight']) ? (int)$_REQUEST['mperm_maxheight'] : 0;
            $mperm_maxsize   = isset($_REQUEST['mperm_maxsize']) ? (int)$_REQUEST['mperm_maxsize'] : 0;
            $result          = true;

            $mimetypes_Handler = xoops_getHandler('mimetypes_perms');
            if ($mperm_id != 0) {
                $mimeObj = new XoopsMimetypes_perms($mperm_id);
                if ($mperm_mime == $mimeObj->mperm_mime()) {
                    $result = $mimetypes_Handler->deletebyMimeModule($mimeObj, true);
                }
            }

            if ($result) {
                foreach ($mperm_groups as $key => $group) {
                    $mimeObj = new XoopsMimetypes_perms();
                    $mimeObj->setVar('mperm_id', 0);
                    $mimeObj->setVar('mperm_mime', $mperm_mime);
                    $mimeObj->setVar('mperm_module', $mperm_module);
                    $mimeObj->setVar('mperm_groups', $group);
                    $mimeObj->setVar('mperm_status', $mperm_status);
                    $mimeObj->setVar('mperm_maxwidth', $mperm_maxwidth);
                    $mimeObj->setVar('mperm_maxheight', $mperm_maxheight);
                    $mimeObj->setVar('mperm_maxsize', $mperm_maxsize);
                    if (!$mimetypes_Handler->insert($mimeObj, true)) {
                        redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
                    }
                }
            }
        }
        redirect_header('mimetypes.php?' . $uri, 3, _MD_AM_DBUPDATED);
        exit();
    }

    if ($op === 'saveall') {
        $mimetypes_Handler = xoops_getHandler('mimetypes_perms');
        $mperm_ids         = $_REQUEST['mperm_id'] ? $_REQUEST['mperm_id'] : array();
        foreach ($mperm_ids as $mperm_id => $value) {
            $mperm_mime      = $_REQUEST['mperm_mime'][$mperm_id];
            $mperm_module    = $_REQUEST['mperm_module'][$mperm_id];
            $mperm_maxwidth  = $_REQUEST['mperm_maxwidth'][$mperm_id];
            $mperm_maxheight = $_REQUEST['mperm_maxheight'][$mperm_id];
            $mperm_maxsize   = $_REQUEST['mperm_maxsize'][$mperm_id];
            $mperm_groups    = $_REQUEST['mperm_groups'][$mperm_id];

            $mimetypeObjs = $mimetypes_Handler->get_byMimeModule($mperm_mime, $mperm_module);
            $groups       = array();
            foreach ($mimetypeObjs as $key => $mimetypeObj) {
                $groups[]     = $mimetypeObj->getVar('mperm_groups');
                $mperm_status = $mimetypeObj->getVar('mperm_status');
                if (in_array($mimetypeObj->getVar('mperm_groups'), $mperm_groups)) {
                    if ($mimetypeObj->getVar('mperm_maxwidth') != $mperm_maxwidth || $mimetypeObj->getVar('mperm_maxheight') != $mperm_maxheight || $mimetypeObj->getVar('mperm_maxsize') != $mperm_maxsize) {
                        $mimetypeObj->setVar('mperm_maxwidth', $mperm_maxwidth);
                        $mimetypeObj->setVar('mperm_maxheight', $mperm_maxheight);
                        $mimetypeObj->setVar('mperm_maxsize', $mperm_maxsize);
                        if (!$mimetypes_Handler->insert($mimetypeObj, true)) {
                            redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
                        }
                    }
                } else {
                    if (!$mimetypes_Handler->delete($mimetypeObj, true)) {
                        redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
                    }
                }
            }

            $newgroups = array_diff($mperm_groups, $groups);
            foreach ($newgroups as $key => $group) {
                $mimeObj = new XoopsMimetypes_perms();

                $mimeObj->setVar('mperm_id', 0);
                $mimeObj->setVar('mperm_mime', $mperm_mime);
                $mimeObj->setVar('mperm_module', $mperm_module);
                $mimeObj->setVar('mperm_groups', $group);
                $mimeObj->setVar('mperm_status', $mperm_status);
                $mimeObj->setVar('mperm_maxwidth', $mperm_maxwidth);
                $mimeObj->setVar('mperm_maxheight', $mperm_maxheight);
                $mimeObj->setVar('mperm_maxsize', $mperm_maxsize);
                if (!$mimetypes_Handler->insert($mimeObj, true)) {
                    redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
                }
            }
        }
        redirect_header('mimetypes.php?' . $uri, 3, _MD_AM_DBUPDATED);
        exit();
    }

    if ($op = 'dele' && $confirm) {
        if ($mid < 0) {
            $mimetypes_Handler = xoops_getHandler('mimetypes');
            $mimeObj           = new XoopsMimetypes($mime_id);
            if (!$mimetypes_Handler->delete($mimeObj, true)) {
                redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
            }
        } else {
            $mimetypes_Handler = xoops_getHandler('mimetypes_perms');
            $mimeObj           = new XoopsMimetypes_perms($mperm_id);
            if (!$mimetypes_Handler->deletebyMime($mimeObj, true)) {
                redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
            }
        }
        redirect_header('mimetypes.php?mid=' . $mid . '&status=' . $status, 3, _MD_AM_DBUPDATED);
        exit();
    }
}

switch ($op) {
    case 'hide':
        if ($mid < 0) {
            $mimetypes_Handler = xoops_getHandler('mimetypes');
            $mimeObj           = new XoopsMimetypes($mime_id);
            $mimeObj->setVar('mime_status', 0);
            if (!$mimetypes_Handler->insert($mimeObj, true)) {
                redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
            }
        } else {
            $mimetypes_Handler = xoops_getHandler('mimetypes_perms');
            $mimeObjs          = $mimetypes_Handler->get_byMimeModule($mime_id, $mid);
            foreach ($mimeObjs as $mimeObj) {
                $mimeObj->setVar('mperm_status', 0);
                if (!$mimetypes_Handler->insert($mimeObj, true)) {
                    redirect_header('mimetype.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
                }
            }
        }
        redirect_header('mimetypes.php?' . $uri, 3, _MD_AM_DBUPDATED);
        break;

    case 'view':
        if ($mid < 0) {
            $mimetypes_Handler = xoops_getHandler('mimetypes');
            $mimeObj           = new XoopsMimetypes($mime_id);
            $mimeObj->setVar('mime_status', 1);
            if (!$mimetypes_Handler->insert($mimeObj, true)) {
                redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
            }
        } else {
            $mimetypes_Handler = xoops_getHandler('mimetypes_perms');
            $mimeObjs          = $mimetypes_Handler->get_byMimeModule($mime_id, $mid);
            foreach ($mimeObjs as $mimeObj) {
                $mimeObj->setVar('mperm_status', 1);
                if (!$mimetypes_Handler->insert($mimeObj, true)) {
                    redirect_header('mimetypes.php?' . $uri, 3, $mimetypes_Handler->getHtmlErrors());
                }
            }
        }
        redirect_header('mimetypes.php?' . $uri, 3, _MD_AM_DBUPDATED);
        break;

    case 'dele':
        xoops_cp_header();
        $indexAdmin = new ModuleAdmin();
        echo $indexAdmin->addNavigation(basename(__FILE__));
//        if (defined("_PHPSYSINFO") && defined("_PHPSECINFO")) {
//            adminmenu(8);
//        } elseif ((defined("_PHPSYSINFO") && !defined("_PHPSECINFO")) || (!defined("_PHPSYSINFO") && defined("_PHPSECINFO"))) {
//            adminmenu(7);
//        } elseif (!defined("_PHPSYSINFO") && !defined("_PHPSECINFO")) {
//            adminmenu(6);
//        }

        $mime_id = isset($_REQUEST['mime_id']) ? (int)$_REQUEST['mime_id'] : (int)$mime_id;
        if ($mid < 0) {
            $sql    = 'SELECT mime_id, mime_name FROM ' . $xoopsDB->prefix('mimetypes') . ' WHERE mime_id=' . $mime_id;
            $result = $xoopsDB->queryF($sql);
            list($mime_id, $mime_name) = $xoopsDB->fetchrow($result);
            xoops_confirm(array('op' => 'dele', 'mime_id' => $mime_id, 'confirm' => 1, 'mime_name' => $mime_name, 'status' => $status, 'mid' => $mid), 'mimetypes.php?', _AM_XI_MIME_DELETETHIS . '<br><br>' . $mime_name, _AM_XI_MIME_DELE);
        } else {
            $sql    =
                'SELECT p.mperm_id, t.mime_id, t.mime_name, m.name FROM ' . $xoopsDB->prefix('mimetypes_perms') . ' p LEFT JOIN ' . $xoopsDB->prefix('mimetypes') . ' t on p.mperm_mime = t.mime_id LEFT JOIN ' . $xoopsDB->prefix('modules') . ' m on p.mperm_module = m.mid WHERE mperm_id=' . $mime_id;
            $result = $xoopsDB->queryF($sql);

            list($mperm_id, $mime_id, $mime_name, $mod_name) = $xoopsDB->fetchrow($result);
            xoops_confirm(array('op' => 'dele', 'mperm_id' => $mperm_id, 'mime_id' => $mime_id, 'confirm' => 1, 'mime_name' => $mime_name, 'mod_name' => $mod_name, 'status' => $status, 'mid' => $mid), 'mimetypes.php?',
                          _AM_XI_MIME_DELETETHIS . "<br><br><font color='#CC0000'>" . $mod_name . '</font><br>' . $mime_name, _AM_XI_MIME_DELE);
        }
        //adminfooter();
        //xoops_cp_footer();
        include_once __DIR__ . '/admin_footer.php';
        break;

    case 'edit':
        xoops_cp_header();

//        if (defined("_PHPSYSINFO")) {
//            adminmenu(7);
//        } else {
//            adminmenu(6);
//        }

        if ($mid < 0) {
            edit_mimetypes();
        } else {
            edit_mimetypes_modules();
        }
        //adminfooter();
        //xoops_cp_footer();
        include_once __DIR__ . '/admin_footer.php';
        break;

    default:
        xoops_cp_header();

//        if (defined("_PHPSYSINFO")) {
//            adminmenu(7);
//        } else {
//            adminmenu(6);
//        }

        include_once(XOOPS_ROOT_PATH . '/class/uploader.php');
        if (!defined('_XI_MIMETYPE')) {
            if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/mimetypes.txt')) {
                include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/mimetypes.txt');
            } else {
                include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/english/mimetypes.txt');
            }
        } else {
            if ($mid < 0) {
                list_mimetypes();
            } else {
                list_mimetypes_perms();
            }
        }
        //adminfooter();
        //xoops_cp_footer();
        include_once __DIR__ . '/admin_footer.php';
        break;
}
