<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Extending the core CoreIgniter Input
 * class.
 * 
 * @author Kent
 */
class EB_Input extends CI_Input {
	
	/**
	 * To check whether the request is an Ajax
	 * request.
	 * 
	 * @return boolean
	 */
	public function is_ajax()
	{
		$CI =& get_instance();
		
		$xhr = $CI->input->server('HTTP_X_REQUESTED_WITH');
		
		if ( $xhr !== false && $xhr == 'XMLHttpRequest' ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Return true if it is a post request.
	 * 
	 * @return boolean
	 */
	public function is_post()
	{
		return ( $_SERVER['REQUEST_METHOD'] == 'POST' );
	}
}