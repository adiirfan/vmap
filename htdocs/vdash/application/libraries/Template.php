<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/EB_Library.php');

/**
 * Template Class
 * 
 * @version 2.0
 */
class Template extends EB_Library {
	
	/**
	 * The charset for the HTML document.
	 * Default is latin alphabet, ISO-8859-1.
	 * If you wished to use other character
	 * such as Chinese, please change it to UTF-8
	 * 
	 * @var string
	 */
	protected $_charset = 'ISO-8859-1';
	
	/**
	 * The content script. It can contain sub
	 * folder separated by a slash.
	 * Eg: folder_1/myscript (without .php extension)
	 * 
	 * @var string
	 */
	protected $_content = '';
	
	/**
	 * The list of loaded CSS files.
	 * 
	 * @var array
	 */
	protected $_css = array();
	
	/**
	 * The index script file relative to the theme root directory.
	 * By default, this is index. Please insert without the .php
	 * extension.
	 * 
	 * @var string
	 */
	protected $_index_script = 'index';
	
	/**
	 * The list of loaded javascripts.
	 * 
	 * @var array
	 */
	protected $_js = array();
	
	/**
	 * The layout used on current request. If this
	 * is empty, no layout will be used, the default
	 * theme layout will be used.
	 * 
	 * @var string
	 */
	protected $_layout = '';
	
	/**
	 * Turn on/off the template mode. If this is FALSE,
	 * the template class will display only the content
	 * without layout and the template script (index.php)
	 * 
	 * @var boolean
	 */
	protected $_load_template = true;
	
	/**
	 * The meta elements in the html page.
	 * The key will be used in the "name" 
	 * attribute while the value will used
	 * in the "content" attribute.
	 * 
	 * @var array
	 */
	protected $_meta = array();
	
	/**
	 * This variable will override the default page
	 * title autoload feature. This value will be used
	 * as the page title instead of the language file.
	 * 
	 * @var string
	 */
	protected $_page_title = '';
	
	/**
	 * To auto load the page title using the
	 * language file: page_title_lang.php
	 * The language key will be the current
	 * controller & action name.
	 * Eg: $lang['controller/action'] = '';
	 * 
	 * To turn off this feature, set it to FALSE.
	 * 
	 * @var boolean
	 */
	protected $_page_title_autoload = true;
	
	/**
	 * The prefix for the page title.
	 * 
	 * @var string
	 */
	protected $_page_title_prefix;
	
	/**
	 * The suffix for the page title.
	 * 
	 * @var string
	 */
	protected $_page_title_suffix;
	
	/**
	 * The theme name. All themes should stored
	 * in the /views/themes/ folders. Theme name
	 * should be lowercase and separated by underscore.
	 * Eg: orange, purple, navy_blue
	 * 
	 * @var string
	 */
	protected $_theme = 'default';
	
	public function init()
	{
		$this->_CI->load->language('page_title');
	}
	
	/**
	 * Clear the CSS that has been added
	 * to the page.
	 * 
	 * @return null
	 */
	public function clear_css()
	{
		$this->_css = array();
	}
	
	/**
	 * Clear the JS that has been added
	 * to the page.
	 * 
	 * @return null
	 */
	public function clear_js()
	{
		$this->_js = array();
	}
	
	/**
	 * Clear the meta data that has been
	 * added to the page.
	 * 
	 * @return null
	 */
	public function clear_meta()
	{
		$this->_meta = array();
	}
	
