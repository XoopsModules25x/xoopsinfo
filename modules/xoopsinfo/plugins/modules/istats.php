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

switch ( $xoopsConfig['language'] ) {
	case 'english':
	default :
	$modversion['developer_website_url']= "";
	$modversion['developer_website_name']  = "";

	$modversion['status_fileinfo'] = "";
	$modversion['status_version'] = "";
	$modversion['status']  = "";
	$modversion['date']  = "";

	$modversion['download_website'] = "http://www.xoops.org/modules/repository/singlefile.php?cid=78&lid=1337";

	$modversion['demo_site_url'] = "";
	$modversion['demo_site_name'] = "";

	$modversion['support_site_url']= "";
	$modversion['support_site_name']= "";
	break;

	case 'french':
	$modversion['developer_website_url']= "";
	$modversion['developer_website_name']  = "";

	$modversion['status_fileinfo'] = "";
	$modversion['status_version'] = "";
	$modversion['status']  = "";
	$modversion['date']  = "";

	$modversion['download_website'] = "http://www.frxoops.org/modules/referentiel/singlefile.php?cid=6&lid=203";

	$modversion['demo_site_url'] = "";
	$modversion['demo_site_name'] = "";

	$modversion['support_site_url']= "";
	$modversion['support_site_name']= "";
	break;
}
?>