<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/EB_Library.php');

/**
 * System Class
 * This class is affecting the global website.
 * It allowed you to set system message, offline mode and many other
 * options. But it will not affect the controller's process. This
 * will act as a middleman where other class can interact with the
 * global settings.
 * 
 * @author Kent Lee
 * @date 5 Jul 2013
 */
class System extends EB_Library {
	/**
	 * The variable name in session for last
	 * visited URL.
	 * 
	 * @var string
	 */
	const last_url = '__last_url';
	
	/**
	 * The variable name in session for
	 * error message.
	 * 
	 * @var string
	 */
	const system_message = '__system_message';
	
	/**
	 * An ID generated by the class itself and
	 * stored in session with the key [client_id].
	 * This can used in form to prevent XSRF.
	 * 
	 * @var string
	 */
	protected $_client_id = '';
	
	/**
	 * To indicate whether to track the current
	 * URL or not.
	 * 
	 * @var boolean
	 */
	protected $_url_tracking = true;
	
	public function init()
	{
		$client_id = $this->_CI->session->userdata('client_id');
		
		if ( null === $client_id ) {
			// Generate the client's ID.
			$client_id = $this->_generate_client_id();
			
			$this->_CI->session->set_userdata('client_id', $client_id);
		}
		
		$this->_client_id = $client_id;
	}
	
	public function get_client_id()
	{
		return $this->_client_id;
	}
	
	/**
	 * Get the system message.
	 * 
	 * @param boolean optional $auto_clear Automatically clear the old message.
	 * @return array|boolean
	 */
	public function get_message($auto_clear = true)
	{
		$message =  $this->_CI->session->userdata(self::system_message);
		
		if ( $message !== false && $auto_clear ) {
			// Remove the session.
			$this->_CI->session->unset_userdata(self::system_message);
		}
		
		return $message;
	}
	
	/**
	 * Get the URL tracking flag.
	 * 
	 * @return boolean
	 */
	public function get_url_tracking()
	{
		return $this->_url_tracking;
	}
	
	/**
	 * Check whether there is any message.
	 * 
	 * @return boolean
	 */
	public function has_message()
	{
		return ($this->message_count() > 0);
	}
	
	/**
	 * To load external library from the folder external_libraries/
	 * No extension need to specify.
	 * 
	 * @param string $file
	 * @return null
	 */
	public function load_external_library($file)
	{
		$path = APPPATH . 'external_libraries/' . $file . '.php';
		
		if ( file_exists($path) ) {
			require_once($path);
		} else {
			log_message('error', 'External library: ' . $path . ' not found.');
			show_error(lang('_error_external_library_not_found'), 500);
		}
	}
	
	public function load_jquery_ui()
	{
		/* 
		 * @var Template
		 */
		$template = $this->_CI->template;
		
		if ( $template->is_js_loaded('!/js/jquery-ui/jquery-ui.min.js') || 
			$template->is_js_loaded('!/js/jquery-ui/jquery-ui.js') ) {
			return ;
		}
		
		$template->set_css('!/js/jquery-ui/jquery-ui.min.css');
		$template->set_css('!/js/jquery-ui/jquery-ui.structure.min.css');
		$template->set_css('!/js/jquery-ui/jquery-ui.theme.min.css');
		
		$template->set_js('!/js/jquery-ui/jquery-ui.min.js');
	}
	
	/**
	 * Get the total number of message count.
	 * 
	 * @return int
	 */
	public function message_count()
	{
		$session = $this->_CI->session;
		$system_messages = $session->userdata(self::system_message);
		
		if ( false !== $system_messages && iterable($system_messages) ) {
			return sizeof($system_messages);
		} else {
			return 0;
		}
	}
	
	/**
	 * Resume back to the tracked URL.
	 * This will redirect the user agent
	 * to the last URI.
	 * 
	 * @param string $default The default URI to be redirected if no last URL tracked.
	 * @return null
	 */
	public function resume_url($default = "/")
	{
		$uri = $this->_CI->session->flashdata(self::last_url);
		
		if ( false !== $uri && !is_empty($uri) ) {
			log_message('debug', 'URL Redirected: ' . $uri);
			
			redirect($uri);
		} else {
			// Back to the default controller page.
			log_message('debug', 'URL Redirected: ' . $uri);
			
			redirect($default);
		}
	}
	
	/**
	 * Remain the tracked URL.
	 * 
	 * @return null
	 */
	public function remain_url()
	{
		$this->_CI->session->keep_flashdata(self::last_url);
	}
	

	/**
	 * Set global message. Message will be stored in sesison.
	 * If the message wasn't retrieve, it will stay in there
	 * forever.
	 * 
	 * @param string $type The message type. Native support: success, info, warning, danger
	 * @param string $message
	 * @param string $icon_class The icon class used.
	 * @return null
	 */
	public function set_message($type, $message, $icon_class = '')
	{
		if ( !isset($this->_CI->session) ) {
			show_error(lang('_error_session_not_initialized'), 500);
			return ;
		}
		
		$session = $this->_CI->session;
		
		$system_message = $session->userdata(self::system_message);
		
		if ( false === $system_message ) {
			$system_message = array();
		}
		
		$system_message[] = array(
			'type' => $type,
			'message' => $message,
			'icon' => trim($icon_class),
		);
		
		$session->set_userdata(self::system_message, $system_message);
	}
	
	/**
	 * Enable/disable the URL tracking feature.
	 * 
	 * @param boolean $track
	 */
	public function set_url_tracking($track)
	{
		$this->_url_tracking = ($track == true ? true : false);
	}
	
	/**
	 * Track the current URL into the session.
	 * 
	 * @return null
	 */
	public function track_url()
	{
		// Generate the full URL.
		$full_url = (empty($_SERVER['HTTPS']) ? 'http' : 'https') . '://' . $this->_CI->input->server('HTTP_HOST') . $this->_CI->input->server('REQUEST_URI');
		
		$this->_CI->session->set_flashdata(self::last_url, $full_url);
		
		log_message('debug', 'URL Tracked: ' . $full_url);
	}
	
	/**
	 * Verify if the provided client ID matched with the one
	 * currently stored in the session.
	 * 
	 * @param string $client_id
	 * @return boolean
	 */
	public function verify_client_id($client_id)
	{
		if ( $client_id != $this->get_client_id() ) {
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * Generate a random string for this client's ID.
	 * 
	 * @return string
	 */
	protected function _generate_client_id()
	{
		$server_vars = array(
			'REMOTE_ADDR', 'HTTP_HOST', 'HTTP_USER_AGENT'
		);
		
		$text = '';
		
		foreach ( $server_vars as $var_name ) {
			if ( isset($_SERVER[$var_name]) ) {
				$text .= $_SERVER[$var_name];
			}
		}
		
		$str = hash('sha256', $text . time());
		
		return $str;
	}
}