	/**
	 * To compile the page and display the output.
	 * Passing TRUE to the second parameter will
	 * return the output text instead of printing
	 * on the screen.
	 * 
	 * @param array optional $data The data to be shown on your page.
	 * @param boolean optional $return
	 * @return string|null
	 */
	public function display($data = false, $return = false)
	{
		// Compile the content first.
		$content = '';
		
		if ( !is_empty($this->_content) ) {
			$content_script = $this->get_view_path($this->_content);
			
			if ( false !== $content_script ) {
				$content = $this->_CI->load->view($content_script, $data, true);
			} else {
				log_message('error', 'Unable to locate the content view script: ' . $this->_content);
			}
		}
		
		// Check if template will be loaded.
		if ( !$this->_load_template ) {
			$content = $this->get_base_url($content);
			
			if ( $return ) {
				return $content;
			} else {
				$this->_CI->output->set_output($content);
				return ;
			}
		}
		
		// Compile the layout with the content.
		$layout = '';
		
		if ( !is_empty($this->_layout) ) {
			$layout_script = $this->get_theme_path() . '/layouts/' . $this->_layout;
			$layout_script_realpath = APPPATH . 'views/' . $layout_script . '.php';
			
			if ( file_exists($layout_script_realpath) ) {
				// Prepare the layout data.
				$layout_data = array(
					'page_data' => $data,
					'content' => $content,
				);
				
				$layout = $this->_CI->load->view($layout_script, $layout_data, true);
			} else {
				log_message('error', 'Layout view script not found: ' . $this->_layout);
			}
		}
		
		// Get the template index.php and compile with the layout/content.
		$template_script = $this->get_theme_path() . '/' . $this->_index_script;
		$template_script_realpath = APPPATH . 'views/' . $template_script . '.php';
		
		if ( file_exists($template_script_realpath) ) {
			$template_data = array(
				'page_data' => $data,
				'html_header' => $this->html_header(),
				'content' => (is_empty($layout) ? $content : $layout),
			);
			
			$output = $this->_CI->load->view($template_script, $template_data, true);
			
			// Convert the token character to base/absolute URL.
			$output = $this->get_base_url($output);
			
			if ( $return ) {
				return $output;
			} else {
				$this->_CI->output->set_output($output);
			}
		} else {
			log_message('error', 'Unable to find the index.php in the theme folder: ' . $this->get_theme_path());
			show_error(sprintf(lang('_error_tmp_index_not_found'), $this->get_theme_path()));
		}
	}
	
	/**
	 * To convert a string to absolute path.
	 * Two types of token can be converted: ~/ and !/
	 * ~/ : To replace it with theme path.
	 * !/ : To replace it with web base path.
	 * 
	 * @param string $content
	 * @return string
	 */
	public function get_base_url($content)
	{
		// Replace ~/ with the theme home directory.
		$theme_path = base_url('/' . $this->get_theme_path()) . '/';
		$str = preg_replace('/\~\//', $theme_path, $content);
		// Replace // with the base url.
		$base_url = base_url('/');
		$str = preg_replace('/\!\//', $base_url, $str);
		
		return $str;
	}
	
	/**
	 * Return the character set used in the html
	 * page.
	 * 
	 * @return string
	 */
	public function get_charset()
	{
		return $this->_charset;
	}
	
	/**
	 * Return the content of the page.
	 * 
	 * @return string
	 */
	public function get_content()
	{
		return $this->_content;
	}
	
	/**
	 * Return the list of css loaded in
	 * the current page.
	 *
	 * @return array
	 */
	public function get_css()
	{
		return $this->_css;
	}
	
	/**
	 * Return the index script name. This value does
	 * not include the .php extension.
	 * 
	 * @return string
	 */
	public function get_index_script()
	{
		return $this->_index_script;
	}
	
	/**
	 * Return the list of javascript loaded in
	 * the current page.
	 * 
	 * @return array
	 */
	public function get_js()
	{
		return $this->_js;
	}
	
	/**
	 * Return the layout script name.
	 * 
	 * @return string
	 */
	public function get_layout()
	{
		return $this->_layout;
	}
	
	/**
	 * Check if template will be loaded together
	 * with content.
	 * 
	 * @return boolean
	 */
	public function get_load_template()
	{
		return $this->_load_template;
	}
	
	/**
	 * Return the meta content of the page.
	 * If no value was specified on the 
	 * first parameter, all meta will be
	 * returned.
	 * The function will return FALSE if the
	 * meta data was not found.
	 * 
	 * @param string optional $name
	 * @return mixed
	 */
	public function get_meta($name = '')
	{
		if ( $name == '' ) {
			return $this->_meta;
		} else {
			return array_ensure($this->_meta, $name, false);
		}
	}
		
