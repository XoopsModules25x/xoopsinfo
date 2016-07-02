<?php
// $Id: uploader.php 507 2006-05-26 23:39:35Z skalpa $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //
// Author: Kazumi Ono (AKA onokazu)                                          //
// URL: http://www.myweb.ne.jp/, http://www.xoops.org/, http://jp.xoops.org/ //
// Project: The XOOPS Project                                                //
// ------------------------------------------------------------------------- //
/**
 * Upload Media files
 *
 * Example of usage:
 * <code>
 * include_once 'uploader.php';
 * $allowed_mimetypes = array('image/gif', 'image/jpeg', 'image/pjpeg', 'image/x-png');
 * $maxfilesize = 50000;
 * $maxfilewidth = 120;
 * $maxfileheight = 120;
 * $uploader = new XoopsMediaUploader('/home/xoops/uploads', $allowed_mimetypes, $maxfilesize, $maxfilewidth, $maxfileheight);
 * if ($uploader->fetchMedia($_POST['uploade_file_name'])) {
 *   if (!$uploader->upload()) {
 *      echo $uploader->getErrors();
 *   } else {
 *      echo '<h4>File uploaded successfully!</h4>'
 *      echo 'Saved as: ' . $uploader->getSavedFileName() . '<br />';
 *      echo 'Full path: ' . $uploader->getSavedDestination();
 *   }
 * } else {
 *   echo $uploader->getErrors();
 * }
 * </code>
 *
 * @package        kernel
 * @subpackage    core
 *
 * @author        Kazumi Ono     <onokazu@xoops.org>
 * @copyright    (c) 2000-2003 The Xoops Project - www.xoops.org
*/

