<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/File.php');
require_once(APPPATH . '/external_libraries/resize-class.php');

/**
 * Picture Upload Class
 * 
 * Beside, it automatically restrict the upload file
 * type to standard image types only: gif, jpg, jpeg, png.
 * 
 * @author kflee
 */
class Picture extends File {
	/**
	 * The height of the uploaded picture. If
	 * 0 was assigned, the original height will
	 * be used.
	 * 
	 * @var int
	 */
	protected $_height = 0;
	
	/**
	 * The picture resize method if either width 
	 * or height has been specified (non zero value).
	 * Available options:
	 * + auto (depending on the picture size and the preview size)
	 * + crop (exact size without running off the propotion)
	 * + exact (resize exactly)
	 * + landscape (respective to the width)
	 * + portrait (respective to the height)
	 * 
	 * @var string
	 */
	protected $_resize_option = 'crop';
	
	/**
	 * Whether to generate thumbnail on the uploaded
	 * picture.
	 * 
	 * @var boolean
	 */
	protected $_thumbnail = false;
	
	/**
	 * The thumbnail creation folder that relative
	 * to the dest_path. By default, thumbs
	 * 
	 * @var string
	 */
	protected $_thumbnail_dest_path = 'thumbs';
	
	/**
	 * The thumbnail height.
	 * 
	 * @var int
	 */
	protected $_thumbnail_height = 100;
	
	/**
	 * The thumbnail resize method. 
	 * Available options:
	 * + auto (depending on the picture size and the preview size)
	 * + crop (exact size without running off the propotion)
	 * + exact (resize exactly)
	 * + landscape (respective to the width)
	 * + portrait (respective to the height)
	 * 
	 * @var string
	 */
	protected $_thumbnail_resize_option = 'crop';
	
	/**
	 * The thumbnail width.
	 * 
	 * @var int
	 */
	protected $_thumbnail_width = 100;
	
	/**
	 * The width of the picture. If 0 was assigned,
	 * the original width will be used.
	 * 
	 * @var int
	 */
	protected $_width = 0;
	
	public function init()
	{
		$this->set_allowed_filetypes(array(
			'image/jpeg' => 'jpg,jpeg',
			'image/png' => 'png',
			'image/gif' => 'gif',
		));
		
		$this->_CI->template->set_js('!/js/form.picture.js');
	}
	
	/**
	 * Return the original picture height. If 0
	 * was returned, it mean no picture size
	 * specified.
	 * 
	 * @return int
	 */
	public function get_height()
	{
		return $this->_height;
	}
	
	/**
	 * Get the picture resize option.
	 * 
	 * @return string
	 */
	public function get_resize_option()
	{
		return $this->_resize_option;
	}
	
	/**
	 * Return TRUE if thumbnail creation has turned on.
	 * 
	 * @return boolean
	 */
	public function get_thumbnail()
	{
		return $this->_thumbnail;
	}
	
	/**
	 * Return the thumbnail creation path. This
	 * is relative to the dest_path.
	 * 
	 * @return string
	 */
	public function get_thumbnail_dest_path()
	{
		return $this->_thumbnail_dest_path;
	}
	
	/**
	 * Return the thumbnail height.
	 * 
	 * @return int
	 */
	public function get_thumbnail_height()
	{
		return $this->_thumbnail_height;
	}
	
	/**
	 * Return the thumbnail resize option.
	 * 
	 * @return string
	 */
	public function get_thumbnail_resize_option()
	{
		return $this->_thumbnail_resize_option;
	}
	
	/**
	 * Return the thumbnail width.
	 * 
	 * @return int
	 */
	public function get_thumbnail_width()
	{
		return $this->_thumbnail_width;
	}
	
	/**
	 * Return the thumbnail URL. If the field has
	 * no thumbnail, FALSE will be returned.
	 * 
	 * @return string
	 */
	public function get_thumbnail_url()
	{
		if ( $this->_thumbnail && false !== ($filename = $this->get_value('name')) ) {
			// Get the path to the thumbnail folder.
			$thumb_path = $this->_dest_path . '/' . $this->_thumbnail_dest_path . '/' . $filename;
			
			if ( file_exists($thumb_path) ) {
				return base_url($thumb_path);
			}
		}
		
		return false;
	}
	