	/**
	 * Return the current page title.
	 * 
	 * @return string
	 */
	public function get_page_title($title_only = false)
	{
		$current_page_title = $this->_page_title;
		
		if ( is_empty($current_page_title) && $this->_page_title_autoload ) {
			// Get the page title via language file.
			$base_uri = preg_replace('/[\.\?][^.]*$/', '', remove_base_url(current_uri()));
			$base_uri = rtrim($base_uri, '/');
			
			$lang_key = 'page_title_' . $base_uri;
			
			$lang_title = lang($lang_key);
			
			if ( !is_empty($lang_title) ) {
				$current_page_title = $lang_title;
			}
		}
		
		if ( is_empty($current_page_title) ) {
			// Get the default page title.
			$default_title = lang('page_title_default');
			
			if ( !is_empty($default_title) ) {
				return $default_title;
			}
		}
		
		if ( $title_only ) {
			return $current_page_title;
		}
		
		$prefix = $this->_page_title_prefix;
		$suffix = $this->_page_title_suffix;
		
		if ( $prefix === null ) {
			$prefix = lang('page_title_prefix');
		}
		
		if ( $suffix === null ) {
			$suffix = lang('page_title_suffix');
		}
		
		return $prefix . $current_page_title . $suffix;
	}
	
	/**
	 * Check whether the template will compile the page title
	 * automatically.
	 * 
	 * @return boolean
	 */
	public function get_page_title_autoload()
	{
		return $this->_page_title_autoload;
	}
	
	/**
	 * Return the prefix of the page title.
	 * 
	 * @return string
	 */
	public function get_page_title_prefix()
	{
		return $this->_page_title_prefix;
	}
	
	/**
	 * Return the suffix of the page title.
	 * 
	 * @return boolean
	 */
	public function get_page_title_suffix()
	{
		return $this->_page_title_suffix;
	}
	
	/**
	 * Return the theme folder name.
	 * 
	 * @return string
	 */
	public function get_theme()
	{
		return $this->_theme;
	}
	
	public function get_theme_path()
	{
		return 'themes/' . $this->_theme;
	}
	
	/**
	 * Return the real path that relative to the "views"
	 * folder. It will search from the theme folder for
	 * the script file. If it does not exists, it will
	 * then search from the "views" folder.
	 * 
	 * It will return FALSE if the script path not found
	 * from the entire "views" directory.
	 * 
	 * @param string $script
	 * @return string|boolean
	 */
	public function get_view_path($script)
	{
		$theme_path = $this->get_theme_path();
		
		$script_path = APPPATH . 'views/' . $theme_path . '/' . $script . '.php';
		
		if ( file_exists($script_path) ) {
			return $theme_path . '/' . $script;
		} else {
			$script_path = APPPATH . 'views/' . $script . '.php';
			
			if ( file_exists($script_path) ) {
				return $script;
			} else {
				return false;
			}
		}
	}
	
	/**
	 * Generate the html header part. Three option where you
	 * can specify what to return. Please refer to the parameter
	 * option
	 * 
	 * @param string optiona $type Options: meta, css, js. If empty string
	 * was passed, it will return all.
	 * @return string
	 */
	public function html_header($type = '')
	{
		$meta = '<meta charset="' . $this->_charset . '">' . PHP_EOL;
		
		if ( iterable($this->_meta) ) {
			foreach ( $this->_meta as $name => $content ) {
				$meta .= '<meta name="' . $name . '" content="' . htmlentities($content, ENT_COMPAT | ENT_HTML401, $this->_charset) . '">' . PHP_EOL;
			}
		}
		
		$meta .= '<title>' . $this->get_page_title() . '</title>' . PHP_EOL;
		
		$css = '';
		if ( iterable($this->_css) ) {
			foreach ( $this->_css as $path ) {
				$css .= '<link rel="stylesheet" href="' . $path . '" />' . PHP_EOL;
			}
		}
		
		$js = '';
		if ( iterable($this->_js) ) {
			ksort($this->_js);
			foreach ( $this->_js as $path ) {
				$js .= '<script type="text/javascript" src="' . $path . '"></script>' . PHP_EOL;
			}
		}
		
		switch ( strtolower($type) ) {
			case 'meta':
				return $meta;
			case 'css':
				return $css;
			case 'js':
				return $js;
			default:
				return $meta . $css . $js;
		}
	}
	
