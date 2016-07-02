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

$modversion['developer_website_url']= "http://dev.xoops.org/";
$modversion['developer_website_name']  = "Official XOOPS Development Site - Developing the future...";

$modversion['status_fileinfo'] = "";
$modversion['status_version'] = "";
$modversion['status']  = "";
$modversion['date']  = "";

$modversion['submit_bug']  = "http://sourceforge.net/tracker/?group_id=41586&atid=430840";
$modversion['submit_feature'] = "http://sourceforge.net/tracker/?group_id=41586&atid=430843";

switch ( $xoopsConfig['language'] ) {
	case 'english':
	default :
	$modversion['download_website'] = "http://www.xoops.org/modules/core/";

	$modversion['demo_site_url'] = "http://www.xoops.org";
	$modversion['demo_site_name'] = "Official XOOPS Website - Powered by You!";

	$modversion['support_site_url']= "http://www.xoops.org/modules/newbb/";
	$modversion['support_site_name']= "Official XOOPS Website - Support Forums";
	break;

	case 'french':
	$modversion['download_website'] = "http://www.frxoops.org/modules/noyau/";

	$modversion['demo_site_url'] = "http://www.frxoops.org";
	$modversion['demo_site_name'] = "XOOPS France (Communauté francophone)";

	$modversion['support_site_url']= "http://www.frxoops.org/modules/newbb/";
	$modversion['support_site_name']= "XOOPS France (Communauté francophone) - Forums";
	break;
}
?>