	/**
	 * Return the picture width
	 * 
	 * @return int
	 */
	public function get_width()
	{
		return $this->_width;
	}
	
	/**
	 * Overriding the parent save method. This will handle the
	 * resize and thumbnail creation.
	 * 
	 * @param string optional $filename
	 * @return boolean|string
	 */
	public function save($filename = '')
	{
		if ( false !== ($source_file = parent::save($filename)) ) {
			// Make it an relative path from the root directory.
			$source_path = $this->_dest_path . DIRECTORY_SEPARATOR . $source_file;
			
			// Image resize.
			$width = $this->get_width();
			$height = $this->get_height();
			
			if ( $width > 0 || $height > 0 ) {
				$resize = new resize($source_path);
				$resize->resizeImage($width, $height, $this->get_resize_option());
				$resize->saveImage($source_path);
			}
			
			// Thumbnail creation.
			if ( $this->_thumbnail ) {
				// Create thumbnail.
				
				// The resize object.
				$resize = new resize($source_path);
				$resize->resizeImage($this->get_thumbnail_width(), $this->get_thumbnail_height(), $this->get_thumbnail_resize_option());
				
				$dest_path = $this->_dest_path . DIRECTORY_SEPARATOR . $this->_thumbnail_dest_path . DIRECTORY_SEPARATOR . $source_file;
				
				$resize->saveImage($dest_path);
			}
			
			return $source_file;
		} else {
			return false;
		}
	}
	
	/**
	 * To set the picture height to be resize.
	 * Use 0 to use default image size.
	 * 
	 * @param int $height
	 * @return null
	 */
	public function set_height($height)
	{
		$this->_height = intval($height);
	}
	
	/**
	 * Set the resize option.
	 * 
	 * @param string $resize
	 * @return null
	 */
	public function set_resize_option($resize)
	{
		$this->_resize_option = $this->_ensure_resize_option($resize);
	}
	
	/**
	 * To toggle the thumbnail creation feature.
	 * 
	 * @param boolean $thumbnail
	 * @return null
	 */
	public function set_thumbnail($thumbnail)
	{
		$this->_thumbnail = ($thumbnail ? true : false);
	}
	
	/**
	 * Set the thumbnail creation path. This is
	 * relative to the dest_path.
	 * 
	 * @param string $pattern
	 * @return null
	 */
	public function set_thumbnail_dest_path($path)
	{
		$this->_thumbnail_dest_path = $path;
	}
	
	/**
	 * Set the thumbnail height.
	 * 
	 * @param int $height
	 */
	public function set_thumbnail_height($height)
	{
		$this->_thumbnail_height = intval($height);
	}
	
	/**
	 * Set the thumbnail resize option.
	 * 
	 * @param string $resize
	 * @return null
	 */
	public function set_thumbnail_resize_option($resize)
	{
		$this->_thumbnail_resize_option = $this->_ensure_resize_option($resize);
	}
	
	/**
	 * Set the thubmnail width
	 * 
	 * @param int $width
	 * @return null
	 */
	public function set_thumbnail_width($width)
	{
		$this->_thumbnail_width = intval($width);
	}
	
	/**
	 * Set the picture width
	 * 
	 * @param int $width
	 * @return null
	 */
	public function set_width($width)
	{
		$this->_width = intval($width);
	}
	
	/**
	 * To ensure the option that provided was a valid option.
	 * By default, auto was used and this default can be
	 * override on the second parameter.
	 * 
	 * @param string $option
	 * @param string $default
	 * @return string
	 */
	protected function _ensure_resize_option($option, $default = 'auto')
	{
		$available_options = array(
			'auto',
			'crop',
			'exact',
			'landscape',
			'portrait',
		);
		
		$option = strtolower($option);
		
		if ( in_array($option, $available_options) ) {
			return $option;
		} else {
			$default = strtolower($default);
			
			if ( in_array($default, $available_options) ) {
				return $default;
			} else {
				return 'auto';
			}
		}
	}
}