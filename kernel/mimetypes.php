<?php
// $Id: comment.php 506 2006-05-26 23:10:37Z skalpa $
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
/**
* XOOPS - PHP Content Management System
* Copyright (c) 2001 - 2006 <http://www.xoops.org/>
*
* Module: class.mimetypes 1.0
* Licence : GPL
* Authors :
*                        - DuGris (http://www.dugris.info)
*/

if (!defined('XOOPS_ROOT_PATH')) { die('XOOPS root path not defined'); }

include_once( XOOPS_ROOT_PATH . '/class/xoopsobject.php' );


class XoopsMimetypes extends XoopsObject {
	var $db;

	// constructor
	function xoopsmimetypes ($mime_id=null) {
		$this->db =& Database::getInstance();
		$this->initVar('mime_id',XOBJ_DTYPE_INT,0,true,11);
		$this->initVar('mime_ext',XOBJ_DTYPE_TXTBOX,'',true,10);
		$this->initVar('mime_types',XOBJ_DTYPE_TXTAREA,'',true,0);
		$this->initVar('mime_name',XOBJ_DTYPE_TXTBOX,'',true,255);
		$this->initVar('mime_status',XOBJ_DTYPE_INT,0,true,1);

		if ( !empty($mime_id) ) {
			if ( is_array($mime_id) ) {
				$this->assignVars($mime_id);
			} else {
				$this->load($mime_id);
			}
		} else {
			$this->setNew();
		}
	}

	function load($mime_id) {
		$sql = 'SELECT * FROM '.$this->db->prefix('mimetypes').' WHERE mime_id='.$mime_id;
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function load_byExt($mime_ext) {
		$sql = 'SELECT * FROM '.$this->db->prefix('mimetypes').' WHERE mime_ext=' . $this->db->quoteString($mime_ext);
		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function mime_id() {
		return $this->getVar('mime_id');
	}

	function mime_ext($format='S') {
		$ret = $this->getVar('mime_ext', $format);
		if (($format=='s') || ($format=='S') || ($format=='show')) {
			$myts = &MyTextSanitizer::getInstance();
			$ret = $myts->displayTarea($ret);
		}
		return $ret;
	}

	function mime_types($format='S') {
		$ret = $this->getVar('mime_types', $format);
		if (($format=='s') || ($format=='S') || ($format=='show')) {
			$myts = &MyTextSanitizer::getInstance();
			$ret = $myts->displayTarea($ret);
		}
		return $ret;
	}

	function mime_name($format='S') {
		$ret = $this->getVar('mime_name', $format);
		if (($format=='s') || ($format=='S') || ($format=='show')) {
			$myts = &MyTextSanitizer::getInstance();
			$ret = $myts->displayTarea($ret);
		}
		return $ret;
	}

	function mime_status() {
		return $this->getVar('mime_status');
	}
}

class XoopsMimetypesHandler extends XoopsObjectHandler {

	function &create($isNew = true) {
		$tplfile = new XoopsTplfile();
		if ($isNew) {
			$tplfile->setNew();
		}
		return $tplfile;
	}

	function get_byExt( $mime_ext, $asobject=true ) {
		$ret = array();
		$sql = 'SELECT * FROM ' . $this->db->prefix('mimetypes') . ' WHERE mime_ext = ' . $this->db->quoteString($mime_ext);

		$result = $this->db->query($sql);
		if (!$result) {
			return $ret;
		}

		while ( $myrow = $this->db->fetchArray($result) ) {
			if ( !$asobject ) {
				$ret[$myrow['mime_id']] = $myrow;
			} else {
				$ret[] = new xoopsmimetypes( $myrow );
			}
		}
		return $ret;
	}

	function get_mimetypes($limit=20, $start=0, $status=-1, $OtherCriteria=null, $sort='mime_ext', $order='ASC', $asobject=true) {
		$ret = array();
		$criteria = new CriteriaCompo();

		if ( is_object($OtherCriteria) ) {
			$criteria->add($OtherCriteria, 'AND');
		}

		if ( isset($status) && (is_array($status)) ) {
			foreach ($status as $v) {
				$criteria->add(new Criteria('mime_status', $v), 'AND');
			}
		} elseif ( isset($status) && ($status != -1) ) {
			$criteria->add(new Criteria('mime_status', $status), 'AND');
		}

		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort($sort);
		$criteria->setOrder($order);

		$sql = 'SELECT * FROM '.$this->db->prefix('mimetypes');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}

			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}

		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}

