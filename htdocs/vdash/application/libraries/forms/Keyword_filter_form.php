<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class Keyword_filter_form extends Form {
	public function init()
	{
		$fields = array(
			array(
				'name' => 'filter_keyword',
				'type' => 'text',
				'label' => lang('search_all_columns'),
				'attributes' => array(
					'class' => 'form-control',
					'placeholder' => lang('keywords'),
				),
			),
		);
		
		$this->set_fields($fields);
	}
}