if ( file_exists(XOOPS_ROOT_PATH . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/uploader_error.php') ) {
	include_once XOOPS_ROOT_PATH . '/language/' . $GLOBALS['xoopsConfig']['language'] . '/uploader_error.php';
} else {
	include_once XOOPS_ROOT_PATH . '/language/english/uploader_error.php';
}

define('_XI_MIMETYPE', 1);
class XoopsMediaUploader {
	/**
	* Flag indicating if unrecognized mimetypes should be allowed (use with precaution ! may lead to security issues )
	**/
	var $allowUnknownTypes = false;

	var $mediaName;
	var $mediaType;
	var $mediaSize;
	var $mediaTmpName;
	var $mediaError;
	var $mediaRealType = '';

	var $uploadDir = '';

	var $allowedMimeTypes = array();

	var $maxFileSize = 0;
	var $maxWidth;
	var $maxHeight;

	var $targetFileName;

	var $prefix;

	var $errors = array();

	var $savedDestination;

	var $savedFileName;

	var $extensionToMime = array();
	var $checkImageType = true;

	var $extensionsToBeSanitized = array( 'php' , 'phtml' , 'phtm' , 'php3' , 'php4' , 'cgi' , 'pl' , 'asp', 'php5' );
	// extensions needed image check (anti-IE Content-Type XSS)
	var $imageExtensions = array( 1 => 'gif', 2 => 'jpg', 3 => 'png', 4 => 'swf', 5 => 'psd', 6 => 'bmp', 7 => 'tif', 8 => 'tif', 9 => 'jpc', 10 => 'jp2', 11 => 'jpx', 12 => 'jb2', 13 => 'swc', 14 => 'iff', 15 => 'wbmp', 16 => 'xbm' );

	/**
	* Constructor
	*
	* @param   string  $uploadDir
	* @param   array   $allowedMimeTypes
	* @param   int$maxFileSize
	* @param   int$maxWidth
	* @param   int$maxHeight
	* @param   int$cmodvalue
	**/
	function XoopsMediaUploader($uploadDir, $allowedMimeTypes, $maxFileSize=0, $maxWidth=null, $maxHeight=null) {
/*
		@$this->extensionToMime = include( XOOPS_ROOT_PATH . '/class/mimetypes.inc.php' );
		if ( !is_array( $this->extensionToMime ) ) {
			$this->extensionToMime = array();
			return false;
		}
		if (is_array($allowedMimeTypes)) {
			$this->allowedMimeTypes =& $allowedMimeTypes;
		}
		$this->uploadDir = $uploadDir;
		$this->maxFileSize = intval($maxFileSize);
		if(isset($maxWidth)) {
			$this->maxWidth = intval($maxWidth);
		}
		if(isset($maxHeight)) {
			$this->maxHeight = intval($maxHeight);
		}
*/
		if (is_array($allowedMimeTypes)) {
			$this->allowedMimeTypes =& $allowedMimeTypes;
		}

		$this->uploadDir = $uploadDir;
		$this->maxFileSize = intval($maxFileSize);
		$this->maxWidth = intval($maxWidth);
		$this->maxHeight = intval($maxHeight);
		$this->GetextensionToMime();
	}

	/**
	* Fetch the uploaded file
	*
	* @param   string  $media_name Name of the file field
	* @param   int$index Index of the file (if more than one uploaded under that name)
	* @return  bool
	**/
	function fetchMedia($media_name, $index = null) {
/*
		if ( empty( $this->extensionToMime ) ) {
*/
		if ( count( $this->extensionToMime ) == 0 ) {
			$this->setErrors( _ER_UP_MIMETYPELOAD );
		return false;
	}

	if (!isset($_FILES[$media_name])) {
		$this->setErrors( _ER_UP_FILENOTFOUND );
		return false;
	} elseif (is_array($_FILES[$media_name]['name']) && isset($index)) {
		$index = intval($index);
		$this->mediaName = (get_magic_quotes_gpc()) ? stripslashes($_FILES[$media_name]['name'][$index]) : $_FILES[$media_name]['name'][$index];
		$this->mediaType = $_FILES[$media_name]['type'][$index];
		$this->mediaSize = $_FILES[$media_name]['size'][$index];
		$this->mediaTmpName = $_FILES[$media_name]['tmp_name'][$index];
		$this->mediaError = !empty($_FILES[$media_name]['error'][$index]) ? $_FILES[$media_name]['error'][$index] : 0;
	} else {
		$media_name =& $_FILES[$media_name];
		$this->mediaName = (get_magic_quotes_gpc()) ? stripslashes($media_name['name']) : $media_name['name'];
		$this->mediaName = $media_name['name'];
		$this->mediaType = $media_name['type'];
		$this->mediaSize = $media_name['size'];
		$this->mediaTmpName = $media_name['tmp_name'];
		$this->mediaError = !empty($media_name['error']) ? $media_name['error'] : 0;
	}
/*
	if ( ($ext = strrpos( $this->mediaName, '.' )) !== false ) {
		$ext = strtolower(substr( $this->mediaName, $ext + 1 ));
		if ( isset( $this->extensionToMime[$ext] ) ) {
			$this->mediaRealType = $this->extensionToMime[$ext];
			//trigger_error( "XoopsMediaUploader: Set mediaRealType to {$this->mediaRealType} (file extension is $ext)", E_USER_NOTICE );
		}
	}
*/

	$this->mediaExt = strtolower(substr( $this->mediaName, strrpos( $this->mediaName, '.' ) + 1 ));
	if ( array_key_exists($this->mediaExt, $this->extensionToMime) ) {
		$this->maxFileSize = $this->extensionToMime[$this->mediaExt]['maxSize'];
		$this->maxWidth = $this->extensionToMime[$this->mediaExt]['maxWidth'];
		$this->maxHeight = $this->extensionToMime[$this->mediaExt]['maxHeight'];
	}

	$this->errors = array();
	if (intval($this->mediaSize) < 0) {
		$this->setErrors(  _ER_UP_INVALIDFILESIZE );
		return false;
	}

	if ($this->mediaName == '') {
		$this->setErrors( _ER_UP_FILENAMEEMPTY );
		return false;
	}

	if ($this->mediaTmpName == 'none' || !is_uploaded_file($this->mediaTmpName)) {
		$this->setErrors( _ER_UP_NOFILEUPLOADED );
		return false;
	}

	if ($this->mediaError > 0) {
		$this->setErrors( sprintf(_ER_UP_ERROROCCURRED, $this->mediaError) );
		return false;
	}

	return true;
}

	/**
	* Set the target filename
	*
	* @param   string  $value
	**/
	function setTargetFileName($value) {
		$this->targetFileName = strval(trim($value));
	}

	/**
	* Set the prefix
	*
	* @param   string  $value
	**/
	function setPrefix($value){
		$this->prefix = strval(trim($value));
	}

	/**
	* Get the uploaded filename
	*
	* @return  string
	**/
	function getMediaName() {
		return $this->mediaName;
	}

	/**
	* Get the type of the uploaded file
	*
	* @return  string
	**/
	function getMediaType() {
		return $this->mediaType;
	}

	/**
	* Get the size of the uploaded file
	*
	* @return  int
	**/
	function getMediaSize() {
		return $this->mediaSize;
	}

	/**
	* Get the temporary name that the uploaded file was stored under
	*
	* @return  string
	**/
	function getMediaTmpName() {
		return $this->mediaTmpName;
	}

	/**
	* Get the saved filename
	*
	* @return  string
	**/
	function getSavedFileName(){
		return $this->savedFileName;
	}

	/**
	* Get the destination the file is saved to
	*
	* @return  string
	**/
	function getSavedDestination(){
		return $this->savedDestination;
	}

	/**
	* Check the file and copy it to the destination
	*
	* @return  bool
	**/
	function upload($chmod = 0644) {
		if ($this->uploadDir == '') {
			$this->setErrors( _ER_UP_UPLOADDIRNOTSET );
			return false;
		}

		if (!$this->checkMimeType()) {
			$this->setErrors( sprintf(_ER_UP_MIMETYPENOTALLOWED, $this->mediaType) );
			return false;
		}

		if (!is_dir($this->uploadDir)) {
			$this->setErrors( sprintf(_ER_UP_FAILEDOPENDIR, $this->uploadDir) );
		}
		if (!is_writeable($this->uploadDir)) {
			$this->setErrors( sprintf(_ER_UP_FAILEDOPENDIRWRITE, $this->uploadDir) );
		}

		$this->sanitizeMultipleExtensions();

		if (!$this->checkMaxFileSize()) {
			$this->setErrors( sprintf(_ER_UP_FILESIZETOOLARGE, $this->mediaSize) );
		}
		if (!$this->checkMaxWidth()) {
			$this->setErrors( sprintf(_ER_UP_FILEWIDTHTOOLARGE, $this->maxWidth) );
		}
		if (!$this->checkMaxHeight()) {
			$this->setErrors( sprintf(_ER_UP_FILEHEIGHTTOOLARGE, $this->maxHeight) );
		}
/*
		if (!$this->checkMimeType()) {
			$this->setErrors('MIME type not allowed: '.$this->mediaType);
		}
*/

		if (!$this->checkImageType()) {
			$this->setErrors( _ER_UP_INVALIDIMAGEFILE );
		}
		if (count($this->errors) > 0) {
			return false;
		}
		if (!$this->_copyFile($chmod)) {
			$this->setErrors( sprintf(_ER_UP_FAILEDUPLOADFILE, $this->mediaName) );
			return false;
		}
		return true;
	}

	/**
	* Copy the file to its destination
	*
	* @return  bool
	**/
	function _copyFile($chmod) {
		$matched = array();
		if (!preg_match("/\.([a-zA-Z0-9]+)$/", $this->mediaName, $matched)) {
			return false;
		}
		if (isset($this->targetFileName)) {
			$this->savedFileName = $this->targetFileName;
		} elseif (isset($this->prefix)) {
			$this->savedFileName = uniqid($this->prefix).'.'.strtolower($matched[1]);
		} else {
			$this->savedFileName = strtolower($this->mediaName);
		}
		$this->savedDestination = $this->uploadDir.'/'.$this->savedFileName;
		if (!move_uploaded_file($this->mediaTmpName, $this->savedDestination)) {
			return false;
		}

		// Check IE XSS before returning success
		$ext = strtolower( substr( strrchr( $this->savedDestination , '.' ) , 1 ) ) ;
		if( in_array( $ext , $this->imageExtensions ) ) {
			$info = @getimagesize( $this->savedDestination ) ;
			if( $info === false || $this->imageExtensions[ (int)$info[2] ] != $ext ) {
				$this->setErrors( _ER_UP_SUSPICIOUSIMAGE );
				@unlink( $this->savedDestination );
				return false;
			}
		}

		@chmod($this->savedDestination, $chmod);
		return true;
	}

	/**
	* Is the file the right size?
	*
	* @return  bool
	**/
	function checkMaxFileSize() {
		if ($this->mediaSize > $this->maxFileSize) {
			return false;
		}
		return true;
	}

	/**
	* Is the picture the right width?
	*
	* @return  bool
	**/
	function checkMaxWidth() {
		if (!isset($this->maxWidth)) {
			return true;
		}
		if (false !== $dimension = getimagesize($this->mediaTmpName)) {
			if ($dimension[0] > $this->maxWidth) {
				return false;
			}
		} else {
			trigger_error(sprintf('Failed fetching image size of %s, skipping max width check..', $this->mediaTmpName), E_USER_WARNING);
		}
		return true;
	}

	/**
	* Is the picture the right height?
	*
	* @return  bool
	**/
	function checkMaxHeight() {
		if (!isset($this->maxHeight)) {
			return true;
		}
		if (false !== $dimension = getimagesize($this->mediaTmpName)) {
			if ($dimension[1] > $this->maxHeight) {
				return false;
			}
 			trigger_error(sprintf('Failed fetching image size of %s, skipping max height check..', $this->mediaTmpName), E_USER_WARNING);
		}
		return true;
	}

	/**
	* Check whether or not the uploaded file type is allowed
	*
	* @return  bool
	**/
	function checkMimeType() {
/*
		if ( empty( $this->mediaRealType ) && !$this->allowUnknownTypes ) {
			$this->setErrors( 'Unknown filetype rejected' );
			return false;
		}

		return ( empty($this->allowedMimeTypes) || in_array($this->mediaRealType, $this->allowedMimeTypes) );
*/

		if ( count( $this->extensionToMime ) == 0 ) {
			$this->setErrors( _ER_UP_UNKNOWNFILETYPEREJECTED );
			return false;
		}
		return ( empty($this->extensionToMime) || array_key_exists($this->mediaExt, $this->extensionToMime) );
	}

	/**
	* Check whether or not the uploaded image type is valid
	*
	* @return  bool
	**/
	function checkImageType() {
		if(empty($this->checkImageType)) return true;

		if( ("image" == substr($this->mediaType, 0, strpos($this->mediaType, "/"))) ||
			(!empty($this->mediaRealType) && "image" == substr($this->mediaRealType, 0, strpos($this->mediaRealType, "/"))) ){

			if ( ! ( $info = @getimagesize( $this->mediaTmpName ) ) ) {
				return false;
			}
		}
		return true;
	}

	/**
	* Sanitize executable filename with multiple extensions
	*
	**/
	function sanitizeMultipleExtensions() {
		if(empty($this->extensionsToBeSanitized)) return;
			$patterns = array();
			$replaces = array();
			foreach($this->extensionsToBeSanitized as $ext){
			$patterns[] = "/\.".preg_quote($ext)."\./i";
			$replaces[] = "_".$ext.".";
		}
		$this->mediaName = preg_replace($patterns, $replaces, $this->mediaName);
	}

	function GetextensionToMime() {
		global $xoopsModule, $xoopsUser, $xoopsDB;
		if (!is_object ( $xoopsModule ) ) {
			$hModule = &xoops_gethandler('module');
			$xoopsModule = $hModule->getByDirname('system');
		}

		$groups = is_object( $xoopsUser ) ? $xoopsUser -> getGroups() : array(XOOPS_GROUP_ANONYMOUS) ;
		$sql = 'SELECT t.mime_types, t.mime_ext, p.mperm_maxwidth, p.mperm_maxheight, p.mperm_maxsize FROM ' .
		$xoopsDB->prefix('mimetypes_perms') . ' p LEFT JOIN ' .
		$xoopsDB->prefix("mimetypes") . ' t on p.mperm_mime = t.mime_id' . ' WHERE p.mperm_module=' . $xoopsModule->mid() . ' AND p.mperm_groups IN (' . implode(',' , $groups) . ')' . ' GROUP BY t.mime_ext' ;

		$result = $xoopsDB->query($sql);
		while ( $myrow = $xoopsDB->fetchArray($result) ) {
			$mime_types = explode('|',$myrow['mime_types']);
			$intersect = array_intersect($this->allowedMimeTypes,$mime_types);
			if (count($intersect) > 0) {
				$mimeExt = $myrow['mime_ext'];
				$this->extensionToMime[$mimeExt] = array( 'maxWidth' => $myrow['mperm_maxwidth'], 'maxHeight' => $myrow['mperm_maxwidth'], 'maxSize' => $myrow['mperm_maxsize'] );
			}
		}
	}

	/**
	* Add an error
	*
	* @param   string  $error
	**/
	function setErrors($error) {
		$this->errors[] = trim($error);
	}

	/**
	* Get generated errors
	*
	* @param    bool    $ashtml Format using HTML?
	*
	* @return    array|string    Array of array messages OR HTML string
	*/
	function &getErrors($ashtml = true) {
		if (!$ashtml) {
			return $this->errors;
		} else {
			$ret = '';
			if (count($this->errors) > 0) {
				$ret = '<h4>Errors Returned While Uploading</h4>';
				foreach ($this->errors as $error) {
					$ret .= $error.'<br />';
				}
			}
			return $ret;
		}
	}
}
?>