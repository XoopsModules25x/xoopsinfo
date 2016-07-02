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

// The name of this module
define('_MI_XI_NAME', 'XOOPS Info');

// A brief description of this module
define('_MI_XI_DESC', "Module basique permettant d'afficher les informations sur les versions XOOPS, Apache, MySQL, et PHP.");

// Credit where credit is due
define('_MI_XI_AUTHOR', 'XOOPS Support Team - DuGris (XOOPS France)');
define('_MI_XI_CREDITS', 'XOOPS Core Team (http://www.xoops.org/) - DuGris (http://www.dugris.info/');

// Support
define('_MI_XI_SUPPORT', 'Poster vos demandes de support sur http://frxoops.org/');

// Names of admin menu items
define('_MI_XI_ADMENU1', 'Env Xoops');
define('_MI_XI_ADMENU2', 'Env Serveur');
define('_MI_XI_ADMENU3', 'Env MySql');
define('_MI_XI_ADMENU4', 'Information Modules');
define('_MI_XI_ADMENU5', 'Information Editeurs');
define('_MI_XI_ADMENU6', 'Information Surcharge');
define('_MI_XI_ADMENU7', 'Types mime');

define('_MI_XI_XOOPS_DEBUG', 'Mode de mise au point (Debug)');
define('_MI_XI_XOOPS_THEME', 'Activer le th�me par default');
define('_MI_XI_XOOPS_CACHE', 'Supprimer les fichiers du dossier cache');
define('_MI_XI_XOOPS_TEMPLATE', 'Supprimer les fichiers du dossier template_c');
define('_MI_XI_XOOPS_PROTECTOR', "<font color='#CC0000'>Protector : </font>D�sactivation Temporaire");
define('_MI_XI_XOOPS_PROTECTOR_IP', "<font color='#CC0000'>Protector : </font>Supprimer les IP bannies");

define('_MI_XI_XOOPS_PASSWORD', 'Mot de passe');
define('_MI_XI_PASSWORD_ERROR', 'Mot de passe erron� !!!');
define('_MI_XI_XOOPS_SUBMIT', 'Envoyer');
define('_MI_XI_YES', 'Oui');
define('_MI_XI_NO', 'Non');

define('_MI_XI_UPDATE_MODULE', "<font color='#CC0000'>Mise � jour du module</font>");
define('_MI_XI_NEWVERSION', "<font color='#000099'>Nouvelle version</font>");
define('_MI_XI_HELP', 'Aide');

define('_AM_XI_MODULE_LEGEND_UPDATE', "La mise � jour du module n'a pas �t� effectu�e !!!");
define('_AM_XI_MODULE_LEGEND_DOWNLOAD', 'Une nouvelle version du module est disponible en t�l�chargement');

// Options
define('_MI_XI_CHECK_TABLE', 'Tables � controler');
define('_MI_XI_CHECK_TABLE_DSC', "S�parer le nom des tables par <font color='#CC0000'><b>|</b></font>");

define('_MI_XI_IMG_FONT', 'Taille des caract�res');
define('_MI_XI_IMG_BACKGROUND', 'Couleur de fond');
define('_MI_XI_IMG_BORDER', 'Couleur du contour');
define('_MI_XI_IMG_CONSTANT', 'Couleur du texte');
define('_MI_XI_IMG_DATA', 'Couleur des informations');

define('_MI_XI_PASSWORD', 'Mot de passe');
define('_MI_XI_PASSWORD_DSC', "Si pour une raison ou une autre vous n'avez plus acces � votre site.<br>
 Acc�der au sript :
 <a href='" . XOOPS_URL . "/modules/xoopsinfo/admin/rescue.php'><font color='#CC0000'><b>XOOPS_URL/modules/xoopsinfo/admin/rescue.php</b></font></a><br>
 <li>Choisir le mode debug</li>
 <li>Activer le th�me par d�faut</li><br>
 <li>Entrez le mot de passe d�fini ici.</li><br>
 N'oubliez pas de d�finir un mot de passe<br>
 Si cette option n'est pas renseign�e, le script ne fonctionnera jamais !!!
 ");

// Version 2.12
define('_MI_XI_REFERER', "Referers autoris�s pour <font color='#CC0000'>xoopsinfo.php</font>");
define('_MI_XI_REFERER_DSC', "s�par� par <font color='#CC0000'><b>|</b></font>");

define('_MI_XI_ADMENU8', 'Information syst�me');

define('_MI_PHPSYSINFO_FOLDER', "[PHPSYSINFO] Dossier contenant <font color='#CC0000'>PHPSYSINFO</font>");
define('_MI_PHPSYSINFO_FOLDER_DSC', "par exemple <font color='#CC0000'><b>/phpsysinfo</b></font>, sans le <font color='#CC0000'><b>/</font></b> final<br>Plus d'informations sur <a target='_blank' href='http://phpsysinfo.sourceforge.net/'>phpsysinfo</a>");

define('_MI_PHPSYSINFO_LANG', '[PHPSYSINFO] Langue par d�faut');
define('_MI_PHPSYSINFO_LANG_DSC', 'La liste des langues est disponibles dans le dossier includes/lang/ de phpsysinfo');
define('_MI_PHPSYSINFO_LANG_DEF', 'fr');

define('_MI_PHPSYSINFO_THEME', '[PHPSYSINFO] Th�me par d�faut');
define('_MI_PHPSYSINFO_THEME_DSC', 'La listes des th�mes est disponible dans le dossier templates de phpsysinfo');

define('_MI_XI_XOOPS_SESSION_TABLE', 'Optimiser la table session');

// Version 2.13
define('_MI_XI_ADMENU9', 'PHP Information de s�curit�');

define('_MI_PHPSECINFO_FOLDER', "[PHPSECINFO] Dossier contenant <font color='#CC0000'>PHPSECINFO</font>");
define('_MI_PHPSECINFO_FOLDER_DSC', "par exemple <font color='#CC0000'><b>/phpsecinfo</b></font>, sans le <font color='#CC0000'><b>/</font></b> final<br>Plus d'informations sur <a target='_blank' href='http://phpsec.org/projects/phpsecinfo/index.html'>PHP Security Consortium: PHPSecInfo</a>");
