<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('array_all_keys') ) {
	/**
	 * This function return all array's keys including the sub element.
	 * It will recursively go through each element and return the
	 * sub key into a single dimension array.
	 * 
	 * @param array $arry
	 * @return array
	 */
	function array_all_keys($arry)
	{
		$result = array();
		
		if ( iterable($arry) ) {
			foreach ( $arry as $key => $val ) {
				if ( iterable($val) ) {
					$sub_key = array_all_keys($val);
					
					$result[] = $key;
					$result = array_merge($result, $sub_key);
				} else {
					$result[] = $key;
				}
			}
		}
		
		return $result;
	}
}

if (!function_exists('array_ensure')) {
	/**
	 * To ensure the key search from the array has a default
	 * value.
	 * @param array $array The array being search from.
	 * @param string $key The key of the array.
	 * @param mixed $default The default value if the key doesn't present or no value.
	 * @return mixed
	 */
	function array_ensure($array, $key, $default='')
	{
		if (is_array($array)) {
			if (isset($array[$key])) {
				return $array[$key];
			} else {
				return $default;
			}
		} else {
			return $default;
		}
	}
}

if (!function_exists('iterable')) {
	/**
 	 * To check whether the array is iterable or not. To save resource before
	 * going to a foreach loop.
	 * @param array $array
	 * @return boolean
	 */
	function iterable($array)
	{
		if (is_array($array) && sizeof($array) > 0) {
			return true;
		} elseif ( $array instanceof Iterator ) {
			$tmp_array = clone $array;
			
			$tmp_array->rewind();
			
			if ( $tmp_array->valid() ) {
				return true;
			}
		}
		
		return false;
	}
}

if ( !function_exists('array_first') ) {
	/**
	 * Return the first element of an array.
	 * 
	 * @param array $arry
	 * @return mixed
	 */
	function array_first($arry)
	{
		$arry = array_values($arry);
		return array_shift($arry);
	}
}

if ( !function_exists('array_key_camelcase') ) {
	/**
	 * Convert all keys in an array to camelcase.
	 * It will convert those underscores to camelcase
	 * string. It's suitable for json response.
	 * 
	 * @param array $array
	 * @return array
	 */
	function array_key_camcelcase($array)
	{
		$c_array = array();
		
		if ( iterable($array) ) {
			foreach ( $array as $key => $val ) {
				$c_key = underscore_to_camelcase($key);
				
				if ( iterable($val) ) {
					$c_array[$c_key] = array_key_camcelcase($val);
				} else {
					$c_array[$c_key] = $val;
				}
			}
		}
		
		return $c_array;
	}
}

if ( !function_exists('array_path') ) {
	/**
	 * Return multidimension array based on a path string.
	 * Eg: level_1/level_2/level_3
	 * It will return FALSE if the path is not found.
	 * 
	 * @param array $array
	 * @param string $path
	 * @return mixed
	 */
	function array_path($array, $path)
	{
		$path_segments = preg_split('/\\//', $path);
		
		if ( sizeof($path_segments) > 1 ) {
			$current_array =& $array;
			$prev_array = null;
			
			foreach ( $path_segments as $p ) {
				if ( iterable($current_array) && isset($current_array[$p]) ) {
					$prev_array =& $current_array;
					$current_array =& $current_array[$p];
				} else {
					return false;
				}
			}
			
			if ( null !== $prev_array ) {
				return $prev_array[$p];
			}
		} else {
			return array_ensure($array, path, false);
		}
	}
}

if ( !function_exists('array_path_unset') ) {
	/**
	 * Unset the array element based on the specified path.
	 * 
	 * @param array $array This array is passed by reference.
	 * @param string $path
	 * @return boolean TRUE on succeed.
	 */
	function array_path_unset(&$array, $path)
	{
		$path_segments = preg_split('/\\//', $path);
		
		if ( sizeof($path_segments) > 1 ) {
			$current_array =& $array;
			$prev_array = null;
			
			foreach ( $path_segments as $p ) {
				if ( iterable($current_array) && isset($current_array[$p]) ) {
					$prev_array =& $current_array;
					$current_array =& $current_array[$p];
				} else {
					return false;
				}
			}
			
			if ( null !== $prev_array ) {
				unset($prev_array[$p]);
				return true;
			}
		} else {
			unset($array[$path]);
			return true;
		}
	}
}

if ( !function_exists('array_path_set') ) {
	/**
	 * To set/append a value to an array based on the path
	 * specified. It will override the element if it already
	 * exists.
	 * 
	 * @param array $array Array passed by reference.
	 * @param string $path The path separated by slash. Eg: path1/path2
	 * @param mixed $value The value to be set or replace the array element
	 * @return null
	 */
	function array_path_set(&$array, $path, $value)
	{
		$path_segments = preg_split('/\\//', $path);
		
		if ( sizeof($path_segments) > 1 ) {
			$current_array =& $array;
			$last_node = end($path_segments);
			
			foreach ( $path_segments as $p ) {
				if ( $p == $last_node ) {
					$element = $value;
				} else {
					if ( isset($current_array[$p]) ) {
						$element = $current_array[$p];
					} else {
						$element = array();
					}
				}
				
				$current_array[$p] = $element;
				$current_array =& $current_array[$p];
			}
		} else {
			$array[$path] = $value;
		}
	}
}