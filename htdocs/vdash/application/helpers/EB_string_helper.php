<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('currency_text') ) {
	/**
	 * Compose the currency text based on the amount and
	 * the symbol. It allow you to configure the symbol
	 * position to appear on after or before the amount.
	 * 
	 * @param string $amount
	 * @param string $symbol
	 * @param string optional $position "before" or "after"
	 * @return string
	 */
	function currency_text($amount, $symbol, $position = 'before')
	{
		if ( $position == 'after' ) {
			return $amount . ' ' . $symbol;
		} else {
			return $symbol . ' ' . $amount;
		}
	}
}

if ( !function_exists('filesize_convert') ) {
	/**
	 * To convert a string with the proper filesize format to numberic number.
	 *
	 * @param string $size The string contained the filesize value with unit. Eg.: 3MB, 1KB, 1024B, 1GB, 30TB
	 * @param string optional $desired_unit The desired output unit. Options: B, KB, MB, GB, TG
	 * @param int optional $decimal The number of decimal point. If 2, the output will force to have two decimal points.
	 * @return int|float
 	*/
	function filesize_convert($size, $desired_unit='', $decimal=0)
	{
		$scales = array(
			'B' => 1,
			'KB' => 1024,
			'MB' => pow(1024, 2),
			'GB' => pow(1024, 3),
			'TB' => pow(1024, 4),
		);

		$regex = '/^(\d+)[ ]?(\S+)$/';
		preg_match($regex, $size, $matches);

		if ( sizeof($matches) != 3 ) {
			return false;
		} else {
			$unit = strtoupper($matches[2]);
				
			// Check the unit.
			if ( !isset($scales[$unit]) ) {
				return false;
			}
			
			$value = $matches[1];
			$value_in_bytes = $value * $scales[$unit];
			
			$desired_unit = strtoupper($desired_unit);
			
			if ( !is_empty($desired_unit) && isset($scales[$desired_unit]) ) {
				// Convert it into numeric value.
				return (number_format($value_in_bytes / $scales[$desired_unit], $decimal, '.', '') + 0);
			} else {
				// Determine the nearest unit for it.
				$reversed_scales = array_reverse($scales);
				
				foreach ( $reversed_scales as $unit => $scale ) {
					if ( $value_in_bytes > $scale ) {
						return (number_format($value_in_bytes / $scale, $decimal, '.', '')) . $unit;
					}
				}
			}
		}
	}
}

if (!function_exists('fparam_to_array')) {
	/**
	 * To convert a plain text that used to call a function with parameters into
	 * an array. The index is start with 0.
	 * @param string $param_string
	 * @return array
	 */
	function fparam_to_array($param_string)
	{
		$tmp_params = preg_split('/,/', $param_string);
		$parameters = array();
		$quote_flag = false;
		$quoted_param = "";
		
		foreach ($tmp_params as $ind => $param) {
			$param = strtrim($param);
			// Check if first character is a quote but the last character is not a quote.
			$first_char = substr($param, 0, 1);
			$last_char = substr($param, strlen($param)-1, 1);
			
			if ($quote_flag) {
				// Check if the last char is quote.
				if (is_quote($last_char)) {
					$quoted_param .= substr($param, 0, strlen($param)-2);
					// Close it.
					$quote_flag = false;
					
					$parameters[] = $quoted_param;
				} else {
					$quoted_param .= $param;
				}
			} else {
				if (is_quote($first_char) && !is_quote($last_char)) {
					$quoted_param = substr($param, 1, strlen($param)-1);
					$quote_flag = true;
				} else {
					$parameters[] = $param;
				}
			}
		}
		
		return $parameters;
	}
}

if ( !function_exists('get_subclass_name') ) {
	/**
	 * Append the subclass prefix to the class name
	 * provided. The prefix was defiend in the
	 * native CodeIgniter's config file:
	 * /config/config.php
	 * 
	 * @param string $class_name
	 * @return string
	 */
	function get_prefix_classname($class_name)
	{
		$CI =& get_instance();
		$prefix = $CI->config->item('subclass_prefix');
		return $prefix . $class_name;
	}
}

if (!function_exists('get_uri_string')) {
	/**
	 * Convert an array to URI string. The array
	 * key will used as the URI parameter name while
	 * the value will used as the URI value.
	 * 
	 * @param array params List of parameters.
	 * @param boolean leading With leading question mark.
	 * @return string
	 */
	function get_uri_string($params, $leading=true)
	{
		$str = ($leading ? '?' : '');
		
		if (iterable($params)) {
			$last_element = end($params);
			
			foreach ($params as $key => $value) {
				$str .= $key . '=' . urlencode($value);
				
				if ($last_element != $value) {
					$str .= '&';
				}
			}
		}
		
		return $str;
	}
}

