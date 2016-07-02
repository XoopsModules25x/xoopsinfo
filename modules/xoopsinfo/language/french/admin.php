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

// Names of admin menu items

define('_AM_XI_ADMENU1', 'Environnement Xoops');
define('_AM_XI_ADMENU2', 'Environnement Serveur');
define('_AM_XI_ADMENU3', 'Environnement MySql');
define('_AM_XI_ADMENU4', 'Informations Modules');
define('_AM_XI_ADMENU5', 'Informations Editeurs');
define('_AM_XI_ADMENU6', 'Informations Surcharge');
define('_AM_XI_ADMENU7', 'Gestion des types MIME');

define('_AM_XI_GOTOHOMEPAGE', 'Retour site');
define('_AM_XI_MODULEADMIN', '- Informations sur votre environnement Xoops');

define('_AM_XI_DOWN_SAFEMODESTATUS', 'Statut safe mode');
define('_AM_XI_DOWN_REGISTERGLOBALS', 'Register Globals');
define('_AM_XI_DOWN_ALLOW_URL_FOPEN', 'allow_url_fopen');
define('_AM_XI_DOWN_USE_TRANS_SID', 'session.use_trans_sid');
define('_AM_XI_DOWN_SERVERUPLOADSTATUS', "Statut d'upload du serveur");
define('_AM_XI_DOWN_MAXUPLOADSIZE', "Taille d'upload autoris�e");
define('_AM_XI_DOWN_SAFEMODEPROBLEMS', ' Ceci peut poser des probl�mes');
define('_AM_XI_DOWN_GDLIBSTATUS', 'Support librairie GD');
define('_AM_XI_DOWN_GDLIBVERSION', 'Version libraire GD');
define('_AM_XI_DOWN_GDON', ' vignettes disponibles');
define('_AM_XI_DOWN_GDOFF', ' vignettes non disponibles');
define('_AM_XI_DOWN_OFF', 'OFF');
define('_AM_XI_DOWN_ON', 'ON');

define('_AM_XI_EDITOR_CHECK', 'Status');
define('_AM_XI_EDITOR_NAME', "Nom de l'�diteur");

define('_AM_XI_EDITOR_NONE', '');
define('_AM_XI_EDITOR_INSTALL_OK', 'Module install�');
define('_AM_XI_EDITOR_NO_INSTALL', 'Module non install�');

define('_AM_XI_EDITOR_OK', "L'�diteur fonctionne");
define('_AM_XI_EDITOR_ERROR', 'Fichier class/... non trouv�');
define('_AM_XI_EDITOR_MODULE', 'Module non install� - Fichier class/... trouv�');
define('_AM_XI_EDITOR_CLASS', 'Module install� - Fichier class/... non trouv�');

define('_AM_XI_MODULE_NAME', 'Modules');
define('_AM_XI_MODULE_STATUS', 'Status');
define('_AM_XI_MODULE_ACTION', 'Actions');
define('_AM_XI_MODULE_VERSION', 'Versions');
define('_AM_XI_MODULE_XOOPS', 'xoops_version');
define('_AM_XI_MODULE_TABLE', 'Table module');
define('_AM_XI_MODULE_NEW', 'Derni�re');
define('_AM_XI_MODULE_UPDATE', 'MAJ module');
define('_AM_XI_MODULE_DOWNLOAD', 'T�l�charger la derni�re version');
define('_AM_XI_MODULE_SUPPORT', 'Support');
define('_AM_XI_MODULE_FORUM', 'Forum');
define('_AM_XI_MODULE_BUG', 'Rapport de bug');
define('_AM_XI_MODULE_FEATURE', 'Feature');

define('_AM_XI_XOOPS_VERSION', 'Version de Xoops');
define('_AM_XI_XOOPS_URL', 'Url du site');
define('_AM_XI_XOOPS_ROOT_PATH', 'Chemin physique de Xoops');
define('_AM_XI_XOOPS_THEME', 'Th�me Xoops');
define('_AM_XI_XOOPS_TEMPLATE', 'Jeu de template');
define('_AM_XI_XOOPS_DEBUG', 'Mode de mise au point (Debug)');
define('_AM_XI_XOOPS_STARTPAGE', "Module pour votre page d'accueil");
define('_AM_XI_XOOPS_THEME_FROMFILE', 'Actualiser les templates pour voir les modifications ?');

define('_AM_XI_PROTECTOR_MODULE', 'Module protector');
define('_AM_XI_PROTECTOR_MODULE_NOT', 'Non install�');
define('_AM_XI_PROTECTOR_MODULE_OK', 'Install�');
define('_AM_XI_PROTECTOR_PRECHECK', 'Pr� contr�le ');
define('_AM_XI_PROTECTOR_CHECK_ERR', " Vous devez �diter le fichier mainfile.php comme indiqu� dans le fichier <a target='_blank' href='" . XOOPS_URL . "/modules/protector/docs/README'>README</a>");
define('_AM_XI_PROTECTOR_PRECHECK_MSG', 'missing precheck');
define('_AM_XI_PROTECTOR_POSTCHECK', 'Post contr�le');
define('_AM_XI_PROTECTOR_POSTCHECK_MSG', 'missing postcheck');
define('_AM_XI_PROTECTOR', "<font color='#CC0000'>Protector : </font>D�sactivation Temporaire");