	/**
	 * To check a script file has loaded in the
	 * current page or not.
	 * 
	 * @param string $script
	 * @return boolean
	 */
	public function is_css_loaded($script)
	{
		$fullpath = $this->get_base_url($script);
		
		return in_array($fullpath, $this->_css);
	}
	
	/**
	 * To check a script file has loaded in the
	 * current page or not.
	 * 
	 * @param string $script
	 * @return boolean
	 */
	public function is_js_loaded($script)
	{
		$fullpath = $this->get_base_url($script);
		
		return in_array($fullpath, $this->_js);
	}
	
	/**
	 * Return TRUE if the meta data was exists
	 * or FALSE if otherwise.
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function is_meta_exists($name)
	{
		return isset($this->_meta[$name]);
	}
	
	/**
	 * Check if the script file exists. You can
	 * pass the path prefix ~/ and !/
	 * 
	 * @param string $script_path
	 * @return boolean
	 */
	public function is_script_exists($script_path)
	{
		$base_url = base_url('/');
		$fullpath = $this->get_base_url($script_path);
		$script_path = str_replace($base_url, '', $fullpath);
		
		if ( preg_match('/^themes\//', $script_path) ) {
			$script_path = APPPATH . '/views/' . $script_path;
			
			return file_exists($script_path);
		} else {
			return file_exists($script_path);
		}
	}
	
