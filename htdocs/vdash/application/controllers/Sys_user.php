<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sys_user extends EB_Controller {

	public function add()
	{
		$sys_user_model = new Sys_user_model();
		$sys_user_model->new_data();
		
		$user_type = $this->input->get('user_type');
		$business_id = $this->input->get('business_id');
		$page_title = lang('user_new');
		
		$form_options = array(
			'name' => 'sys_user_form',
			'action' => 'sys_user/add',
			'method' => 'post',
			'layout' => 'bootstrap_horizontal',
			'submit_label' => lang('save'),
			'models' => array(
				$sys_user_model,
			),
		);
		
		if ( $business_id ) {
			$sys_user_model->set_value('business_id', $business_id);
				
			$form_options['action'] = 'sys_user/add?business_id=' . $business_id;
				
			$page_title = lang('user_new_business');
		} else if ( $user_type == 'business' ) {
			$form_options['action'] = 'sys_user/add?user_type=' . $user_type;
				
			$sys_user_model->set_value('sys_user_type', 'admin');
				
			$page_title = lang('user_new_business');
		}
		
		$this->load->library('forms/sys_user_form', $form_options);
		
		if ( $this->sys_user_form->is_submission_succeed() ) {
			$sys_user_id = $sys_user_model->get_value('sys_user_id');
			
			$this->system->set_message('success', lang('txt_user_created'));
				
			redirect('sys_user/profile/' . $sys_user_id);
		}
		
		$this->template->set_page_title($page_title);
		$this->template->set_layout('default');
		$this->template->set_content('form');
		$this->template->display(array(
			'form' => $this->sys_user_form->render(),
			'form_title' => $page_title,
		));
	}
	
	public function change_password($sys_user_id)
	{
		$code = $this->input->get('code');
		
		if ( !$this->system->verify_client_id($code) ) {
			$this->access_deny();
		}
		
		$password = $this->input->get('password');
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$sys_user_model = new Sys_user_model();
		$sys_user_model->load(array(
			'sys_user_id' => $sys_user_id,
		));
		
		if ( $sys_user_model->is_empty() ) {
			$output['error'] = 1;
			$output['message'] = lang('error_sys_user_not_found');
		} else {
			$error_message = '';
			
			if ( !$sys_user_model->change_password($password, $error_message) ) {
				$output['error'] = 1;
				$output['message'] = $error_message;
			} else {
				$output['message'] = lang('txt_password_changed');
			}
		}
		
		json_output($output);
	}
	
	public function edit($sys_user_id)
	{
		$sys_user_model = new Sys_user_model();
		$sys_user_model->load(array(
			'sys_user_id' => $sys_user_id,
		));
		
		if ( $sys_user_model->is_empty() ) {
			$this->system->set_message('danger', lang('error_sys_user_not_found'));
			
			redirect('sys_user');
		}
		
		$sys_user_id = $sys_user_model->get_value('sys_user_id');
		$sys_user_name = $sys_user_model->get_value('sys_user_name');
		
		$page_title = _lang('_user_profile', $sys_user_name);
	
		$form_options = array(
			'name' => 'sys_user_form',
			'action' => 'sys_user/edit/' . $sys_user_id,
			'method' => 'post',
			'layout' => 'bootstrap_horizontal',
			'submit_label' => lang('edit'),
			'models' => array(
				$sys_user_model,
			),
		);
	
		$this->load->library('forms/sys_user_form', $form_options);
	
		if ( $this->sys_user_form->is_submission_succeed() ) {
			$sys_user_id = $sys_user_model->get_value('sys_user_id');
			
			$this->system->set_message('success', lang('txt_user_created'));
			
			redirect('sys_user/profile/' . $sys_user_id);
		}
	
		$this->template->set_page_title($page_title);
		$this->template->set_layout('default');
		$this->template->set_content('form');
		$this->template->display(array(
			'form' => $this->sys_user_form->render(),
			'form_title' => $page_title,
		));
	}
	
	/**
	 * This controller will list the system users.
	 * By default it will list all users. The available
	 * options are:
	 * + all
	 * + superadmin
	 * + business Either admin or viewer
	 * + admin
	 * + viewer
	 *
	 * @param string $type
	 */
	public function index($type = 'all')
	{
		if ( !$this->authentication->is_authenticated() && $this->authentication->is('superadmin') ) {
			$this->access_deny(true, 'dashboard');
		}
		
		$per_page_options = array(10, 20, 30, 50, 100);
		$per_page = $this->input->get('per_page');
		
		if ( !in_array($per_page, $per_page_options) ) {
			$per_page = array_first($per_page_options);
		}
		
		$this->load->library('forms/keyword_filter_form', array(
			'name' => 'filter_form',
			'action' => 'business/user',
			'method' => 'get',
			'layout' => 'bootstrap_inline',
			'submit_label' => '<i class="fa fa-search"></i> ' . lang('search'),
		));
	
		$this->load->library('listings/sys_user_listing', array(
			'listing_type' => $type,
			'layout' => 'bootstrap_column_listing',
		));
	
		$page_title = lang('user_list');
	
		if ( $type == 'business' ) {
			$page_title = lang('business_users');
		}
	
		$buttons = array();
	
		if ( $type == 'business' ) {
			$buttons[] = array(
				'label' => lang('create_business_user'),
				'type' => 'success',
				'icon' => 'fa fa-plus',
				'url' => site_url('sys_user/add?user_type=business'),
			);
		} else {
			$buttons[] = array(
				'label' => lang('create_new_user'),
				'type' => 'success',
				'icon' => 'fa fa-plus',
				'url' => site_url('sys_user/add'),
			);
		}
	
		$this->template->set_page_title($page_title);
		$this->template->set_layout('default');
		$this->template->set_content('list');
		$this->template->display(array(
			'per_page_options' => $per_page_options,
			'filter_form' => $this->keyword_filter_form->render(),
			'list' => $this->sys_user_listing->render(),
			'page_title' => $page_title,
			'action_buttons' => $buttons,
		));
	}
	
	/**
	 * This will show the user profile detail. Depending on the user_type,
	 * this page will show different details.
	 * @param unknown $sys_user_id
	 */
	public function profile($sys_user_id = 0)
	{
		if ( !$sys_user_id ) {
			$sys_user_model = $this->authentication->get_model();
			$sys_user_id = $sys_user_model->get_value('sys_user_id');
		} else {
			$sys_user_model = new Sys_user_model();
			$sys_user_model->load(array(
				'sys_user_id' => $sys_user_id,
			));
		}
		
		if ( $sys_user_model->is_empty() ) {
			$this->system->set_message('danger', lang('error_sys_user_not_found'));
			
			redirect('sys_user');
		}
		
		$tmp_password = $this->session->flashdata('_tmp_random_password');
		//$this->session->keep_flashdata('_tmp_random_password');
		
		$page_title = _lang('_user_profile', $sys_user_model->get_value('sys_user_name'));
		
		$this->template->set_css('~/css/bootstrap-table.css');
		$this->template->set_js('~/js/sys_user_profile.js');
		$this->template->set_page_title($page_title);
		$this->template->set_layout('default');
		$this->template->set_content('sys_user_profile');
		$this->template->display(array(
			'sys_user_data' => $sys_user_model->get_data(),
			'sys_user_model' => $sys_user_model,
			'page_title' => $page_title,
			'tmp_password' => $tmp_password,
			'sys_user_id' => $sys_user_model->get_value('sys_user_id'),
		));
	}
}