		while ( $myrow = $this->db->fetchArray($result) ) {
			if ( !$asobject ) {
				$ret[$myrow['mime_id']] = $myrow;
			} else {
				$ret[] = new xoopsmimetypes( $myrow );
			}
		}
		return $ret;
	}

	function getCount($criteria = null, $notNullFields='') {
		$sql = 'SELECT COUNT(*) FROM '.$this->db->prefix('mimetypes');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$whereClause = $criteria->renderWhere();
			if ($whereClause != 'WHERE ()') {
				$sql .= ' '.$criteria->renderWhere();
			}
		}
		$result = $this->db->query($sql);
		if (!$result) {
			return 0;
		}
		list($count) = $this->db->fetchRow($result);
		return $count;
	}

	function insert(&$mimetype_object, $force = false) {
		if (strtolower(get_class($mimetype_object)) != 'xoopsmimetypes') {
			return false;
		}
		if (!$mimetype_object->isDirty()) {
			return true;
		}
		if (!$mimetype_object->cleanVars()) {
			return false;
		}
		foreach ($mimetype_object->cleanVars as $k => $v) {
			${$k} = $v;
		}
		if ($mimetype_object->isNew()) {
			$mimetype_object = new xoopsmimetypes();
			$format = "INSERT INTO %s (mime_id, mime_ext, mime_types, mime_name, mime_status)";
			$format .= "VALUES (%u, %s, %s, %s, %u)";
			$sql = sprintf($format ,
			$this->db->prefix('mimetypes'),
			$mime_id,
			$this->db->quoteString($mime_ext),
			$this->db->quoteString($mime_types),
			$this->db->quoteString($mime_name),
			$mime_status);
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="mime_ext=%s, mime_types=%s, mime_name=%s, mime_status=%u";
			$format .=" WHERE mime_id = %u";
			$sql = sprintf($format, $this->db->prefix('mimetypes'),

			$this->db->quoteString($mime_ext),
			$this->db->quoteString($mime_types),
			$this->db->quoteString($mime_name),
			$mime_status,
			$mime_id);
		}

		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}

		if (!$result) {
			$this->setErrors($this->db->error() );
			return false;
		}

		if ($mimetype_object->isNew()) {
			$mimetype_object->assignVar('mime_id', $this->db->getInsertId() );
		}
		return true;
	}

	function delete(&$mimetype_object, $force = false) {
		if (strtolower(get_class($mimetype_object)) != 'xoopsmimetypes') {
			return false;
		}

		$sql = sprintf("DELETE FROM %s WHERE mime_id = %u", $this->db->prefix("mimetypes"), $mimetype_object->getVar('mime_id'));
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}

		if (!$result) {
			$this->setErrors($this->db->error() );
			return false;
		}

		$sql = sprintf("DELETE FROM %s WHERE mperm_mime = %u", $this->db->prefix("mimetypes_perms"), $mimetype_object->getVar('mime_id'));
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			$this->setErrors($this->db->error() );
			return false;
		}
		return true;
	}

	function &GetSelectList($criteria = null) {
		$ret = array();
		$limit = $start = 0;
		$sql = 'SELECT * FROM '.$this->db->prefix('mimetypes');
		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere();
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}
		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}
		while ($myrow = $this->db->fetchArray($result)) {
			$ret[$myrow['mime_id']] = $myrow['mime_ext'] . ' - ' . $myrow['mime_name'];
		}
		return $ret;
	}

	function XoopsFormSelectMime( $caption, $name, $value=null, $size=1, $multiple=false ) {
		$ret = new XoopsFormSelect($caption, $name, $value, $size, $multiple);
		$criteria = new CriteriaCompo();
		$criteria->setSort('mime_ext');
		$ret->addOptionArray( $this->GetSelectList($criteria) );
		return $ret;
	}

	function XoopsFormSelectType( $caption, $name, $value=null, $size=1, $multiple=false ) {
		$ret = new XoopsFormSelect($caption, $name, $value, $size, $multiple);
		$ret->addOptionArray( $this->Get_TypeList() );
		return $ret;
	}

	function Get_TypeList() {
		$ret = array();
		$sql = 'SELECT * FROM ' . $this->db->prefix("mimetypes") ;

		$result = $this->db->query($sql);
		while ( $myrow = $this->db->fetchArray($result) ) {
			$mime_types = explode('|',$myrow['mime_types']);
			foreach ( $mime_types as $mime_type ) {
				if ( $type = substr( $mime_type, 0, strpos($mime_type, '/') ) ) {
					if ( !in_array ($type, $ret) ) {
						$ret[$type] = $type;
					}
				}
			}
		}
		return $ret;
	}

	function setErrors($err_str) {
		$this->_errors[] = trim($err_str);
	}

	function getHtmlErrors() {
		$ret = '<h4>Errors</h4>';
		if (!empty($this->_errors)) {
			foreach ($this->_errors as $error) {
				$ret .= $error.'<br />';
			}
		} else {
			$ret .= 'None<br />';
		}
		return $ret;
	}
}


