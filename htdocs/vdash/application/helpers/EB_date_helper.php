<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( !function_exists('db_date') )
{
	/**
	 * Return the default date format for the database.
	 * 
	 * @param string|int optional $date The specified date. If not specified, current date/time will be returned
	 * @param boolean optional $date_onyl The specified whether to return date only. By default, date/time.
	 * @return string
	 */
	function db_date($date = false, $date_only = false)
	{
		if ( !$date ) {
			$date = time();
		} else {
			if ( !is_numeric($date) ) {
				$date = strtotime($date);
			}
			
			if ( $date === false ) {
				$date = time();
			}
		}
		
		// Check whether is date only format.
		if ( $date_only ) {
			$format = 'Y-m-d';
		} else {
			$format = 'Y-m-d H:i:s';
		}
		
		return date($format, $date);
	}
}

if ( !function_exists('is_valid_date') ) {
	/**
	 * To check whether the date string is in valid format
	 * 
	 * @param string $string
	 * @return boolean
	 */
	function is_valid_date($string)
	{
		return (strtotime($string) !== false);
	}
}

if ( !function_exists('user_date') ) {
	/**
	 * Return a user friendly date string.
	 * 
	 * @param string $date
	 * @param string optional $format
	 * @return string
	 */
	function user_date($date, $format = 'j/n/Y')
	{
		$datetime = false;
		
		if ( !is_pure_digits($date) ) {
			$datetime = strtotime($date);
		} else {
			$datetime = $date;
		}
		
		if ( false !== $datetime ) {
			return date($format, $datetime);
		} else {
			return false;
		}
	}
}