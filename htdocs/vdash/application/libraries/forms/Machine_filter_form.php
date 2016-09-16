<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class Machine_filter_form extends Form {
	public function init()
	{
		$machine_group_option_list = get_machine_group_option_list();
		$machine_group_option_list = array(
			'' => '- ' . lang('txt_select_machine_group') . ' -',
		) + $machine_group_option_list;
		
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
			array(
				'name' => 'filter_status',
				'type' => 'dropdown',
				'label' => '',
				'attributes' => array(
					'class' => 'form-control',
				),
				'options' => array(
					'' => '- ' . lang('user_status_selection') . ' -',
					'blacklisted' => lang('blacklisted'),
					'whitelisted' => lang('whitelisted'),
				),
			),
			array(
				'name' => 'filter_machine_group',
				'type' => 'dropdown',
				'label' => '',
				'attributes' => array(
					'class' => 'form-control',
				),
				'options' => $machine_group_option_list,
			),
		);
		
		$this->set_fields($fields);
	}
}