class XoopsMimetypes_perms extends XoopsObject {
	var $db;

	// constructor
	function xoopsmimetypes_perms ($mperm_id=null) {
		$this->db =& Database::getInstance();
		$this->initVar('mperm_id',XOBJ_DTYPE_INT,0,true,10);
		$this->initVar('mperm_mime',XOBJ_DTYPE_INT,0,true,11);
		$this->initVar('mperm_module'  ,XOBJ_DTYPE_INT,0,true,5);
		$this->initVar('mperm_groups'  ,XOBJ_DTYPE_TXTAREA,'',false,0);
		$this->initVar('mperm_status'  ,XOBJ_DTYPE_INT,0,true,1);
		$this->initVar('mperm_maxwidth'  ,XOBJ_DTYPE_INT,0,true,4);
		$this->initVar('mperm_maxheight',XOBJ_DTYPE_INT,0,true,4);
		$this->initVar('mperm_maxsize'  ,XOBJ_DTYPE_INT,0,true,8);
		$this->initVar('mime_ext',XOBJ_DTYPE_TXTBOX,'',true,10);
		$this->initVar('mime_name',XOBJ_DTYPE_TXTBOX,'',true,255);
		$this->initVar('mod_name',XOBJ_DTYPE_TXTBOX,'',true,255);

		if ( !empty($mperm_id) ) {
			if ( is_array($mperm_id) ) {
				$this->assignVars($mperm_id);
			} else {
				$this->load($mperm_id);
			}
		} else {
			$this->setNew();
		}
	}

	function load($module_id) {
		$sql = 'SELECT p.*, t.mime_ext, t.mime_name, m.name FROM ' . $this->db->prefix('mimetypes_perms') . ' p LEFT JOIN ' .
		$this->db->prefix("mimetypes") . ' t on p.mperm_mime = t.mime_id LEFT JOIN ' .
		$this->db->prefix("modules") . ' m on p.mperm_module = m.mid' . ' WHERE mperm_id=' . $this->db->quoteString($module_id);

		$myrow = $this->db->fetchArray($this->db->query($sql));
		$this->assignVars($myrow);
		if (!$myrow) {
			$this->setNew();
		}
	}

	function mime_id() {
		return $this->getVar('mperm_id');
	}

	function mperm_mime() {
		return $this->getVar('mperm_mime');
	}

	function mperm_module() {
		return $this->getVar('mperm_module');
	}

	function mime_ext($format='S') {
		$ret = $this->getVar('mime_ext', $format);
		if (($format=='s') || ($format=='S') || ($format=='show')) {
			$myts = &MyTextSanitizer::getInstance();
			$ret = $myts->displayTarea($ret);
		}
		return $ret;
	}

	function mime_module($format='S') {
		$ret = $this->getVar('name', $format);
		if (($format=='s') || ($format=='S') || ($format=='show')) {
			$myts = &MyTextSanitizer::getInstance();
			$ret = $myts->displayTarea($ret);
		}
		return $ret;
	}

	function mime_name($format='S') {
		$ret = $this->getVar('mime_name', $format);
		if (($format=='s') || ($format=='S') || ($format=='show')) {
			$myts = &MyTextSanitizer::getInstance();
			$ret = $myts->displayTarea($ret);
		}
		return $ret;
	}

	function mime_groups() {
		return $this->getVar('mperm_groups');
	}

	function mperm_maxwidth() {
		return $this->getVar('mperm_maxwidth');
	}

	function mperm_maxheight() {
		return $this->getVar('mperm_maxheight');
	}

	function mperm_maxsize() {
		return $this->getVar('mperm_maxsize');
	}

	function mperm_status() {
		return $this->getVar('mperm_status');
	}

	function GetGroups() {
		$groups = array();
		$sql = 'SELECT p.mperm_groups FROM ' . $this->db->prefix('mimetypes_perms') . ' p LEFT JOIN ' .
		$this->db->prefix("mimetypes") . ' t on p.mperm_mime = t.mime_id ' . ' WHERE mperm_module=' . $this->mperm_module() . ' AND mperm_mime=' . $this->mperm_mime();
		$result = $this->db->query($sql);

		while ( $myrow = $this->db->fetchArray($result) ) {
			$groups[] = $myrow['mperm_groups'];
		}

		return $groups;
	}
}

