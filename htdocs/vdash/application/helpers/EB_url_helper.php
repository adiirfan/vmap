<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('add_url_query') ) {
	/**
	 * This will append the URI parameters to the
	 * existing URL string. The query must be an
	 * array with the key and value.
	 * 
	 * @param string $url
	 * @param array $query
	 * @return string
	 */
	function add_url_query($url, $query)
	{
		$url_segments = parse_url($url);
		$query_segments = array();
		parse_str(array_ensure($url_segments, 'query', ''), $query_segments);
		$url_without_query = preg_replace('/\?.*/', '', $url);
		
		if ( iterable($query) ) {
			foreach ( $query as $name => $value ) {
				array_path_set($query_segments, $name, $value);
			}
		}
		
		if ( iterable($query_segments) ) {
			$url = $url_without_query .'?' . http_build_query($query_segments);
		}
		
		return $url;
	}
}

if ( !function_exists('current_action') ) {
	/**
	 * Get the current action that run by the controller.
	 * 
	 * @return string
	 */
	function current_action()
	{
		$CI =& get_instance();
		
		return $CI->router->fetch_method();
	}
}

if ( !function_exists('current_controller') ) {
	/**
	 * Get the current controller.
	 * 
	 * @return string
	 */
	function current_controller()
	{
		$CI =& get_instance();
		
		return $CI->router->fetch_class();
	}
}

if ( !function_exists('current_uri') ) {
	/**
	 * This will return the current URI. If the site is using a
	 * base url, it will remove the base url from the uri. The
	 * URI returned is without the leading slash and extension.
	 * 
	 * Eg: controller/action?param=value&param2=value2
	 * 
	 * @return string
	 */
	function current_uri()
	{
		$request_uri = $_SERVER['REQUEST_URI'];
		
		// Remove leading slash.
		$request_uri = preg_replace('/^\//', '', $request_uri);
		
		$request_uri = remove_base_url($request_uri);
		
		// Remove any extension behind.
		//$request_uri = preg_replace('/\\.[^.\\s]{3,4}$/', '', 'my/test/index.php?game=notepad.exe');
		
		return $request_uri;
	}
}

if ( !function_exists('has_query') ) {
	/**
	 * To check whether this URL has a query segments exists
	 * in the string.
	 * 
	 * @param string $url
	 * @return boolean
	 */
	function has_query($url)
	{
		if ( preg_match('/\?/', $url) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( !function_exists('is_absolute_url') ) {
	/**
	 * Check if the string is an absolute URL.
	 * 
	 * @param string $url
	 * @return boolean
	 */
	function is_absolute_url($url) {
		if ( preg_match('/^(http|https|\/\/)/', $url) ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( !function_exists('is_external_link') ) {
	/**
	 * To check whether a string is an external link
	 * or internal link.
	 * 
	 * @param string $link
	 * @return boolean
	 */
	function is_external_link($link)
	{
		// Check whether it has // or http:// in front.
		if ( preg_match('/^(\/\/|http\:\/\/|https\:\/\/).*$/', $link) ) {
			// Might be external url.
			// Check domain.
			$url_info = parse_url($link);
			$host_name = strtolower($url_info['host']);
			
			if ( is_empty($host_name) ) {
				// No hostname found. Internal link.
				return false;
			} else {
				// Check whether the hostname is same as the current host name.
				$current_host = strtolower($_SERVER['HTTP_HOST']);
				
				if ( $current_host == $host_name ) {
					// Same as internal hostname, internal link.
					return false;
				} else {
					// Not same as internal hostname, external link.
					return true;
				}
			}
		} else {
			// Not external url.
			return false;
		}
	}
}

if ( !function_exists('remove_base_url') ) {
	/**
	 * This function will remove the base url including the
	 * base path if detected.
	 * 
	 * For example, /baseurl/controller/action.html?key=100
	 * will return controller/action.html?key=100
	 * 
	 * This function will not wrap the URL with site_url function.
	 * 
	 * @param string $url
	 * @return string
	 */
	function remove_base_url($url)
	{
		$CI =& get_instance();
		$base_url = site_url('__tmp_file');
		$index_file = '__tmp_file' . $CI->config->item('url_suffix');
		
		$base_url = preg_replace("/$index_file/", '', $base_url);
		$base_url = preg_replace('/https?:\/\/[^\/]+\//', '', $base_url);
		$base_url = str_replace('/', '\/', $base_url);
		
		if ( is_empty($base_url) ) {
			return $url;
		}
		
		$url = preg_replace('/.*\/?' . $base_url . '/', '', $url);
		
		return $url;
	}
}

if ( !function_exists('remove_url_query') ) {
	/**
	 * To remove or make sure it doesn't exists in the URL's query segment.
	 * Eg: index.html?page=10&name=Kent+Lee
	 * remove_url_query($url, array('page'));
	 * it will return:
	 * index.html?name=Kent+Lee
	 * 
	 * @param string $url
	 * @param array $query
	 * @return string
	 */
	function remove_url_query($url, $query)
	{
		$url_segments = parse_url($url);
		
		$url_without_query = preg_replace('/\?.*/', '', $url);
		
		$query_segments = array();
		
		parse_str(array_ensure($url_segments, 'query', ''), $query_segments);
		
		if ( iterable($query) ) {
			foreach ( $query as $name ) {
				// Unset the query based on the key name/path.
				array_path_unset($query_segments, $name);
			}
		}
			
		if ( iterable($query_segments) ) {
			$query_string = http_build_query($query_segments);
			
			$url_without_query .= '?' . $query_string;
		}
		
		return $url_without_query;
	}
}

if ( !function_exists('strip_url_protocol') ) {
	/**
	 * To strip off any protocol used in the url.
	 * Eg.: http://www.domain.com will became //www.domain.com
	 * This is useful for printing script file in the HTML document.
	 * 
	 * @param string $url
	 * @return string
	 */
	function strip_url_protocol($url)
	{
		return preg_replace('/^(http\:\/\/|https\:\/\/)/', '//', $url);
	}
}

if ( !function_exists('image_url') ) {
	/**
	 * This will generate a URL for an image with different sizes.
	 * It will append the width and height at the end of the filename
	 * and before the extension.
	 * 
	 * If unable to generate the url, FALSE will be returned.
	 * 
	 * @param string $image_file
	 * @param int $width
	 * @param int $height
	 * @param string optional$base_path
	 * @return string
	 */
	function image_uri($image_file, $width=0, $height=0, $base_path='uploads')
	{
		$matches = array();
		if ( preg_match('/^(.*)\.(\S+)$/', $image_file, $matches) ) {
			$filename = $matches[1];
			$ext = $matches[2];
			
			if ( $width || $height ) {
				$filename .= '-' . $width . 'x' . $height;
			} 
			
			$filename .= '.' . $ext;
			
			if ( !is_empty($base_path) ) {
				$base_path .= '/';
			}
			
			return $base_path . $filename;
		}
		
		return false;
	}
}

if ( !function_exists('uri_check') ) {
	/**
	 * This function will check the current URI see if it 
	 * matche with the pattern (regex) specified in the first
	 * parameter. If it matched, it will return the value specified
	 * in the second parameter. Otherwise, it will return the parameter
	 * in the last parameter.
	 * 
	 * @param string $pattern
	 * @param mixed optional $true_value
	 * @param mixed optional $false_value
	 * @return mixed
	 */
	function uri_check($pattern, $true_value = true, $false_value = false)
	{
		$current_uri = current_uri();
		
		if ( preg_match($pattern, $current_uri) ) {
			return $true_value;
		} else {
			return $false_value;
		}
	}
}