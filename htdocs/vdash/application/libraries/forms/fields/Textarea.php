<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Text.php');

/**
 * Textarea Field Class
 * Multiline text field.
 * 
 * @author kflee
 */
class Textarea extends Text {
	/**
	 * To toggle the feature where the textarea
	 * box will show the line number on the 
	 * left side of the textbox.
	 * 
	 * @var boolean
	 */
	protected $_show_line_number = false;
	
	public function init()
	{
		$this->add_valid_attribute(array(
			'rows', 'cols',
		));
		
		parent::init();
	}
	
	/**
	 * To get the feature status of line number
	 * 
	 * @return boolean
	 */
	public function get_show_line_number()
	{
		return $this->_show_line_number;
	}
	
	/**
	 * To toggle the line number feature.
	 * 
	 * @param boolean $show_line_number
	 * @return null
	 */
	public function set_show_line_number($show_line_number)
	{
		$this->_show_line_number = ($show_line_number ? true : false);
		
		if ( $this->_show_line_number ) {
			$this->_CI->template->set_css('!/css/jquery-linedtextarea.css');
			$this->_CI->template->set_js('!/js/jquery-linedtextarea.js');
		}
	}
}