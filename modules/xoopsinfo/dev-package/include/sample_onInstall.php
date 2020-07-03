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
if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php')) {
    include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/include/mimetypes.php');

    include_once(XOOPS_ROOT_PATH . '/class/uploader.php');

    if (defined('_XI_MIMETYPE')) {
        install_MimeTypes('module dirname');
    }
}