if (!function_exists('json_decode')) {
	/**
	 * JSON encode/decode-er. This is for earlier version of PHP that
	 * doesn't support JSON. The parameter and usage is exactly the
	 * same as documented in php.net.
	 * 
	 * @param string $value
	 * @param boolean optional $assoc
	 * @param int optional $depth
	 * @param int optional $options
	 */
	function json_decode($value, $assoc=false, $depth=512, $options=0)
	{
		$CI =& get_instance();
		// Load the json library.
		$CI->load->library('Services_JSON');
		
		$options = SERVICES_JSON_SUPPRESS_ERRORS;
		
		if ($assoc) {
			$options = $options | SERVICES_JSON_LOOSE_TYPE;
		}
		
		$json = new Services_JSON($options);
		
		return $json->decode($value);
	}
}

if ( !function_exists('is_empty') ) {
	/**
	 * To test the string whether is empty or not.
	 * @param $str string
	 * @return boolean
	 */
	function is_empty($str)
	{
		if ( $str === null || $str === false || $str === '' ) {
			return true;
		} else {
			return false;
		}
	}
}

if ( !function_exists('is_json') ) {
	/**
	 * To check whether a string is a json encoded
	 * format or not.
	 *
	 * @param string $string
	 * @return boolean
	 */
	function is_json($string) {
		json_decode($string);
		return (json_last_error() == JSON_ERROR_NONE);
	}
}

if ( !function_exists('is_pure_digits') ) {
	/**
	 * Return TRUE if the string is purely
	 * all digits. Useful to determine whether the
	 * associative array key is indexed or not.
	 * 
	 * @param string $string
	 * @return boolean
	 */
	function is_pure_digits($string) {
		return (preg_match('/^\d+$/', $string));
	}
}

if (!function_exists('is_quote')) {
	/**
	 * Just to check if the character is a quote.
	 * 
	 * Dependency: fparam_to_array
	 * 
	 * @param string $str
	 * @return boolean
	 */
	function is_quote($str)
	{
		if (strlen($str) > 0) {
			$str = substr($str, 0, 1);
		}
		if ($str == "'" || $str == '"') {
			return true;
		} else {
			return false;
		}
	}
}

if (!function_exists('json_encode')) {
	/**
	 * JSON encode/decode-er. This is for earlier version of PHP that
	 * doesn't support JSON. The parameter and usage is exactly the
	 * same as documented in php.net.
	 * 
	 * @param mixed $value
	 * @param int optional $options
	 * @return string|boolean
	 */
	function json_encode($value, $options=0)
	{
		$CI =& get_instance();
		// Load the json library.
		$CI->load->library('Services_JSON');
		
		$json = new Services_JSON(SERVICES_JSON_SUPPRESS_ERRORS);
		
		return $json->encode($value);
	}
}

if ( !function_exists('json_output') ) {
	/**
	 * To output json to user browser. There should be no
	 * other output after calling this method.
	 *
	 * @param array $output
	 * @param int optional $header_status
	 * @param string optional $header_status_text
	 * @return null
	 */
	function json_output($output, $header_status = 200, $header_status_text = '')
	{
		$CI =& get_instance();

		$CI->output->set_header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		$CI->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');
		$CI->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
		$CI->output->set_header('Cache-Control: post-check=0, pre-check=0');
		$CI->output->set_header('Pragma: no-cache');
		$CI->output->set_content_type('application/json');
		
		if ( $header_status != 200 ) {
			$CI->output->set_status_header($header_status, $header_status_text);
		}
		
		$CI->output->set_output(json_encode($output));
	}
}

if ( !function_exists('sanitize_filename') ) {
	/**
	 * To sanitize a string to become a valid filename string.
	 * @param string $string
	 * @param boolean $lowercase To specify whether the filename should converted to lowercase.
	 * @return string
	 */
	function sanitize_filename($string, $lowercase=false) {
		$clean_name = strtr($string, 'ŠŽšžŸÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÑÒÓÔÕÖØÙÚÛÜÝàáâãäåçèéêëìíîïñòóôõöøùúûüýÿ', 'SZszYAAAAAACEEEEIIIINOOOOOOUUUUYaaaaaaceeeeiiiinoooooouuuuyy');
		$clean_name = strtr($clean_name, array('Þ' => 'TH', 'þ' => 'th', 'Ð' => 'DH', 'ð' => 'dh', 'ß' => 'ss', 'Œ' => 'OE', 'œ' => 'oe', 'Æ' => 'AE', 'æ' => 'ae', 'µ' => 'u'));
		$clean_name = preg_replace(array('/\s/', '/\.[\.]+/', '/[^\w_\.\-]/'), array('_', '.', ''), $clean_name);
		
		if ( $lowercase ) {
			$clean_name = strtolower($clean_name);
		}
		
		return $clean_name;
	}

}