class XoopsMimetypes_permsHandler extends XoopsObjectHandler {
	var $_errors = array();

	function get_mimetypes($limit=20, $start=0, $module=-1, $OtherCriteria=null, $asobject=true) {
		$ret = array();
		$criteria = new CriteriaCompo();
		if ( is_object($OtherCriteria) ) {
			$criteria->add($OtherCriteria, 'AND');
		}

		if ( isset($module) && (is_array($module)) ) {
			foreach ($module as $v) {
				$criteria->add(new Criteria('p.mperm_module', $v), 'AND');
			}
		} elseif ( isset($module) && ($module != -1) ) {
			$criteria->add(new Criteria('p.mperm_module', $module), 'AND');
		}

		$criteria->setLimit($limit);
		$criteria->setStart($start);
		$criteria->setSort('t.mime_ext');
		$criteria->setOrder('ASC');
		$criteria->setGroupby('p.mperm_mime');

		$sql = 'SELECT p.*, t.mime_ext, t.mime_name, m.name FROM ' . $this->db->prefix('mimetypes_perms') . ' p LEFT JOIN ' .
		$this->db->prefix("mimetypes") . ' t on p.mperm_mime = t.mime_id LEFT JOIN ' .
		$this->db->prefix("modules") . ' m on p.mperm_module = m.mid';

		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$sql .= ' '.$criteria->renderWhere() . $criteria->getGroupby();
			if ($criteria->getSort() != '') {
				$sql .= ' ORDER BY '.$criteria->getSort().' '.$criteria->getOrder();
			}
			$limit = $criteria->getLimit();
			$start = $criteria->getStart();
		}

		$result = $this->db->query($sql, $limit, $start);
		if (!$result) {
			return $ret;
		}

