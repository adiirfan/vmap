<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Multiselect.php');
require_once(APPPATH . 'models/nested_model.php');

class Multiselect_nested extends Multiselect {
	protected $_nested_model = null;
	
	public function get_nested_model()
	{
		$this->_nested_model;
	}
	
	public function set_nested_model($nested_model)
	{
		if ( $nested_model instanceof Nested_model ) {
			$this->_nested_model = $nested_model;
		} else {
			show_error('Invalid model passed to the nested form element', 500);
		}
	}
	
	public function set_format_option($format_func)
	{
		$db = $this->_nested_model->query_node_depth();
		
		$this->_options = $format_func($db);
	}
}