if ( !function_exists('str_truncate') ) {
	/**
	 * To truncate a string into shorter one and replace the suffix
	 * with the one specified.
	 * 
	 * @param string $string
	 * @param int $length The maximum characters of the string.
	 * @param string optional $suffix
	 * @return string
	 */
	function str_truncate($str, $length, $suffix='...')
	{
		if ( strlen($str) > $length ) {
			$pos = strpos($str, ' ', $length);
			
			if ( false === $pos ) {
				$text = substr($str, 0, $length) . $suffix;
			} else {
				$text = substr($str, 0, $pos) . $suffix;
			}
		} else {
			$text = $str;
		}
		
		return $text;
	}
}

if (!function_exists('ensure_string')) {
	/**
	 * To ensure there will be default value for a string variable
	 * if it is not empty.
	 * @var string $str_varname The string
	 * @var string $def_value The default value if variable not exist.
	 * @return string
	 */
	function string_ensure($str, $def_value='')
	{
		if (is_empty($str)) {
			return $def_value;
		} else {
			return $str;
		}
	}
}

if (!function_exists('string_implode')) {
	/**
	 * Work similar to implode but with additional function which
	 * allow you to wrap the string with some character.
	 */
	function string_implode($glue, $array_str, $wrapper="")
	{
		$CI =& get_instance();
		
		if ( is_empty($wrapper) ) {
			return implode($glue, $array_str);
		} else {
			foreach ($array_str as $i => $str) {
				$array_str[$i] = $wrapper . $str . $wrapper;
			}
			return implode($glue, $array_str);
		}
	}
}

if ( !function_exists('string_replace_var') ) {
	/**
	 * To replace a variables inside the string.
	 *
	 * @param string $str
	 * @param array $vars
	 * @return string
	 */
	function string_replace_var($str, $vars=array())
	{
		if ( iterable($vars) ) {
			foreach ( $vars as $var => $value ) {
				$str = preg_replace("/{$var}/", $value, $str);
			}
		}
		
		return $str;
	}
}

if (!function_exists('strtim')) {
	/**
	 * To trim off the left and right white spaces.
	 * @param string $str
	 * @return string
	 */
	function strtrim($str)
	{
		$str = ltrim($str);
		$str = rtrim($str);
		return $str;
	}
}


if ( !function_exists('time_convert') ) {
	/**
	 * To convert a time unit to a desired output.
	 * 
	 * @param string $time The time string. It can contain mixture of unit and number. Eg: 1day, 3week, 4year.
	 * @param string optional $desired_unit The desired unit output. It can contain a single word: day, week, hour, year.
	 * @param string optional $decimal The number of decimal point. If 2, the output will force to have two decimal points.
	 * @return float|int|string|boolean If parameter 2 was not provided, this function will return a user friendly string. False will be return if the string cannot be converted.
	 */
	function time_convert($time, $desired_unit='', $decimal=0)
	{
		$CI =& get_instance();
		$CI->load->helper('inflector');
		
		$scales = array(
			'second' => 1,
			'minute' => 60,
			'hour' => 60 * 60,
			'day' => 24 * 60 * 60,
			'week' => 7 * 24 * 60 * 60,
			'month' => 30 * 24 * 60 * 60,
			'year' => 365 * 24 * 60 * 60,
		);
		
		$regex = '/^(\d+)(\D+)/';
		
		if ( preg_match($regex, $time, $matches) && iterable($matches) && sizeof($matches) == 3 ) {
			$value = $matches[1];
			$unit = strtolower($matches[2]);
			
			if ( isset($scales[$unit]) ) {
				$scale = $scales[$unit];
				
				$total_seconds = $value * $scale;
				
				if ( !is_empty($desired_unit) && isset($scales[$desired_unit]) ) {
					$output = number_format($total_seconds / $scales[$desired_unit], $decimal, '.', '') + 0;
					return $output;
				} else {
					// Return a friendly string.
					$reverse_scales = array_reverse($scales, true);
					$output = '';
					
					foreach ( $reverse_scales as $scale_name => $scale_value ) {
						if ( ($x = floor($total_seconds / $scale_value)) == 0 ) {
							continue;
						}
						
						if ( $x > 1 ) {
							$scale_name = plural($scale_name);
						}
						
						$output .= $x . ' ' . ucfirst($scale_name) . ' ';
						$total_seconds %= $scale_value;
						break ;
					}
					
					if ( !is_empty($output) ) {
						$output = substr($output, 0, strlen($output) - 1);
					}
					
					return $output;
				}
			}
		}
		
		return false;
	}
}

if ( !function_exists('underscore_to_camelcase') ) {
	/**
	 * Convert strings with underscores into CamelCase
	 *
	 * @param string $string The string to convert
	 * @param bool $first_char_caps camelCase or CamelCase. Default is camelCase
	 * @return string The converted string
	 */
	function underscore_to_camelcase($string, $first_char_caps = false) {
		if( $first_char_caps == true ) {
			$string[0] = strtoupper($string[0]);
		}
	    $func = create_function('$c', 'return strtoupper($c[1]);');
	    return preg_replace_callback('/_([a-z])/', $func, $string);
	}
}