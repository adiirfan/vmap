<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Field.php');

/**
 * Datetime Class
 * https://bootstrap-datepicker.readthedocs.org/
 * 
 * @author kflee
 * @version 1.0
 */
class Datetime_picker extends Field {
	public function init()
	{
		$this->_CI->template->set_css('!/css/bootstrap-datetimepicker.min.css');
		$this->_CI->template->set_js('!/js/moment.min.js');
		//$this->_CI->template->set_js('!/js/moment-locale/zh-cn.js');
		$this->_CI->template->set_js('!/js/bootstrap-datetimepicker.min.js');
		$this->_CI->template->set_js('!/js/form.datetime.js');
	}
}