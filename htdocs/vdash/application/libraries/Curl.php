<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/EB_Library.php');

/**
 * CURL library.
 *  
 */
class Curl extends EB_Library
{
	public function init()
	{
		if ( !function_exists('curl_init') ) {
			show_error('CURL library is not installed.', 500);
		}
	}
	
	/**
	 * Send a HTTP GET request to the specified URL.
	 * Allowed additional URI to be appended using
	 * the second parameter with associated array.
	 * 
	 * The last parameter accept CURL OPTIONS values.
	 * 
	 * @param string $url
	 * @param array optional $params
	 * @param array optional $options
	 * @return string
	 */
	public function get($url, $params = array(), $options = array())
	{
		if ( iterable($params) ) {
			if ( !preg_match('/\?$/', $url) ) {
				$url .= '?';
			}
			
			$url .= http_build_query($params);
		}
		
		$options[CURLOPT_URL] = $url;
		$options[CURLOPT_RETURNTRANSFER] = array_ensure($options, CURLOPT_RETURNTRANSFER, 1);
		$options[CURLOPT_HEADER] = array_ensure($options, CURLOPT_HEADER, 0);
		$options[CURLOPT_USERAGENT] = array_ensure($options, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 5.1; rv:31.0) Gecko/20100101 Firefox/31.0');
		$options[CURLOPT_IPRESOLVE] = array_ensure($options, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		
		$curl = curl_init();
		
		curl_setopt_array($curl, $options);
		
		$response = curl_exec($curl);
		
		//print_r(curl_getinfo($curl));
		
		if ( false === $response ) {
			echo curl_error($curl);
		}
		
		curl_close($curl);
		
		return $response;
	}
	
	/**
	 * This is similar to get. But it will return JSON formatted
	 * object.
	 * 
	 * @param string $url
	 * @param array optional $params
	 * @param array optional $options
	 * @param boolean optional $assoc
	 * @return mixed
	 */
	public function get_json($url, $params = array(), $options = array(), $assoc = true)
	{
		$response = $this->get($url, $params, $options);
		
		if ( !is_empty($response) ) {
			return json_decode($response, $assoc);
		} else {
			return null;
		}
	}
	
	/**
	 * To send a HTTP POST request to the specified URL.
	 * 
	 * @param string $url
	 * @param array optional $params
	 * @param array optional $options
	 * @return mixed
	 */
	public function post($url, $params = array(), $options = array())
	{
		$field_string = '';
		
		if ( iterable($params) ) {
			foreach ( $params as $key => $value ) {
				$field_string .= urlencode($key) . '=' . urlencode($value) . '&';
			}
			
			rtrim($field_string, '&');
		}
		
		$options[CURLOPT_URL] = $url;
		$options[CURLOPT_RETURNTRANSFER] = array_ensure($options, CURLOPT_RETURNTRANSFER, 1);
		$options[CURLOPT_HEADER] = array_ensure($options, CURLOPT_HEADER, 0);
		$options[CURLOPT_USERAGENT] = array_ensure($options, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:40.0) Gecko/20100101 Firefox/40.0');
		$options[CURLOPT_IPRESOLVE] = array_ensure($options, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
		$options[CURLOPT_POST] = sizeof($params);
		$options[CURLOPT_SSL_VERIFYPEER] = false;
		$options[CURLOPT_SSL_VERIFYHOST] = 0;
		$options[CURLOPT_POSTFIELDS] = $field_string;
		//$options[CURLOPT_HEADER] = strlen($field_string);
		
		$curl = curl_init();
		
		curl_setopt_array($curl, $options);
		
		$response = curl_exec($curl);
		
		if ( false === $response ) {
			echo curl_error($curl);
		}
		
		curl_close($curl);
		
		return $response;
	}
	
	/**
	 * To make a HTTP POST request and expect the result to be
	 * JSON formatted string. This method will decode the string
	 * and return as object or array.
	 * 
	 * @param string $url
	 * @param array optional $params
	 * @param array optional $options
	 * @param boolean optional $assoc
	 * @return mixed
	 */
	public function post_json($url, $params = array(), $options = array(), $assoc = true)
	{
		$response = $this->post($url, $params, $options);
		
		if ( !is_empty($response) ) {
			return json_decode($response, $assoc);
		} else {
			return null;
		}
	}
	
	/**
	 * Save an image from a URL. If the URL is not an
	 * image source, this function will returned FALSE.
	 * 
	 * Otherwise, it will return the path to the uploaded
	 * image. The path will include the uploads/ path.
	 * 
	 * @param string $image_url
	 * @return string|boolean
	 */
	public function save_image($image_url)
	{
		$this->_CI->load->helper('file');
		$this->_CI->load->model('Picture_model', 'picture_model');
		
		$upload_dir = $this->_CI->picture_model->get_upload_dir();
		$ds = DIRECTORY_SEPARATOR;
		$tmp_name = time() . '_' . md5($image_url);
		$tmp_path = $upload_dir . $ds . $tmp_name;
		
		$options = array(
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_BINARYTRANSFER => 1,
		);
		
		$binary = $this->get($image_url, null, $options);
		
		$fp = fopen($tmp_path, 'wb');
		fwrite($fp, $binary);
		fclose($fp);
		
		$ext = image_type($tmp_path);
		
		if ( $ext ) {
			// Rename the tmp_name.
			$new_filename = $tmp_name . '.' . $ext;
			$new_path = $upload_dir . $ds . $new_filename;
			
			rename($tmp_path, $new_path);
			
			return $new_path;
		} else {
			// Unable to determine the file extension, remove it.
			unlink($tmp_path);
		}
		
		return false;
	}
}