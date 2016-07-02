<?php
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2001 - 2006 <http://www.xoops.org/>
*
* Module: xoopsinfo 2.13
* Licence : GPL
* Authors :
*              - Jmorris
*              - Marco
*              - Christian
*              - DuGris (http://www.dugris.info)
*/

$xoopsOption['nocommon'] = true ;
require_once( '../../../mainfile.php' ) ;

// Xoops Include, require, ...
require_once( XOOPS_ROOT_PATH . '/class/xoopssecurity.php' );
$xoopsSecurity = new XoopsSecurity();
global $xoopsSecurity;
//Check super globals
$xoopsSecurity->checkSuperglobals();

include_once XOOPS_ROOT_PATH.'/include/functions.php';

include_once XOOPS_ROOT_PATH . '/class/logger.php';
//$xoopsLogger =& XoopsLogger::instance();
//$xoopsErrorHandler =& $xoopsLogger;
//$xoopsLogger->startTime();
//$xoopsLogger->startTime( 'XOOPS Boot' );

if (!defined('XOOPS_XMLRPC')) {
	define('XOOPS_DB_CHKREF', 1);
} else {
	define('XOOPS_DB_CHKREF', 0);
}
require_once XOOPS_ROOT_PATH.'/class/database/databasefactory.php';
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !$xoopsSecurity->checkReferer(XOOPS_DB_CHKREF)) {
	define('XOOPS_DB_PROXY', 1);
}
$xoopsDB =& XoopsDatabaseFactory::getDatabaseConnection();

require_once XOOPS_ROOT_PATH.'/kernel/object.php';
require_once XOOPS_ROOT_PATH.'/class/criteria.php';

$config_handler =& xoops_gethandler('config');
$xoopsConfig =& $config_handler->getConfigsByCat(XOOPS_CONF);
// Xoops Include, require, ...

include('admin_header.php');

// Old debug mode
$isSystem = XoopsInfo_getModuleInfo( 'system' );
$config_handler =& xoops_gethandler('config');
$xoopsConfig =& $config_handler->getConfigsByCat(XOOPS_CONF);
$old_debug_mode = $xoopsConfig['debug_mode'];
$theme_set = $xoopsConfig['theme_set'];

// Protector
$isProtector = XoopsInfo_getModuleInfo( 'protector' );
if ($isProtector) {
	$old_protector = XoopsInfo_moduleoption( 'global_disabled', 'protector');
}


