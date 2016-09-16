<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(dirname(__FILE__) . '/Form.php');

class Sample_form extends Form {
	public function init()
	{
		$this->set_fields(array(
			'email' => array(
				'type' => 'text',
				'label' => 'Email Address',
				'rules' => array('required', 'email'),
				'tips' => 'Must be a unique valid email',
			),
			'gender' => array(
				'type' => 'radio',
				'label' => 'Gender',
				'rules' => array('required'),
				'options' => array(
					'male' => 'Male',
					'female' => 'Female',
				),
			),
			'dob' => array(
				'type' => 'date',
				'label' => 'Date of Birth',
				'value' => '1987-09-18',
				'date-format' => 'd/m/yy',
				'change-month' => true,
				'change-year' => true,
			),
			'salary' => array(
				'type' => 'slider',
				'label' => 'Expected Salary',
				'min' => 2000,
				'max' => 10000,
				'step' => 100,
				"size" => 5,
			),
			'expiry' => array(
				'type' => 'daterange',
				'label' => 'Warranty Expiry',
				'date-format' => 'D, d M yy',
				'value' => array(
					'from' => '2014-03-01',
					'till' => '2014-03-25',
				),
			),
			'valid' => array(
				'type' => 'dropdown',
				'label' => 'Active',
				'rules' => array('required'),
				'options' => array(
					1 => 'Active',
					0 => 'Inactive',
				),
			),
			'languages' => array(
				'type' => 'checkbox',
				'label' => 'Prefered Language',
				'rules' => array('required'),
				'options' => array(
					'cpp' => 'C++',
					'java' => 'Java',
					'php' => 'PHP',
					'perl' => 'Perl',
				),
			),
			'friends' => array(
				'type' => 'multiselect',
				'label' => 'My Friends',
				'size' => 2,
				'rules' => array('required'),
				'options' => array(
					'kflee' => 'Kent Lee',
					'tshanmug' => 'Thilaksharma',
					'pfmnoor' => 'Ms. Puteri',
					'scsit' => 'Ms. Sook Chin',
				),
			),
		));
	}
}