	/**
	 * To remove a css from the current page.
	 * It wil return TRUE when the script found or 
	 * otherwise.
	 * 
	 * @param string $script
	 * @return boolean
	 */
	public function remove_css($script)
	{
		$fullpath = $this->get_base_url($script);
		$index = array_search($fullpath, $this->_css);
		
		if ( false !== $index && $index >= 0 ) {
			unset($this->_css, $index);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * To remove a javascript from the current page.
	 * It wil return TRUE when the script found or 
	 * otherwise.
	 * 
	 * @param string $script
	 * @return boolean
	 */
	public function remove_js($script)
	{
		$fullpath = $this->get_base_url($script);
		$index = array_search($fullpath, $this->_js);
		
		if ( false !== $index && $index >= 0 ) {
			unset($this->_js, $index);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Remove the meta data from the HTML
	 * page. It will return TRUE if the 
	 * meta was found in the HTML page or
	 * FALSE if otherwise.
	 * 
	 * @param string $name
	 * @return boolean
	 */
	public function remove_meta($name)
	{
		if ( isset($this->_meta[$name]) ) {
			unset($this->_meta[$name]);
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Set the HTML character set used.
	 * Please refer to the URL below for list
	 * of charset:
	 * http://www.iana.org/assignments/character-sets/character-sets.xhtml
	 * 
	 * Note: For widely support wise, please use ISO-8859-1 or UTF-8
	 * 
	 * @param string $charset
	 * @return null
	 */
	public function set_charset($charset)
	{
		$this->_charset = strtoupper($charset);
	}
	
	/**
	 * To set the content of the page. The library
	 * will search the script from the theme folder 
	 * first. If it was not found, then it will search 
	 * from the "views" folder.
	 * 
	 * @param $content
	 * @return null
	 */
	public function set_content($content)
	{
		$this->_content = $content;
	}
	
	/**
	 * To add a css into the page.
	 * It accept array as the parameter to add multiple
	 * script files at one go.
	 * 
	 * @param string|array $script
	 * @param int optional $index
	 * @return null
	 */
	public function set_css($script, $index = 0)
	{
		if ( iterable($script) ) {
			foreach ( $script as $file ) {
				$this->set_css($file);
			}
		} else {
			$fullpath = strip_url_protocol($this->get_base_url($script));
			
			if ( !in_array($fullpath, $this->_css) ) {
				// Check if the index is being occupied.
				if ( isset($this->_css[$index]) ) {
					do {
						$index ++;
						
						if ( !isset($this->_css[$index]) ) {
							break ;
						}
					} while(true);
				}
				
				$this->_css[$index] = $fullpath;
			}
		}
	}
	
	/**
	 * Set the index script name (wihtout .php extension behind).
	 * 
	 * @param string $index_script
	 * @return null
	 */
	public function set_index_script($index_script)
	{
		$this->_index_script = $index_script;
	}
	
	/**
	 * To add a javascript into the page.
	 * It accept array as the parameter to add multiple
	 * script files at one go.
	 * 
	 * @param string|array $script
	 * @param int optional $index
	 * @return null
	 */
	public function set_js($script, $index = 0)
	{
		if ( iterable($script) ) {
			foreach ( $script as $file ) {
				$this->set_js($file);
			}
		} else {
			$fullpath = strip_url_protocol($this->get_base_url($script));
			
			if ( !in_array($fullpath, $this->_js) ) {
				// Check if the index is being occupied.
				if ( isset($this->_js[$index]) ) {
					do {
						$index ++;
						
						if ( !isset($this->_js[$index]) ) {
							break ;
						}
					} while(true);
				}
				
				$this->_js[$index] = $fullpath;
			}
		}
	}
	
	/**
	 * Set the layout script for the page.
	 * 
	 * @param string $layout
	 * @return null
	 */
	public function set_layout($layout)
	{
		$this->_layout = $layout;
	}
	
	/**
	 * To turn on/off the template.
	 * 
	 * @param boolean $load_template
	 * @return null
	 */
	public function set_load_template($load_template)
	{
		$this->_load_template = ($load_template ? true : false);
	}
	
	/**
	 * This will add the meta data into the
	 * HTML page. It allowed mutliple meta
	 * data to be set at one go by passing
	 * an array into the first parameter.
	 * 
	 * @param string|array $name
	 * @param string optional $content
	 * @return null
	 */
	public function set_meta($name, $content = '')
	{
		if ( $content = '' ) {
			if ( iterable($name) ) {
				foreach ( $name as $key => $value ) {
					$this->_meta[$key] = $value;
				}
			}
		} else {
			$this->_meta[$name] = $content;
		}
	}
	
	/**
	 * Set the page title, prefix and suffix.
	 * 
	 * @param string $title
	 * @param string optional $prefix
	 * @param string optional $suffix
	 * @return null
	 */
	public function set_page_title($title, $prefix = null, $suffix = null)
	{
		$this->_page_title = $title;
		
		$this->_page_title_prefix = $prefix;
		
		$this->_page_title_suffix = $suffix;
	}
	
	/**
	 * Set the autoload function for the page title
	 * The title are stored in the language file.
	 * 
	 * @param boolean $autload
	 * @return null
	 */
	public function set_page_title_autoload($autload)
	{
		$this->_page_title_autoload = ($autoload ? true : false);
	}
	
	/**
	 * Set the prefix for the page title. If no prefix set,
	 * the template class will load the prefix from the
	 * language file.
	 * 
	 * @param string $prefix
	 * @return null
	 */
	public function set_page_title_prefix($prefix)
	{
		$this->_page_title_prefix = $prefix;
	}
	
	/**
	 * Set the suffix for the page title. If no suffix set,
	 * the template class will load the suffix from the
	 * language file.
	 * 
	 * @param string $suffix
	 * @return null
	 */
	public function set_page_title_suffix($suffix)
	{
		$this->_page_title_suffix = $suffix;
	}
	
	/**
	 * Set the theme folder name.
	 * 
	 * @param string $theme
	 * @return null
	 */
	public function set_theme($theme)
	{
		$this->_theme = $theme;
	}
}