// UPDATE STAGE
if ( $_SERVER['REQUEST_METHOD'] == 'POST') {
	$passwd= isset($_REQUEST['passwd']) ? trim($_REQUEST['passwd']) : '';
	$debug_mode = isset($_REQUEST['debug_mode']) ? trim($_REQUEST['debug_mode']) : 0;
	$theme= isset($_REQUEST['theme']) ? trim($_REQUEST['theme']) : 0;
	$protector = isset($_REQUEST['protector']) ? trim($_REQUEST['protector']) : 0;
	$protector_ip= isset($_REQUEST['protector_ip']) ? trim($_REQUEST['protector_ip']) : 0;
	$template_c = isset($_REQUEST['template_c']) ? trim($_REQUEST['template_c']) : 0;
	$cache = isset($_REQUEST['cache']) ? trim($_REQUEST['cache']) : 0;
	$session = isset($_REQUEST['session']) ? trim($_REQUEST['session']) : 0;
	if( ! empty( $passwd ) && trim( $passwd ) != '' ) {
		// Checking Referer deeply against CSRF
		if( strpos( $_SERVER['HTTP_REFERER'] , XOOPS_URL.'/modules/xoopsinfo/admin/' ) !== 0 ) {
			die( 'Turn REFERER on (or disable Personal Firewalls like Norton' ) ;
		}

		// Authentication
		$sql = 'SELECT count(*) FROM ' . $xoopsDB->prefix('config') . ' WHERE conf_title="_MI_XI_PASSWORD" AND conf_value="' . $passwd . '"';
		$result = $xoopsDB->query( $sql) ;
		list($count) = $xoopsDB->fetchRow($result);

		// Result
		if( $xoopsDB->getRowsNum( $result ) == 1 && $count) {
			//   Debug Mode
			if ( $old_debug_mode != $debug_mode) {
				$sql ='UPDATE ' . $xoopsDB->prefix('config') . ' SET conf_value="' . $debug_mode . '" WHERE conf_name="debug_mode" and conf_modid=0';
				$result = $xoopsDB->queryF($sql);
				$old_debug_mode = $debug_mode;
			}

			// Theme
			if ( $theme == 1) {
				$sql ='UPDATE ' . $xoopsDB->prefix('config') . ' SET conf_value="default" WHERE conf_name="theme_set" and conf_modid=0';
				$result = $xoopsDB->queryF($sql);

				$member_handler =& xoops_gethandler('member');
				$member_handler->updateUsersByField('theme', 'default' );
				$_SESSION['xoopsUserTheme'] = 'default';
			}

			if ( $cache ) {
				$dir = XOOPS_ROOT_PATH . "/cache";
				if (is_dir($dir)) {
					if ($dh = opendir($dir)) {
						while (($file = readdir($dh)) !== false) {
							if ( filetype($dir . '/' . $file) != 'dir' && $file != 'index.html' && $file != 'adminmenu.php' ) {
								@unlink( $dir . '/' . $file );
							}
						}
						closedir($dh);
					}
				}
			}

			if ( $template_c ) {
				$dir = XOOPS_ROOT_PATH . "/templates_c";
				if (is_dir($dir)) {
					if ($dh = opendir($dir)) {
						while (($file = readdir($dh)) !== false) {
							if ( filetype($dir . '/' . $file) != 'dir' && $file != 'index.html' ) {
								@unlink( $dir . '/' . $file );
							}
						}
						closedir($dh);
					}
				}
			}

			// Session
			if ( $session ) {
            $sql = "TRUNCATE TABLE " . $xoopsDB->prefix('online');
				$result = $xoopsDB->query( $sql );
				$sql = "TRUNCATE TABLE " . $xoopsDB->prefix('session');
				$result = $xoopsDB->query( $sql );

			}

			// Protector
			if ( $old_protector != $protector && $isProtector) {
				$sql ='UPDATE ' . $xoopsDB->prefix('config') . ' SET conf_value="' . $protector . '" WHERE conf_name="global_disabled" AND conf_modid=' . $isProtector->getVar('mid');
				$result = $xoopsDB->queryF($sql);
			}

			if ( $protector_ip && $isProtector) {
				$sql = 'TRUNCATE TABLE ' . $xoopsDB->prefix('protector_access');
				$result = $xoopsDB->queryF($sql);
			}


			define( 'SMARTY_DIR', XOOPS_ROOT_PATH . '/class/smarty/');
			define( 'XOOPS_COMPILE_PATH', XOOPS_ROOT_PATH . '/templates_c');
			redirect_header( XOOPS_URL . '/modules/xoopsinfo/admin/rescue.php', 3, _MD_AM_DBUPDATED);
		}
		define( 'SMARTY_DIR', XOOPS_ROOT_PATH . '/class/smarty/');
		define( 'XOOPS_COMPILE_PATH', XOOPS_ROOT_PATH . '/templates_c');
		redirect_header( XOOPS_URL . '/modules/xoopsinfo/admin/rescue.php', 3, _MI_XI_PASSWORD_ERROR);
	}
}

