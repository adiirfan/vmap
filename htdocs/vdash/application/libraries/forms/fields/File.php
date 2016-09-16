<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Field.php');

/**
 * File Upload Class
 * Allowed user to upload file via this input.
 * You can specify the upload location and move the uploaded file
 * to the desired folder location.
 * 
 * You can check the availability of the location first before
 * upload.
 * 
 * This class has internal validation rules where it can validate
 * the filesize uploaded and also the file format (extension) of
 * the uploaded file.
 * 
 * @author kflee
 */
class File extends Field {
	/**
	 * A list of allowed file mime types. Wildcare allowed.
	 * Eg.: image/*, video/*, application/*
	 * Or you can provide exact mime type:
	 * image/png, image/jpg
	 * 
	 * Please refer to http://www.freeformatter.com/mime-types-list.html
	 * 
	 * @var array
	 */
	protected $_allowed_filetypes = array();
	
	/**
	 * The destination path where the uploaded file
	 * should save to.
	 * 
	 * @var string
	 */
	protected $_dest_path = '';
	
	/**
	 * The maximum filesize allowed for this upload.
	 * This can be the filesize in different format.
	 * Eg: 100KB, 2044B, 2MB, 1GB and so on.
	 * 
	 * Use 0 to specify unlimited.
	 * 
	 * @var string
	 */
	protected $_max_filesize = 0;
	
	/**
	 * To specify whether the filename should be
	 * sanitized before moving to the destination
	 * location. By default, it was set to TRUE.
	 * 
	 * @var boolean
	 */
	protected $_sanitize_filename = true;
	
	/**
	 * The value consists of the standard CGI
	 * postback value:
	 * name - The filename with extension.
	 * type - The MIME type.
	 * tmp_name - The temporary path to the file. Or the absolute path to the file.
	 * error - The error code.
	 * size - The filesize in bytes.
	 * 
	 * @var array
	 */
	protected $_value = array();
	
	/**
	 * To check all constraint specified in this
	 * File object. If the upload is having error,
	 * it will return error message as well. 
	 * 
	 * @param array $value
	 * @param string $error_message
	 * @return boolean
	 */
	public function constraint_check($value, &$error_message)
	{
		if ( iterable($value) ) {
			$error_code = array_ensure($value, 'error', false);
			
			if ( false !== $error_code ) {
				$err_msg = array(
					UPLOAD_ERR_INI_SIZE => '_form_error_file_ini_size',
					UPLOAD_ERR_FORM_SIZE => '_form_error_file_form_size',
					UPLOAD_ERR_PARTIAL => '_form_error_file_partial',
					UPLOAD_ERR_NO_TMP_DIR => '_form_error_file_no_tmp_dir',
					UPLOAD_ERR_CANT_WRITE => '_form_error_file_cant_write',
				);
				
				if ( isset($err_msg[$error_code]) ) {
					$error_messages[] = lang($err_msg[$error_code]);
					
					return false;
				} elseif ( $error_code == UPLOAD_ERR_OK ) {
					// Let's set the value to the file object first.
					$this->set_value($value);
					
					// Check filesize and file extension.
					if ( false === $this->_val_filesize($this, array(), $error_message) ) {
						$this->_value = array();
						return false;
					}
					
					if ( false === $this->_val_filetype($this, array(), $error_message) ) {
						$this->_value = array();
						return false;
					}
				}
			}
		}
		
		return true;
	}
	
	/**
	 * Return the list of allowed filetypes.
	 * 
	 * @return array
	 */
	public function get_allowed_filetypes()
	{
		return $this->_allowed_filetypes;
	}
	
	/**
	 * Return the destination path.
	 * 
	 * @return string
	 */
	public function get_dest_path()
	{
		return $this->_dest_path;
	}
	
	/**
	 * Return the file extension without dot.
	 * 
	 * @return string
	 */
	public function get_extension()
	{
		if ( !$this->is_empty() ) {
			$filename = $this->get_value('name');
			
			$path_info = pathinfo($filename);
			
			return array_ensure($path_info, 'extension', false);
		} else {
			return false;
		}
	}
	
