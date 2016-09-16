<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Licenset extends EB_Controller {
	public function init()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny(true, 'login');
		}
		
		$this->load->model('Business_model', 'business_model');
	}
	
	public function a_upload_picture()
	{
		if ( !$this->authentication->is_authenticated() ) {
			$this->access_deny();
		}
		
		$sys_user_model = $this->authentication->get_model();
		
		if ( $sys_user_model->get_value('sys_user_type') != 'superadmin' ) {
			$this->access_deny();
		}
		
		$output = array(
			'error' => 0,
			'message' => '',
		);
		
		$token = $this->input->post('token');
		$business_id = $this->input->post('business_id');
		
		if ( !$this->system->verify_client_id($token) ) {
			$output['error'] = 1;
			$output['message'] = lang('error_invalid_token');
		} else {
			$this->load->model('Business_model', 'business_model');
			
			$this->business_model->load(array(
				'business_id' => $business_id,
			));
			
			if ( $this->business_model->is_empty() ) {
				$output['error'] = 1;
				$output['message'] = lang('error_business_not_found');
			} else {
				$upload_file = $_FILES['picture'];
					
				if ( !iterable($upload_file) || !isset($upload_file['name']) || is_empty($upload_file['name']) || $upload_file['error'] ) {
					$output['error'] = 1;
					$output['message'] = lang('error_unable_upload_file');
				} else {
					$file_type = array_ensure($upload_file, 'type', '');
				
					if ( !preg_match('/^image\/(?:jpe?g|png|gif)/', $file_type) ) {
						$output['error'] = 1;
						$output['message'] = lang('error_upload_invalid_file_type');
					} else {
						$file_size = array_ensure($upload_file, 'size', 0);
							
						if ( $file_size > 2 * 1024 * 1024 ) {
							$output['error'] = 1;
							$output['message'] = lang('error_upload_file_size');
						} else {
							$tmp_file = array_ensure($upload_file, 'tmp_name', '');
							$filename = array_ensure($upload_file, 'name', '');
							$new_filename = sanitize_filename($filename);
							
							$this->load->library('image_lib', array(
								'image_library' => 'gd2',
								'source_image' => $tmp_file,
								'new_image' => 'uploads/' . $new_filename,
								'maintain_ratio' => true,
								'width' => 300,
								'height' => 300,
							));
							
							if ( $this->image_lib->resize() ) {
								$this->business_model->set_value('business_picture', $new_filename);
								$this->business_model->save();
								
								$output['image_path'] = base_url('uploads/' . $new_filename);
							} else {
								$output['error'] = 1;
								$output['message'] = lang('error_image_resize_failed');
							}
						}
					}
				}
			}
		}
		
		json_output($output);
	}
	
	/**
	 * Add new business model.
	 */
	public function add()
	{
		$this->load->library('forms/business_form', array(
			'name' => 'business_form',
			'action' => 'business/add',
			'method' => 'post',
			'layout' => 'bootstrap_horizontal',
			'submit_label' => lang('create_business'),
			'models' => array(
				$this->business_model,
			),
		));
		
		if ( $this->business_form->is_submission_succeed() ) {
			$business_id = $this->business_model->get_value('business_id');
			
			$this->system->set_message('success', lang('msg_business_created'), 'fa fa-info');
			
			redirect('business/profile/' . $business_id);
		}
		
		$this->template->set_layout('default');
		$this->template->set_content('form');
		$this->template->display(array(
			'form_title' => lang('business_new'),
			'form' => $this->business_form->render(),
		));
	}
	
	public function edit($business_id)
	{
		$this->business_model->load(array(
			'business_id' => $business_id,
		));
		
		if ( $this->business_model->is_empty() ) {
			$this->system->set_message('danger', lang('error_business_not_found'));
			
			redirect('dashboard');
		}
		
		$this->load->library('forms/business_form', array(
			'name' => 'business_form',
			'action' => 'business/edit/' . $business_id,
			'method' => 'post',
			'layout' => 'bootstrap_horizontal',
			'submit_label' => '<i class="fa fa-edit"></i> ' . lang('edit_profile'),
			'models' => array(
				$this->business_model,
			),
		));
		
		if ( $this->business_form->is_submission_succeed() ) {
			$business_id = $this->business_model->get_value('business_id');
			
			$this->system->set_message('success', lang('msg_business_edited'), 'fa fa-info');
				
			redirect('business/profile/' . $business_id);
		}
		
		$this->template->set_layout('default');
		$this->template->set_content('form');
		$this->template->display(array(
			'form_title' => lang('business_edit'),
			'form' => $this->business_form->render(),
		));
	}
	
	public function index()
	{
		$per_page_options = array(10, 20, 30, 50, 100);
		$per_page = $this->input->get('per_page');
		
		if ( !in_array($per_page, $per_page_options) ) {
			$per_page = array_first($per_page_options);
		}
		
		$this->load->library('forms/keyword_filter_form', array(
			'name' => 'filter_form',
			'action' => 'business/index',
			'method' => 'get',
			'layout' => 'bootstrap_inline',
			'submit_label' => '<i class="fa fa-search"></i> ' . lang('search'),
		));
		
		$this->load->library('listings/business_listing', array(
			'layout' => 'bootstrap_column_listing',
		));
		
		$this->template->set_layout('default');
		$this->template->set_content('list');
		$this->template->display(array(
			'list' => $this->business_listing->render(),
			'filter_form' => $this->keyword_filter_form->render(),
			'page_title' => lang('business_list'),
			'per_page_options' => $per_page_options,
		));
	}
	
	public function profile($business_id)
	{
		$this->business_model->load(array(
			'business_id' => $business_id,
		));
		
		if ( $this->business_model->is_empty() ) {
			$this->system->set_message('danger', lang('error_business_not_found'));
				
			redirect('business');
		}
		
		$this->load->library('listings/business_user_listing', array(
			'layout' => 'bootstrap_column_listing',
			'business_id' => $business_id,
		));
		
		$page_title = _lang('_business_profile_title', $this->business_model->get_value('business_name'));
		
		// Javascripts for file upload.
		$this->template->set_js(array(
			'//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js',
			'//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js',
			'!/js/jquery.ui.widget.js',
			'!/js/jquery.iframe-transport.js',
			'!/js/jquery.fileupload.js',
			'!/js/jquery.fileupload-process.js',
			'!/js/jquery.fileupload-image.js',
			'!/js/jquery.fileupload-validate.js',
			'~/js/business_profile.js',
		));
		
		$this->template->set_css('~/css/bootstrap-table.css');
		$this->template->set_page_title($page_title);
		$this->template->set_layout('default');
		$this->template->set_content('business_profile');
		$this->template->display(array(
			'business_model' => $this->business_model,
			'page_title' => $page_title,
			'user_list' => $this->business_user_listing->render(),
		));
	}
}