if (!headers_sent()) {
header('Content-Type:text/html; charset='._CHARSET);
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
//header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
header('Cache-Control: private, no-cache');
header('Pragma: no-cache');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo XOOPS_URL . '/xoops.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo XOOPS_URL . '/themes/' . $theme_set . '/style.css'; ?>" />
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo XOOPS_URL . '/modules/xoopsinfo/module.css'; ?>" />
<title><?php echo _MI_XI_NAME; ?> Rescue</title>
</head>
<body>
<form action='' method='POST'>
	<div align="center">
		<div class="item" align="center">
			<div class="itemHead"><h3>
			<?php echo _MI_XI_NAME; ?> Rescue
			</h3></div>

			<table width="100%">
			<tr>
				<td class="even" align="left"><b>
				<?php echo _MI_XI_XOOPS_DEBUG; ?>
				</b></td>

				<td class="odd" align="left">
				<select size='1' name='debug_mode' id='debug_mode'>
				<option value='0' <?php if ($old_debug_mode == 0) {echo "selected=selected";}?>><?php echo _MD_AM_DEBUGMODE0; ?></option>
				<option value='1' <?php if ($old_debug_mode == 1) {echo "selected=selected";}?>><?php echo _MD_AM_DEBUGMODE1; ?></option>
				<option value='2' <?php if ($old_debug_mode == 2) {echo "selected=selected";}?>><?php echo _MD_AM_DEBUGMODE2; ?></option>
				<option value='3' <?php if ($old_debug_mode == 3) {echo "selected=selected";}?>><?php echo _MD_AM_DEBUGMODE3; ?></option>
				</select>
				</td>
			</tr>

			<tr>
				<td class="even" align="left"><b>
				<?php echo _MI_XI_XOOPS_THEME; ?>
				</b></td>

				<td class="odd" align="left">
				<input type='radio' name='theme' value='0' checked='checked'/><?php echo _MI_XI_NO; ?>
				<input type='radio' name='theme' value='1' /><?php echo _MI_XI_YES; ?>
				</td>
			</tr>

			<tr>
				<td class="even" align="left"><b>
				<?php echo _MI_XI_XOOPS_CACHE; ?>
				</b></td>

				<td class="odd" align="left">
				<input type='radio' name='cache' value='0' checked /><?php echo _MI_XI_NO; ?>
				<input type='radio' name='cache' value='1' /><?php echo _MI_XI_YES; ?>
				</td>
			</tr>

			<tr>
				<td class="even" align="left"><b>
				<?php echo _MI_XI_XOOPS_TEMPLATE; ?>
				</b></td>

				<td class="odd" align="left">
				<input type='radio' name='template_c' value='0' checked /><?php echo _MI_XI_NO; ?>
				<input type='radio' name='template_c' value='1' /><?php echo _MI_XI_YES; ?>
				</td>
			</tr>

			<tr>
				<td class="even" align="left"><b>
				<?php echo _MI_XI_XOOPS_SESSION_TABLE; ?>
				</b></td>

				<td class="odd" align="left">
				<input type='radio' name='session' value='0' checked /><?php echo _MI_XI_NO; ?>
				<input type='radio' name='session' value='1' /><?php echo _MI_XI_YES; ?>
				</td>
			</tr>

			<?php if ($isProtector) : ?>
			<tr>
				<td class="even" align="left"><b>
				<?php echo _MI_XI_XOOPS_PROTECTOR; ?>
				</b></td>

				<td class="odd" align="left">
				<input type='radio' name='protector' value='0' <?php if (!$old_protector) { echo "checked='checked'"; } ?> /><?php echo _MI_XI_NO; ?>
				<input type='radio' name='protector' value='1' <?php if ($old_protector){ echo "checked='checked'"; } ?> /><?php echo _MI_XI_YES; ?>
				</td>
			</tr>

			<tr>
				<td class="even" align="left"><b>
				<?php echo _MI_XI_XOOPS_PROTECTOR_IP; ?>
				</b></td>

				<td class="odd" align="left">
				<input type='radio' name='protector_ip' value='0' checked='checked' /><?php echo _MI_XI_NO; ?>
				<input type='radio' name='protector_ip' value='1'/><?php echo _MI_XI_YES; ?>
				</td>
			</tr>
			<?php endif; ?>

			<tr>
				<td class="even" align="left"><b>
				<?php echo _MI_XI_XOOPS_PASSWORD; ?>
				</b></td>

				<td class="odd" align="left">
				<input type='password' name='passwd' size='15' />
				</td>
			</tr>

			<tr>
				<td colspan="2" align="center">
				<input type='submit' name='submit' value='<?php echo _MI_XI_XOOPS_SUBMIT; ?>' />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="center">
				<br />
				</td>
			</tr>
			<tr>
				<td colspan="2" align="right">
				<a href="<?php echo XOOPS_URL;?>"><?php echo _YOURHOME;?></a>
				</td>
			</tr>
			</table>
		</div>
	</div>
</form>
<br />
</body>
</html>
<?php
//echo $xoopsLogger->dump();
?>