<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['recaptcha_public_key'] = '6LcQzQUTAAAAAF0O1acX6vnmrkCZCYWN_IXwsnl6';
$config['recaptcha_private_key'] = '6LcQzQUTAAAAAIz8ozoenluyv2tvb0B5ibxutXQP';

$config['num_links'] = 10;
$config['per_page'] = 10;
$config['max_notification_message'] = 6;

/*
 * The default app filter settings
 */
$config['app_filter'] = false;
$config['app_filter_mode'] = 'allow';

/*
 * Notification Settings
 */
$config['machine_limit'] = 85; // percentage
$config['app_license_limit'] = 85; // percentage