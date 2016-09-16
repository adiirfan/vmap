<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * -------------------------------
 * SYSTEM ERROR MESSAGES
 * -------------------------------
 */
$lang['_error_db_data_not_found'] = 'No data found at the current index.';
$lang['_error_db_data_remove_failed'] = 'Unable to remove data at the current position.';
$lang['_error_db_delete_failed'] = 'Unable to delete the records for the database model.';
$lang['_error_db_model'] = 'Database model error.';
$lang['_error_db_table_name_not_specified'] = 'No table name specified.';
$lang['_error_external_library_not_found'] = 'External library not found.';
$lang['_error_form_field_not_unique'] = '%s is not unique or duplicated.';
$lang['_error_form_field_invalid_type'] = 'Invalid form field type. No such field class found: %s';
$lang['_error_form_field_name_not_set'] = 'Field\'s name was not set during initialization.';
$lang['_error_form_field_type_not_set'] = 'Field\'s type was not set during initialization.';
$lang['_error_form_invalid_captcha_library'] = 'Invalid captcha library found. No such captcha library available: %s';
$lang['_error_form_invalid_form_object'] = 'Invalid object set to the form referencing variable during initialization.';
$lang['_error_form_invalid_model_object'] = 'Invalid model object type set to the form binding.';
$lang['_error_form_field_view_not_found'] = 'The template script for the input element cannot be found.';
$lang['_error_form_view_not_found'] = 'Form layout not found.';
$lang['_error_invalid_authentication_model'] = 'Invalid authentication model used. Please implement Authentication_user to the user model class.';
$lang['_error_invalid_form_object'] = 'Invalid form object used. Make sure the object is inherit from Form class.';
$lang['_error_invalid_listing_object'] = 'Invalid listing object used. Make sure the object is inherit from Listing class.';
$lang['_error_invalid_model_data_parameter'] = 'Data should be multidimension array with incremental integer of the array key.';
$lang['_error_invalid_model_data'] = 'Invalid data format set to this model: %s';
$lang['_error_invalid_navigation_object'] = 'Invalid navigation object used. Make sure the object is inherit from the Navigation class.';
$lang['_error_listing_view_not_found'] = 'Unable to locate the view script for the listing library.';
$lang['_error_model_not_found'] = 'No such database model found: %s';
$lang['_error_session_not_initialized'] = 'Session not initialized.';
$lang['_error_template_not_found'] = 'Template file not found: %s';
$lang['_error_tmp_index_not_found'] = 'Template script not found for the theme folder: %s.';
$lang['_HTTP_401_title'] = '401 Unauthorized';
$lang['_HTTP_401_message'] = 'You are not authorized to access the requested page.';

/*
 * -------------------------------
 * FORM ERROR
 * ------------------------------- 
 */
$lang['_form_error'] = 'There some error in your form. Please rectify the problem in your form and submit again.';
$lang['_form_error_empty'] = 'Please enter a value for this field.';
$lang['_form_error_file_cant_write'] = 'Unable to write the file. Please contact system administrator.';
$lang['_form_error_file_empty'] = 'Please select a file to upload.';
$lang['_form_error_file_form_size'] = 'Thee form size posted has exceeded the system specified limit.';
$lang['_form_error_file_ini_size'] = 'Upload size has exceeded the system specified size.';
$lang['_form_error_file_invalid_type'] = 'Invalid file type uploaded.';
$lang['_form_error_file_no_tmp_dir'] = 'No temporary directory specified. Please contact system administrator.';
$lang['_form_error_file_partial'] = 'Only partial of the file received. Please try again.';
$lang['_form_error_file_size_exceeded'] = 'Your filesize has exceeded the limit of %2$sKB.';
$lang['_form_error_option_empty'] = 'Please select at least one from the option.';
$lang['_form_error_field_not_match'] = 'The %s field is not match. Please try again.';
$lang['_form_error_filetype_invalid'] = 'Invalid file types. Allowed file types: %s.';
$lang['_form_error_invalid_email'] = 'Invalid email address.';
$lang['_form_error_matching_field_not_found'] = 'Unable to find the matching field to compare.';
$lang['_form_error_maxlen'] = 'Maximum length of %d.';
$lang['_form_error_minlen'] = 'Minimum length of %d.';
$lang['_form_error_not_match'] = 'Your value does not match with the %s field.';
$lang['_form_error_option_outofdomain'] = 'Selected option is out of domain.';
$lang['_form_error_request_forgery'] = 'Invalid form submitted. Please try again.';
$lang['_form_error_invalid_captcha'] = 'Please check the captcha checkbox.';
$lang['_form_error_slider_min'] = 'The value has to be minimum of %s.';
$lang['_form_error_slider_max'] = 'The value cannot more than %s.';
$lang['_form_error_number_invalid'] = 'Invalid number format';
$lang['_form_error_number_minimum'] = 'The minimum value of this field is %s.';
$lang['_form_error_number_maximum'] = 'The maximum value of this field is %s.';
$lang['_form_error_integer_only'] = 'This field only allow integer.';

/*
 * -------------------------------
 * FORM FIELD LABEL
 * -------------------------------
 */
$lang['_form_field_daterange_from'] = 'From';
$lang['_form_field_daterange_till'] = 'Till';
$lang['_form_button_reset'] = 'Reset';
$lang['_form_button_submit'] = 'Submit';

/*
 * -------------------------------
 * LISTING MESSAGES
 * ------------------------------- 
 */
$lang['_listing_no_records'] = 'No records found.';
$lang['_listing_show_results'] = 'Showing %d to %d of %d entries.';