	/**
	 * Return the filesize in desired unit.
	 * It will return FALSE if there are no 
	 * file uploaded.
	 * 
	 * @param string $unit Can be B, KB, MB, GB
	 * @return float
	 */
	public function get_filesize($unit = 'KB')
	{
		if ( !$this->is_empty() ) {
			$size = $this->get_value('size');
			
			return filesize_convert($size, $unit);
		} else {
			return false;
		}
	}
	
	/**
	 * Return the maximum allowed upload size for
	 * this upload. You can specify the unit of the
	 * value to be returned. By default, it will
	 * return in Bytes.
	 * 
	 * @param string $unit
	 * @param int $decimal
	 * @return float
	 */
	public function get_max_filesize($unit = 'B', $decimal = 0)
	{
		return filesize_convert($this->_max_filesize, $unit, $decimal);
	}
	
	/**
	 * Get the filename sanitize feature status. 
	 * 
	 * @return boolean
	 */
	public function get_sanitize_filename()
	{
		return $this->_sanitize_filename;
	}
	
	/**
	 * Return the value/attribute of the file.
	 * The attribute has to be either these name:
	 * name - The filename with extension.
	 * type - The MIME type.
	 * tmp_name - The temporary path to the file. Or the absolute path to the file.
	 * error - The error code.
	 * size - The filesize in bytes.
	 * 
	 * It will return FALSE if the attribute name
	 * not found.
	 * 
	 * @param string optional $attr
	 * @return mixed
	 */
	public function get_value($attr = '')
	{
		if ( is_empty($attr) ) {
			return $this->_value;
		} else {
			return array_ensure($this->_value, $attr, false);
		}
	}
	
