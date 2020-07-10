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

// ONLY For Xoops < 2.0.16 and Xoops > 2.2
//install
$modversion['onInstall'] = 'include/sample_onInstall.php';

//update
$modversion['onUpdate'] = 'include/sample_onInstall.php';

//uninstall
$modversion['onUninstall'] = 'include/sample_unInstall.php';

// MimeTypes
$modversion['mimetypes'][1]['mime_ext']        = 'gif';
$modversion['mimetypes'][1]['mime_types']      = 'image/gif';
$modversion['mimetypes'][1]['mime_name']       = 'Graphic Interchange Format';
$modversion['mimetypes'][1]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][1]['mperm_maxwidth']  = 240;
$modversion['mimetypes'][1]['mperm_maxheight'] = 240;
$modversion['mimetypes'][1]['mperm_maxsize']   = 100000;

$modversion['mimetypes'][2]['mime_ext']        = 'jpg';
$modversion['mimetypes'][2]['mime_types']      = 'image/jpeg';
$modversion['mimetypes'][2]['mime_name']       = 'JPEG/JIFF Image';
$modversion['mimetypes'][2]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][2]['mperm_maxwidth']  = 240;
$modversion['mimetypes'][2]['mperm_maxheight'] = 240;
$modversion['mimetypes'][2]['mperm_maxsize']   = 100000;

$modversion['mimetypes'][3]['mime_ext']        = 'png';
$modversion['mimetypes'][3]['mime_types']      = 'image/png';
$modversion['mimetypes'][3]['mime_name']       = 'Portable (Public) Network Graphic';
$modversion['mimetypes'][3]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][3]['mperm_maxwidth']  = 240;
$modversion['mimetypes'][3]['mperm_maxheight'] = 240;
$modversion['mimetypes'][3]['mperm_maxsize']   = 100000;

$modversion['mimetypes'][4]['mime_ext']        = 'aiff';
$modversion['mimetypes'][4]['mime_types']      = 'audio/aiff';
$modversion['mimetypes'][4]['mime_name']       = 'Audio Interchange File';
$modversion['mimetypes'][4]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][4]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][4]['mperm_maxheight'] = 240;
$modversion['mimetypes'][4]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][5]['mime_ext']        = 'mid';
$modversion['mimetypes'][5]['mime_types']      = 'audio/mid';
$modversion['mimetypes'][5]['mime_name']       = 'Musical Instrument Digital Interface MIDI-sequention Sound';
$modversion['mimetypes'][5]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][5]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][5]['mperm_maxheight'] = 240;
$modversion['mimetypes'][5]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][6]['mime_ext']        = 'mpg';
$modversion['mimetypes'][6]['mime_types']      = 'audio/mpeg|video/mpeg';
$modversion['mimetypes'][6]['mime_name']       = 'MPEG 1 System Stream';
$modversion['mimetypes'][6]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][6]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][6]['mperm_maxheight'] = 240;
$modversion['mimetypes'][6]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][6]['mime_ext']        = 'wav';
$modversion['mimetypes'][6]['mime_types']      = 'audio/wav';
$modversion['mimetypes'][6]['mime_name']       = 'Waveform Audio';
$modversion['mimetypes'][6]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][6]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][6]['mperm_maxheight'] = 240;
$modversion['mimetypes'][6]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][7]['mime_ext']        = 'vma';
$modversion['mimetypes'][7]['mime_types']      = 'audio/x-ms-wma';
$modversion['mimetypes'][7]['mime_name']       = 'Windows Media Audio File';
$modversion['mimetypes'][7]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][7]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][7]['mperm_maxheight'] = 240;
$modversion['mimetypes'][7]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][8]['mime_ext']        = 'asf';
$modversion['mimetypes'][8]['mime_types']      = 'video/x-ms-asf';
$modversion['mimetypes'][8]['mime_name']       = 'Advanced Streaming Format';
$modversion['mimetypes'][8]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][8]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][8]['mperm_maxheight'] = 240;
$modversion['mimetypes'][8]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][9]['mime_ext']        = 'avi';
$modversion['mimetypes'][9]['mime_types']      = 'video/avi';
$modversion['mimetypes'][9]['mime_name']       = 'Audio Video Interleave File';
$modversion['mimetypes'][9]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][9]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][9]['mperm_maxheight'] = 240;
$modversion['mimetypes'][9]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][10]['mime_ext']        = 'wmv';
$modversion['mimetypes'][10]['mime_types']      = 'video/x-ms-wmv';
$modversion['mimetypes'][10]['mime_name']       = 'Windows Media File';
$modversion['mimetypes'][10]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][10]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][10]['mperm_maxheight'] = 240;
$modversion['mimetypes'][10]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][11]['mime_ext']        = 'vmx';
$modversion['mimetypes'][11]['mime_types']      = 'video/x-ms-wmx';
$modversion['mimetypes'][11]['mime_name']       = 'Windows Media Redirector';
$modversion['mimetypes'][11]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][11]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][11]['mperm_maxheight'] = 240;
$modversion['mimetypes'][11]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][12]['mime_ext']        = 'qt';
$modversion['mimetypes'][12]['mime_types']      = 'video/quicktime';
$modversion['mimetypes'][12]['mime_name']       = 'QuickTime Movie';
$modversion['mimetypes'][12]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][12]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][12]['mperm_maxheight'] = 240;
$modversion['mimetypes'][12]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][13]['mime_ext']        = 'swf';
$modversion['mimetypes'][13]['mime_types']      = 'application/x-shockwave-flash';
$modversion['mimetypes'][13]['mime_name']       = 'Macromedia Flash Format File';
$modversion['mimetypes'][13]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][13]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][13]['mperm_maxheight'] = 240;
$modversion['mimetypes'][13]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][14]['mime_ext']        = 'ra';
$modversion['mimetypes'][14]['mime_types']      = 'audio/vnd.rn-realaudio';
$modversion['mimetypes'][14]['mime_name']       = 'RealMedia Streaming Media';
$modversion['mimetypes'][14]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][14]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][14]['mperm_maxheight'] = 240;
$modversion['mimetypes'][14]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][15]['mime_ext']        = 'ram';
$modversion['mimetypes'][15]['mime_types']      = 'audio/x-pn-realaudio';
$modversion['mimetypes'][15]['mime_name']       = 'RealMedia Metafile';
$modversion['mimetypes'][15]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][15]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][15]['mperm_maxheight'] = 240;
$modversion['mimetypes'][15]['mperm_maxsize']   = 500000;

$modversion['mimetypes'][15]['mime_ext']        = 'rm';
$modversion['mimetypes'][15]['mime_types']      = 'application/vnd.rn-realmedia';
$modversion['mimetypes'][15]['mime_name']       = 'RealMedia Streaming Media';
$modversion['mimetypes'][15]['mime_status']     = 1; // 1 = visible - 0 = hidden
$modversion['mimetypes'][15]['mperm_maxwidth']  = 320;
$modversion['mimetypes'][15]['mperm_maxheight'] = 240;
$modversion['mimetypes'][15]['mperm_maxsize']   = 500000;