define('_AM_XI_SERVER_SOFTWARE', 'Logiciel serveur');
define('_AM_XI_SERVER_PHP', 'Version PHP');
define('_AM_XI_SERVER_MYSQL', 'Version MySql');

define('_AM_XI_BROWSER', 'Navigateur');

define('_AM_XI_SAVE', 'Enregistrer');

define('_AM_XI_MYSQL_ID', 'Id');
define('_AM_XI_MYSQL_DB', 'Base de donn�e');
define('_AM_XI_MYSQL_INFO', 'Information');
define('_AM_XI_MYSQL_TIME', 'Dur�e');
define('_AM_XI_MYSQL_STATUS', 'Status');
define('_AM_XI_MYSQL_DB_LENGTH', 'Taille de la base de donn�es');
define('_AM_XI_MYSQL_OCTETS', 'Octets');
define('_AM_XI_MYSQL_KOCTETS', 'Ko');

global $xoopsModule;
define('_AM_XI_MAKE_UPDATE', "La mise � jour du module n'a pas �t� effectu�e : ");
define('_AM_XI_MAKE_UPGRADE', "Une nouvelle version de <font color='#CC0000'>" . $xoopsModule->name() . '</font> est disponible<br>en t�l�chargement � cette adresse :');
define('_AM_XI_NO_UPGRADE', 'Vous avez la derni�re version !!!');

define('_AM_XI_MIME_ID', 'Id');
define('_AM_XI_MIME_EXT', 'Extension');
define('_AM_XI_MIME_TYPES', 'Types Mime');
define('_AM_XI_MIME_NAME', "Type d'application");
define('_AM_XI_MIME_TYPE', "Mimetypes<br><br><span style='font-weight: normal;'>Entrer les mimetype associ� avec cette extension de fichier.<br>Tous les mimetype doivent entre s�par�s par un <font color='#CC0000'><b>|</b></font>.</span>");
define('_AM_XI_MIME_GROUPS', 'Groupes');
define('_AM_XI_MIME_MODULES', 'Module : ');
define('_AM_XI_MIME_MTYPE', 'Type : ');
define('_AM_XI_MIME_STATUS', 'Affich�');
define('_AM_XI_MIME_WIDTH', 'Largeur maximum du fichier');
define('_AM_XI_MIME_HEIGHT', 'Hauteur maximum du fichier');
define('_AM_XI_MIME_SIZE', 'Taille maximum du fichier');
define('_AM_XI_MIME_ACTION', 'Action');
define('_AM_XI_MIME_DISPLAY', 'Affich� : ');
define('_AM_XI_MIME_ALL', 'Tous');
define('_AM_XI_MIME_VIEW', 'Affich�');
define('_AM_XI_MIME_HIDE', 'Cach�');
define('_AM_XI_MIME_EDIT', 'Modifier');
define('_AM_XI_MIME_DELE', 'Effacer');
define('_AM_XI_MIME_DELETETHIS', 'Effacer ce type mime');
define('_AM_XI_MIME_NONE', 'Aucun');

define('_AM_XI_MIME_NEW', 'Nouveau type mime');
define('_AM_XI_MIME_MODIFY', 'Modifier');
define('_AM_XI_MIME_CREATE', 'Cr�er');
define('_AM_XI_MIME_CANCEL', 'Annuler');
define('_AM_XI_MIME_SAVEALL', 'Enregistrer');

define('_AM_XI_MODULE_TEMPLATE', 'Templates');
define('_AM_XI_MODULE_TEMPLATE_BLOCK', 'Templates (blocks)');
define('_AM_XI_TPL_OVERRIDE_ON', 'Template surcharg�');
define('_AM_XI_TPL_OVERRIDE_OFF', 'Template non surcharg�');
define('_AM_XI_TPL_THEMES', 'Th�me : ');

// Version 2.12
define('_AM_XI_ADMENU8', 'Informations Syst�me');
define('_AM_XI_CONFIRM', 'Confirmer');

define('_AM_XI_MYSQL_ACTION', 'ACTION : ');
define('_AM_XI_MYSQL_OPTIMIZE', 'Optimiser les tables');
define('_AM_XI_MYSQL_REPAIR', 'R�parer les tables');
define('_AM_XI_MYSQL_CHECK', 'V�rifier les tables');
define('_AM_XI_MYSQL_ANALYZE', 'Analyser les tables');

define('_AM_XI_MYSQL_RETURN', 'Retourner � : ' . _AM_XI_ADMENU3);

define('_MI_XI_MYSQL_TABLE', 'Table');
define('_MI_XI_MYSQL_TABLE_TXT', ' Table(s)');
define('_MI_XI_MYSQL_TYPE', 'Type');
define('_MI_XI_MYSQL_COLLATION', 'Interclassement');
define('_MI_XI_MYSQL_RECORDS', 'Enregistrements');
define('_MI_XI_MYSQL_SIZE', 'Taille');
define('_MI_XI_MYSQL_OVERHEAD', 'Perte');
define('_MI_XI_MYSQL_SUM', 'Somme');

// Version 2.13
define('_AM_XI_ADMENU9', 'PHP Information de s�curit�');
