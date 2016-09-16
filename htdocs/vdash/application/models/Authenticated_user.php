<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Authenticated_user Interface
 * 
 * This interface is used to implement and turn the model into an
 * authentication model. The library calss Authentication will use
 * these model for the authentication purpose. 
 * 
 * @author kent Lee
 * @date 18 Jul 2013
 * @version 1.0
 * 
 */
interface Authenticated_user {
	/**
	 * Get the list of roles that this user belongs
	 * to. It needs to be an array with the list 
	 * of role's name.
	 * 
	 * @return array
	 */
	public function get_roles();
	
	/**
	 * This method should initialize the model object
	 * itself with the session's ID set during the login
	 * or authentication page.
	 * 
	 * @return null
	 */
	public function initialize_from_session();
}