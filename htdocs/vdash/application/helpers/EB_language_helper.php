<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('_lang') ) {
	function _lang() {
		$args = func_get_args();
		
		if ( iterable($args) ) {
			$args[0] = lang($args[0]);
		}
		
		$line = call_user_func_array('sprintf', $args);
		
		return $line;
	}
}