		while ( $myrow = $this->db->fetchArray($result) ) {
			if ( !$asobject ) {
				$ret[$myrow['mime_id']] = $myrow;
			} else {
				$ret[] = new xoopsmimetypes_perms( $myrow );
			}
		}
		return $ret;
	}

	function get_byMimeModule( $mime_id, $mid, $asobject=true) {
		$ret = array();
		$sql = 'SELECT * FROM ' . $this->db->prefix('mimetypes_perms') . ' WHERE mperm_mime = ' . $mime_id . ' AND mperm_module = ' . $mid;
		$result = $this->db->query($sql);
		if (!$result) {
			return $ret;
		}

		while ( $myrow = $this->db->fetchArray($result) ) {
			if ( !$asobject ) {
				$ret[$myrow['mime_id']] = $myrow;
			} else {
				$ret[] = new xoopsmimetypes_perms( $myrow );
			}
		}
		return $ret;
	}

	function getCount($criteria = null, $notNullFields='') {
		$sql = 'SELECT COUNT(*) FROM ' . $this->db->prefix('mimetypes_perms') . ' p LEFT JOIN ' .
		$this->db->prefix("mimetypes") . ' t on p.mperm_mime = t.mime_id LEFT JOIN ' .
		$this->db->prefix("modules") . ' m on p.mperm_module = m.mid';

		if (isset($criteria) && is_subclass_of($criteria, 'criteriaelement')) {
			$whereClause = $criteria->renderWhere();
			if ($whereClause != 'WHERE ()') {
				$sql .= ' '.$criteria->renderWhere();
			}
		}

		$result = $this->db->query($sql);

		if (!$result) {
			return 0;
		}

		list($count) = $this->db->fetchRow($result);
		return $count;
	}

	function mime_module( $mid ) {
		$module_handler =& xoops_gethandler('module');
		$module = $module_handler->get( $mid );
		return $module->name();
	}

	function insert(&$mimetype_object, $force = false) {
		if (strtolower(get_class($mimetype_object)) != 'xoopsmimetypes_perms') {
			return false;
		}
		if (!$mimetype_object->isDirty()) {
			return true;
		}
		if (!$mimetype_object->cleanVars()) {
			return false;
		}
		foreach ($mimetype_object->cleanVars as $k => $v) {
			${$k} = $v;
		}

		if ($mimetype_object->isNew()) {
			$mimetype_object = new xoopsmimetypes();
			$format = "INSERT INTO %s (mperm_id, mperm_mime, mperm_module, mperm_groups, mperm_status, mperm_maxwidth, mperm_maxheight, mperm_maxsize)";
			$format .= "VALUES (%u, %u, %u, %s, %u, %u, %u, %u)";
			$sql = sprintf($format ,
			$this->db->prefix('mimetypes_perms'),
			$mperm_id,
			$mperm_mime,
			$mperm_module,
			$mperm_groups,
			$mperm_status,
			$mperm_maxwidth,
			$mperm_maxheight,
			$mperm_maxsize );
			$force = true;
		} else {
			$format = "UPDATE %s SET ";
			$format .="mperm_mime=%u, mperm_module=%u, mperm_groups=%s, mperm_status=%u, mperm_maxwidth=%u, mperm_maxheight=%u, mperm_maxsize=%u";
			$format .=" WHERE mperm_id = %u";
			$sql = sprintf($format, $this->db->prefix('mimetypes_perms'),
			$mperm_mime,
			$mperm_module,
			$this->db->quoteString($mperm_groups),
			$mperm_status,
			$mperm_maxwidth,
			$mperm_maxheight,
			$mperm_maxsize,
			$mperm_id);
		}

		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			$this->setErrors($this->db->error() );
			return false;
		}

		if ($mimetype_object->isNew()) {
			$mimetype_object->assignVar('mime_id', $this->db->getInsertId() );
		}

		return true;
	}

	function delete(&$mimetype_object, $force = false) {
		if (strtolower(get_class($mimetype_object)) != 'xoopsmimetypes_perms') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE mperm_id = %u", $this->db->prefix("mimetypes_perms"), $mimetype_object->getVar('mperm_id'));
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}
		if (!$result) {
			$this->setErrors($this->db->error() );
			return false;
		}
		return true;
	}

	function deletebyMimeModule(&$mimetype_object, $force = false) {
		if (strtolower(get_class($mimetype_object)) != 'xoopsmimetypes_perms') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE mperm_mime = %u AND mperm_module = %u", $this->db->prefix("mimetypes_perms"), $mimetype_object->getVar('mperm_mime'), $mimetype_object->getVar('mperm_module'));
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}

		if (!$result) {
			$this->setErrors($this->db->error() );
			return false;
		}
		return true;
	}

	function deletebyMime(&$mimetype_object, $force = false) {
		if (strtolower(get_class($mimetype_object)) != 'xoopsmimetypes_perms') {
			return false;
		}
		$sql = sprintf("DELETE FROM %s WHERE mperm_mime = %u", $this->db->prefix("mimetypes_perms"), $mimetype_object->getVar('mperm_mime'));
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}

		if (!$result) {
			$this->setErrors($this->db->error() );
			return false;
		}

		return true;
	}

	function deletebyModule(&$mimetype_object, $force = false) {
		if (strtolower(get_class($mimetype_object)) != 'xoopsmimetypes_perms') {
			return false;
		}

		$sql = sprintf("DELETE FROM %s WHERE mperm_module = %u AND mperm_mime = %u", $this->db->prefix("mimetypes_perms"), $mimetype_object->getVar('mperm_module'), $mimetype_object->getVar('mperm_mime'));
		if (false != $force) {
			$result = $this->db->queryF($sql);
		} else {
			$result = $this->db->query($sql);
		}

		if (!$result) {
			$this->setErrors($this->db->error() );
			return false;
		}
		return true;
	}

	function allowedMimeTypes( $mid, $groups, $allowedMimeTypes ) {
		$ret = array();
		$sql = 'SELECT p.mperm_groups, t.mime_ext, t.mime_types FROM ' . $this->db->prefix('mimetypes_perms') . ' p LEFT JOIN ' .
		$this->db->prefix("mimetypes") . ' t on p.mperm_mime = t.mime_id WHERE mperm_module=' . $mid;

		$result = $this->db->query($sql);

		while ( $myrow = $this->db->fetchArray($result) ) {
			$mperm_groups = explode('|',$myrow['mperm_groups']);
			if (count(array_intersect($groups,$mperm_groups)) > 0) {
				$mime_types = explode('|',$myrow['mime_types']);
				$tmp = array_intersect($allowedMimeTypes,$mime_types);
				if (count($tmp) > 0) {
					$ret = array_merge ($ret, $tmp);
				}
			}
		}

		if ( count($ret) == 0 ) {
			@$ret = include( XOOPS_ROOT_PATH . '/class/mimetypes.inc.php' );
			return $ret;
		}
		return $ret;
	}

	function setErrors($err_str) {
		$this->_errors[] = trim($err_str);
	}

	function getHtmlErrors() {
		$ret = '<h4>Errors</h4>';
		if (!empty($this->_errors)) {
			foreach ($this->_errors as $error) {
				$ret .= $error.'<br />';
			}
		} else {
			$ret .= 'None<br />';
		}
		return $ret;
	}
}
?>