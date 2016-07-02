<?php
/**
 * XOOPS - PHP Content Management System
 * Copyright (c) 2001 - 2006 <http://www.xoops.org/>
 *
 * Module: xoopsinfo 2.0
 * Licence : GPL
 * Authors :
 *           - Jmorris
 *            - Marco
 *            - Christian
 *            - DuGris (http://www.dugris.info)
 */

include('../../mainfile.php');
global $xoopsDB, $xoopsConfig, $xoopsModule;

if (file_exists(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/main.php')) {
    include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/' . $xoopsConfig['language'] . '/main.php');
} else {
    include_once(XOOPS_ROOT_PATH . '/modules/xoopsinfo/language/english/main.php');
}

$ConfigReferer = explode('|', $xoopsModuleConfig['xi_img_referer']);
$ref_url       = getenv('HTTP_REFERER');
preg_match('|^http://(.*?)/|', $ref_url, $referers);
$referer = $referers[1];

if (!in_array($referer, $ConfigReferer)) {
    header('Content-type: image/gif');
    $im = imagecreatefromgif(XOOPS_URL . '/modules/xoopsinfo/images/xoopsinfo.gif');
    imagegif($im);
    imagedestroy($im);
} else {
    $result = $GLOBALS['xoopsDB']->query('SELECT VERSION()');
    list($mysql_version) = $GLOBALS['xoopsDB']->fetchRow($result);
    $GLOBALS['xoopsDB']->freeRecordSet($result);

    // Create image
    header('Content-type: image/png');
    $im = @imagecreate(551, 221) or die("Impossible d'initialiser la biblioth�que GD");

    // Background Color
    $imgColorHex      = str_replace('#', '', $xoopsModuleConfig['xi_img_background']);
    $int              = hexdec($imgColorHex);
    $arr              = array('red' => 0xFF & ($int >> 0x10), 'green' => 0xFF & ($int >> 0x8), 'blue' => 0xFF & $int);
    $background_color = imagecolorallocate($im, $arr['red'], $arr['green'], $arr['blue']);

    // Border Color
    $imgColorHex  = str_replace('#', '', $xoopsModuleConfig['xi_img_border']);
    $int          = hexdec($imgColorHex);
    $arr          = array('red' => 0xFF & ($int >> 0x10), 'green' => 0xFF & ($int >> 0x8), 'blue' => 0xFF & $int);
    $border_color = imagecolorallocate($im, $arr['red'], $arr['green'], $arr['blue']);
    imagerectangle($im, 0, 0, 550, 220, $border_color);

    // Separate Color
    $int            = hexdec('E18A00');
    $arr            = array('red' => 0xFF & ($int >> 0x10), 'green' => 0xFF & ($int >> 0x8), 'blue' => 0xFF & $int);
    $separate_color = imagecolorallocate($im, $arr['red'], $arr['green'], $arr['blue']);
    imagefilledrectangle($im, 10, 70, 540, 72, $separate_color);
    imagefilledrectangle($im, 10, 130, 540, 132, $separate_color);
    imagefilledrectangle($im, 10, 175, 540, 177, $separate_color);

    // ON Color
    $int      = hexdec('009900');
    $arr      = array('red' => 0xFF & ($int >> 0x10), 'green' => 0xFF & ($int >> 0x8), 'blue' => 0xFF & $int);
    $color_on = imagecolorallocate($im, $arr['red'], $arr['green'], $arr['blue']);

    // OFF Color
    $int       = hexdec('CC0000');
    $arr       = array('red' => 0xFF & ($int >> 0x10), 'green' => 0xFF & ($int >> 0x8), 'blue' => 0xFF & $int);
    $color_off = imagecolorallocate($im, $arr['red'], $arr['green'], $arr['blue']);

    // Constant Color
    $imgColorHex = str_replace('#', '', $xoopsModuleConfig['xi_img_constant']);
    $int         = hexdec($imgColorHex);
    $arr         = array('red' => 0xFF & ($int >> 0x10), 'green' => 0xFF & ($int >> 0x8), 'blue' => 0xFF & $int);
    $var_color   = imagecolorallocate($im, $arr['red'], $arr['green'], $arr['blue']);

    // Xoops info Color
    $imgColorHex = str_replace('#', '', $xoopsModuleConfig['xi_img_data']);
    $int         = hexdec($imgColorHex);
    $arr         = array('red' => 0xFF & ($int >> 0x10), 'green' => 0xFF & ($int >> 0x8), 'blue' => 0xFF & $int);
    $data_color  = imagecolorallocate($im, $arr['red'], $arr['green'], $arr['blue']);

    $font = $xoopsModuleConfig['xi_img_font'];
    $coef = array(1 => 1, 2 => 1, 3 => 1, 4 => 1.15, 5 => 1.3);
    $col1 = 185 * $coef[$font];
    $col2 = 210 * $coef[$font];
    $col3 = 235 * $coef[$font];
    // XOOPS_URL
    imagestring($im, $font, 10, 5, _XI_WEBSITE, $var_color);
    imagestring($im, $font, $col1, 5, ' : ', $var_color);
    imagestring($im, $font, $col2, 5, XOOPS_URL, $data_color);

    // XOOPS_VERSION
    imagestring($im, $font, 10, 20, _XI_XOOPS_VERSION, $var_color);
    imagestring($im, $font, $col1, 20, ' : ', $var_color);
    imagestring($im, $font, $col2, 20, XOOPS_VERSION, $data_color);

    // Theme
    imagestring($im, $font, 10, 35, _XI_XOOPS_THEME, $var_color);
    imagestring($im, $font, $col1, 35, ' : ', $var_color);
    imagestring($im, $font, $col2, 35, $xoopsConfig['theme_set'], $data_color);

    // template
    imagestring($im, $font, 10, 50, _XI_XOOPS_TEMPLATE, $var_color);
    imagestring($im, $font, $col1, 50, ' : ', $var_color);
    imagestring($im, $font, $col2, 50, $xoopsConfig['template_set'], $data_color);

    // Server Version
    imagestring($im, $font, 10, 80, _XI_SOFTWARE_SERVEUR, $var_color);
    imagestring($im, $font, $col1, 80, ' : ', $var_color);
    imagestring($im, $font, $col2, 80, $_SERVER['SERVER_SOFTWARE'], $data_color);

    // PHP Version
    imagestring($im, $font, 10, 95, _XI_PHP_VERSION, $var_color);
    imagestring($im, $font, $col1, 95, ' : ', $var_color);
    imagestring($im, $font, $col2, 95, phpversion(), $data_color);

    // Mysql Version
    imagestring($im, $font, 10, 110, _XI_MSQUL_VERSION, $var_color);
    imagestring($im, $font, $col1, 110, ' : ', $var_color);
    imagestring($im, $font, $col2, 110, $mysql_version, $data_color);

    // Support librairie GD
    imagestring($im, $font, 10, 140, _XI_PHP_GD_LIB, $var_color);
    imagestring($im, $font, $col1, 140, ' : ', $var_color);
    if (function_exists('gd_info')) {
        imagestring($im, $font, $col2, 140, _XI_PHP_GD_LIB_ON, $color_on);
        imagestring($im, $font, $col3, 140, _XI_PHP_GD_LIB_GDON, $data_color);
    } else {
        imagestring($im, $font, $col2, 140, _XI_PHP_GD_LIB_OFF, $color_off);
        imagestring($im, $font, $col3, 140, _XI_PHP_GD_LIB_GDOFF, $data_color);
    }

    imagestring($im, $font, 10, 155, _XI_PHP_GD_VERSION, $var_color);
    imagestring($im, $font, $col1, 155, ' : ', $var_color);
    if (function_exists('gd_info')) {
        if (true == $gdlib = gd_info()) {
            imagestring($im, $font, $col2, 155, $gdlib['GD Version'], $data_color);
        }
    }

    // downloads status
    imagestring($im, $font, 10, 185, _XI_PHP_UPLOAD_STATUS, $var_color);
    imagestring($im, $font, $col1, 185, ' : ', $var_color);
    if (ini_get('file_uploads')) {
        imagestring($im, $font, $col2, 185, _XI_PHP_GD_LIB_ON, $color_on);
    } else {
        imagestring($im, $font, $col2, 185, _XI_PHP_GD_LIB_OFF, $color_off);
    }

    // downloads status
    imagestring($im, $font, 10, 200, _XI_PHP_UPLOAD_MAXSIZE, $var_color);
    imagestring($im, $font, $col1, 200, ' : ', $var_color);
    imagestring($im, $font, $col2, 200, ini_get('upload_max_filesize'), $data_color);

    imagepng($im);
    imagedestroy($im);
}