	/**
	 * Check if the field's value is empty.
	 * 
	 * @return boolean
	 */
	public function is_empty()
	{
		$error_code = $this->get_value('error');
		
		if ( false === $error_code ) {
			return true;
		} elseif ( $error_code == UPLOAD_ERR_NO_FILE ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Return TRUE if the file size has exceeded the
	 * specified limit.
	 * 
	 * @return boolean
	 */
	public function is_filesize_exceeded()
	{
		// If no limit specified, no need to check.
		if ( $this->_max_filesize === 0 ) {
			return false;
		}
		
		$max_size = $this->get_max_filesize('B');
		$filesize = $this->get_value('size');
		
		if ( $filesize > $max_size ) {
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * To check if the uploaded file is a valid
	 * types.
	 * 
	 * @return boolean
	 */
	public function is_filetype_valid()
	{
		if ( !iterable($this->_allowed_filetypes) ) {
			// No filetypes specified, just return true and proceed.
			return true;
		}
		
		$file_path = $this->get_value('tmp_name');
		$filename = $this->get_value('name');
		
		if ( !is_empty($file_path) && file_exists($file_path) ) {
			// Get the MIME.
			$finfo = new finfo(FILEINFO_MIME);
			$mime_type = $finfo->file($file_path);
			$mime_type = preg_split('/\; /', $mime_type);
			
			if ( iterable($mime_type) && sizeof($mime_type) == 2 ) {
				$mime_type = $mime_type[0];
				
				foreach ( $this->_allowed_filetypes as $file_type ) {
					$file_type = str_replace('/', '\/', $file_type);
					$file_type_regex = '/' . str_replace('*', '.*', $file_type) . '/';
					
					if ( preg_match($file_type_regex, $mime_type) ) {
						return true;
					}
				}
			}
		}
		
		return false;
	}
	
	/**
	 * Custom error message for file when there is
	 * no file uploaded.
	 * 
	 * @return string
	 */
	public function on_errmsg_required()
	{
		return lang('_form_error_file_empty');
	}
	
	/**
	 * To save the uploaded file to the destination path.
	 * The filename can be change at this point where you
	 * can specify it using the token available here
	 * (Note: the filename must contain the extension value as well)
	 * %filename% - The basename without extension.
	 * %basename% - The original full filename including the extension.
	 * %extension% - The extension name without dot.
	 * %date_{date token}% - The date value from th PHP date function. The date token can be any available
	 *     character from here : http://es1.php.net/manual/en/function.date.php
	 *     eg: %date_d% - 04, %date_F% - February
	 * %timestamp% - The UNIX timestamp.
	 * %filesize_{unit}% - The filesize. Can specify the unit name on {unit}.
	 * 
	 * If filename was not provided, the default uploaded filename will be used.
	 * 
	 * This function will return the filename of the saved file. Or it will return
	 * FALSE if upload failed.
	 * 
	 * @param string optional $filename
	 * @return string
	 */
	public function save($filename = '')
	{
		if ( !$this->is_empty() ) {
			if ( !is_empty($filename) ) {
				log_message('info', 'Filename pattern: ' . $filename);
				
				$path_info = pathinfo($this->get_value('name'));
				$uploaded_filename = $path_info['filename'];
				$uploaded_extension = $path_info['extension'];
				$uploaded_basename = $path_info['basename'];
				$uploaded_filesize = $this->get_value('size');
				$timestamp = time();
				
				// Replace the basic one.
				$replacements = array(
					'filename' => $uploaded_filename,
					'basename' => $uploaded_basename,
					'extension' => $uploaded_extension,
					'timestamp' => $timestamp,
				);
				
				foreach ( $replacements as $token => $value ) {
					$filename = preg_replace('/\%' . $token . '\%/', $value, $filename);
				}
				
				// Replace date token.
				preg_match('/\%date_([^\%]+)\%/', $filename, $matches);
				if ( sizeof($matches) == 2 ) {
					$date_format = $matches[1];
					// Translate it to date string.
					$date_output = date($date_format, $timestamp);
					
					$filename = preg_replace('/\%date_[^\%]+\%/', $date_output, $filename);
				}
				
				// Replace filesize unit.
				preg_match('/\%filesize_([^\%]+)\%/', $filename, $filesize_matches);
				if ( sizeof($filesize_matches) == 2 ) {
					$unit = $filesize_matches[1];
					$filesize_output = filesize_convert($uploaded_filesize . 'B', $unit);
					
					$filename = preg_replace('/\%filesize_[^\%]+\%/', $filesize_output, $filename);
				}
			} else {
				// Use defualt filename.
				$filename = $this->get_value('name');
			}
			
			if ( $this->_sanitize_filename ) {
				$filename = sanitize_filename($filename);
			}
			
			log_message('info', 'Generated filename: '. $filename);
			
			// Now let's move the uploaded file to new location.
			$dest_path = $this->_dest_path . DIRECTORY_SEPARATOR . $filename;
			if ( move_uploaded_file($this->get_value('tmp_name'), $dest_path) ) {
				// Update the filename.
				$this->set_value($dest_path);
				
				return $filename;
			}
		}
		
		return false;
	}
	
	/**
	 * To set a single allowed filetype.
	 * 
	 * @param string $mime Please refer to the list here http://www.freeformatter.com/mime-types-list.html
	 * @param string $extension Without prefix dot.
	 * @return null
	 */
	public function set_allowed_filetype($mime, $extension)
	{
		if ( !isset($this->_allowed_filetypes[$mime]) ) {
			$this->_allowed_filetypes[$mime] = $extension;
		} else {
			// Make sure it was not duplicated.
			$new_extensions = preg_split('/\,/', $extension);
			$curr_extensions = preg_split('/\,/', $this->_allowed_filetypes[$mime]);
			
			if ( iterable($new_extensions) ) {
				foreach ( $new_extensions as $new_ext ) {
					if ( !in_array($new_ext, $curr_extensions) ) {
						$this->_allowed_filetypes[$mime] .= ',' . $new_ext;
						
						$curr_extensions[] = $new_ext;
					}
				}
			}
		}
	}
	
	/**
	 * To set multiple allowed filetypes at one go.
	 * The array key will be the MIME type and the
	 * value will be the extension without prefix
	 * dot.
	 * 
	 * @param array $types
	 * @return null
	 */
	public function set_allowed_filetypes($types)
	{
		if ( iterable($types) ) {
			foreach ( $types as $mime => $ext ) {
				$this->set_allowed_filetype($mime, $ext);
			}
		}
	}
	
	/**
	 * To set the destination path for upload files.
	 * 
	 * @param string $path
	 * @return null
	 */
	public function set_dest_path($path)
	{
		if ( !file_exists($path) || !is_writable($path) ) {
			show_error(sprintf(lang('_error_form_field_dest_path_not_found'), $path), 500);
			log_message('error', 'Unable to set the upload destination path: ' . $path);
		}
		
		$this->_dest_path = $path;
	}
	
	/**
	 * Set the maximum filesize for the file upload. It
	 * can be combination of value and the unit name.
	 * Eg: 100KB, 2MB, 1GB or 1699B.
	 * 
	 * @param string $max_filesize
	 * @return null
	 */
	public function set_max_filesize($max_filesize)
	{
		$this->_max_filesize = $max_filesize;
	}
	
	/**
	 * Toggle filename sanitize feature features.
	 * 
	 * @param boolean $sanitize
	 * @return null
	 */
	public function set_sanitize_filename($sanitize)
	{
		$this->_sanitize_filename = ($sanitize ? true : false);
	}
	
	/**
	 * To set the upload value. If string was provided,
	 * this method will assume it was the file path. If
	 * the file path correct, this method will initialize
	 * the value with the file attributes automatically.
	 * The tmp_name will be the aboslute path to the file.
	 * 
	 * @param array|string $val
	 * @return null
	 */
	public function set_value($val)
	{
		if ( iterable($val) ) {
			$value = array(
				'name' => array_ensure($val, 'name', ''),
				'type' => array_ensure($val, 'type', ''),
				'tmp_name' => array_ensure($val, 'tmp_name', ''),
				'error' => array_ensure($val, 'error', ''),
				'size' => array_ensure($val, 'size', ''),
			);
			
			parent::set_value($value);
		} elseif ( gettype($val) == "string" ) {
			if ( file_exists($val) ) {
				$value = array();
				$finfo = new finfo(FILEINFO_MIME);
				$path_info = pathinfo($val);
				
				$value['name'] = $path_info['basename'];
				$mime_type = $finfo->file($val);
				$mime_type = preg_split('/; /', $mime_type);
				$value['type'] = $mime_type[0];
				$value['tmp_name'] = $val;
				$value['error'] = '';
				$value['size'] = filesize($val);
				
				parent::set_value($value);
			}
		}
	}
	
	/**
	 * To validate th filesize of the uploaded file.
	 * 
	 * @param File $field
	 * @param array optional $options
	 * @param string optional $error_message
	 * @param boolean optional $stop
	 * @return boolean
	 */
	protected function _val_filesize($field, $options = array(), &$error_message = '', &$stop = false)
	{
		// If the upload was failed or no file uploaded, this validation should not proceed.
		if ( !iterable($this->_value) || $this->get_value('error') != UPLOAD_ERR_OK ) {
			return true;
		}
		
		if ( $field->is_filesize_exceeded() ) {
			$error_message = sprintf(lang('_form_error_file_size_exceeded'),
				$this->get_max_filesize('B'),
				$this->get_max_filesize('KB', 2),
				$this->get_max_filesize('MB', 2)
			);
			return false;
		} else {
			return true;
		}
	}
	
	/**
	 * To validate the uploaded file types.
	 * 
	 * @param File $field
	 * @param array optional $options
	 * @param string optional $error_message
	 * @param boolean optional $stop
	 * @return boolean
	 */
	protected function _val_filetype($field, $options = array(), &$error_message = '', &$stop = false)
	{
		$stop = true;
		
		// If the upload was failed or no file uploaded, this validation should not proceed.
		if ( !iterable($this->_value) || $this->get_value('error') != UPLOAD_ERR_OK ) {
			return true;
		}
		
		if ( $field->is_filetype_valid() ) {
			return true;
		} else {
			$error_message = lang('_form_error_file_invalid_type');
			return false;
		}
	}
}