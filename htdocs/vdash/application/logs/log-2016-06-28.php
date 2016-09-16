<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2016-06-28 05:43:55 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:43:55 --> No URI present. Default controller set.
DEBUG - 2016-06-28 05:43:56 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:43:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:43:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:43:56 --> No URI present. Default controller set.
DEBUG - 2016-06-28 05:43:56 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:43:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:43:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 05:43:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 05:43:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 05:43:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 05:43:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 05:43:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 05:43:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 05:43:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 05:43:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 05:43:57 --> Could not find the language line "page_title_"
DEBUG - 2016-06-28 05:43:57 --> Total execution time: 0.8376
DEBUG - 2016-06-28 05:43:57 --> Total execution time: 1.5149
DEBUG - 2016-06-28 05:44:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:44:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:44:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:44:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 05:44:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:44:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:44:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:44:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 05:44:15 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 05:44:15 --> Total execution time: 0.5624
DEBUG - 2016-06-28 05:44:26 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:44:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:44:26 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:44:26 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 05:44:26 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\licenseadd.php 48
ERROR - 2016-06-28 05:44:26 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 05:44:26 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 05:44:26 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 05:44:26 --> Could not find the language line "page_title_license/add"
DEBUG - 2016-06-28 05:44:26 --> Total execution time: 0.2684
DEBUG - 2016-06-28 05:44:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:44:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:44:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:44:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 05:44:29 --> Total execution time: 0.2903
DEBUG - 2016-06-28 05:44:34 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:44:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:44:34 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:44:34 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 05:44:34 --> Listing query: SELECT `machine_groups`.*, `businesses`.`business_name`, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id
			) AS total_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status <> "offline"
			) AS online_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status = "offline"
			) AS offline_machines
FROM `machine_groups`
JOIN `businesses` ON `machine_groups`.`business_id` = `businesses`.`business_id`
 LIMIT 10
DEBUG - 2016-06-28 05:44:34 --> Total execution time: 0.3256
DEBUG - 2016-06-28 05:44:50 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:44:50 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:44:50 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:44:50 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 05:44:50 --> Total execution time: 0.1325
DEBUG - 2016-06-28 05:45:33 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:45:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:45:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:45:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 05:45:33 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 05:45:33 --> Total execution time: 0.1642
DEBUG - 2016-06-28 05:52:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:52:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:52:19 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 05:52:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:52:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:52:19 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 05:55:35 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:55:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:55:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:55:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 05:55:35 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 05:55:35 --> Total execution time: 0.1177
DEBUG - 2016-06-28 05:55:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:55:36 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:55:36 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 05:55:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:55:36 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:55:36 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 05:56:16 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:56:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:56:16 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:56:16 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 05:56:16 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 05:56:16 --> Total execution time: 0.1244
DEBUG - 2016-06-28 05:56:16 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:56:16 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:56:16 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 05:56:16 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:56:16 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:56:16 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 05:56:45 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:56:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:56:45 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:56:45 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 05:56:45 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 05:56:45 --> Total execution time: 0.1262
DEBUG - 2016-06-28 05:56:45 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:56:45 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:56:45 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 05:56:45 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:56:45 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:56:45 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 05:57:48 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:57:48 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 05:57:48 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 05:57:48 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 05:57:48 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 05:57:48 --> Total execution time: 0.1168
DEBUG - 2016-06-28 05:57:49 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:57:49 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:57:49 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 05:57:49 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 05:57:49 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 05:57:49 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:02:48 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:02:48 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:02:48 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:02:48 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:02:48 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 06:02:48 --> Total execution time: 0.1221
DEBUG - 2016-06-28 06:02:49 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:02:49 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:02:49 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:02:49 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:02:49 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:02:49 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:03:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:03:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:03:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:03:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:03:27 --> Total execution time: 0.1430
DEBUG - 2016-06-28 06:03:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:03:27 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:03:27 --> 404 Page Not Found: Machine/images
DEBUG - 2016-06-28 06:03:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:03:27 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:03:27 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:03:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:03:27 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:03:27 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:03:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:03:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:03:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:03:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:03:52 --> Listing query: SELECT `machine_groups`.*, `businesses`.`business_name`, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id
			) AS total_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status <> "offline"
			) AS online_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status = "offline"
			) AS offline_machines
FROM `machine_groups`
JOIN `businesses` ON `machine_groups`.`business_id` = `businesses`.`business_id`
 LIMIT 10
DEBUG - 2016-06-28 06:03:52 --> Total execution time: 0.1151
DEBUG - 2016-06-28 06:03:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:03:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:03:52 --> 404 Page Not Found: Machine_group/images
DEBUG - 2016-06-28 06:03:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:03:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:03:52 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:03:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:03:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:03:52 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:05:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:05:28 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:05:28 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:05:28 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:05:28 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:05:28 --> Total execution time: 0.1838
DEBUG - 2016-06-28 06:05:28 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:05:28 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:05:28 --> 404 Page Not Found: Machine/images
DEBUG - 2016-06-28 06:05:28 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:05:28 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:05:28 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:05:28 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:05:28 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:05:28 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:05:28 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:05:28 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:05:28 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:06:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:06:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:06:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:06:36 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:06:36 --> Total execution time: 0.1193
DEBUG - 2016-06-28 06:06:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:36 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:36 --> 404 Page Not Found: Machine/images
DEBUG - 2016-06-28 06:06:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:37 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:06:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:37 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:06:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:37 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:06:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:06:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:06:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:06:52 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:06:52 --> Total execution time: 0.1213
DEBUG - 2016-06-28 06:06:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:52 --> 404 Page Not Found: Machine/images
DEBUG - 2016-06-28 06:06:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:52 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:06:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:53 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:06:53 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:53 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:53 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:06:54 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:06:54 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:06:54 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:06:54 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:06:54 --> Total execution time: 0.1188
DEBUG - 2016-06-28 06:06:55 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:55 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:55 --> 404 Page Not Found: Machine/images
DEBUG - 2016-06-28 06:06:55 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:55 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:55 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:06:55 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:55 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:55 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:06:55 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:55 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:55 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:06:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:06:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:06:58 --> 404 Page Not Found: Machine/images
DEBUG - 2016-06-28 06:07:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:07:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:07:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:07:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:07:15 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:07:15 --> Total execution time: 0.1225
DEBUG - 2016-06-28 06:07:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:07:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:07:15 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:07:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:07:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:07:15 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:07:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:07:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:07:15 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:07:17 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:07:17 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:07:17 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:07:17 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:07:17 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:07:17 --> Total execution time: 0.1200
DEBUG - 2016-06-28 06:07:17 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:07:17 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:07:17 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:07:17 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:07:17 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:07:17 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:07:17 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:07:17 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:07:17 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:08:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:08:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:08:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:08:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:08:36 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
ERROR - 2016-06-28 06:08:36 --> Severity: Notice --> Use of undefined constant HTTP_HOST - assumed 'HTTP_HOST' C:\xampp\htdocs\vdash\application\views\themes\default\layouts\default.php 39
DEBUG - 2016-06-28 06:08:36 --> Total execution time: 0.1342
DEBUG - 2016-06-28 06:08:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:08:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:08:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:08:37 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:08:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:08:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:08:37 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:08:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:08:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:08:37 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:09:16 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:09:16 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:09:16 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:09:16 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
ERROR - 2016-06-28 06:09:16 --> Severity: Notice --> Use of undefined constant HTTP_HOST - assumed 'HTTP_HOST' C:\xampp\htdocs\vdash\application\views\themes\default\layouts\default.php 39
DEBUG - 2016-06-28 06:09:16 --> Total execution time: 0.1494
DEBUG - 2016-06-28 06:09:16 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:17 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:17 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:09:17 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:09:17 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:17 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:09:17 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:09:17 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:17 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:09:17 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:09:18 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:09:18 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:09:18 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:09:18 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
ERROR - 2016-06-28 06:09:18 --> Severity: Notice --> Use of undefined constant HTTP_HOST - assumed 'HTTP_HOST' C:\xampp\htdocs\vdash\application\views\themes\default\layouts\default.php 39
DEBUG - 2016-06-28 06:09:18 --> Total execution time: 0.1320
DEBUG - 2016-06-28 06:09:18 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:09:19 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:09:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:09:19 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:09:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:09:19 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:09:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:09:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:09:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:09:36 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:09:36 --> Total execution time: 0.1216
DEBUG - 2016-06-28 06:09:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:09:37 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:09:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:09:37 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:09:37 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:09:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:09:37 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:10:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:10:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:10:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:10:14 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:10:14 --> Total execution time: 0.1242
DEBUG - 2016-06-28 06:10:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:14 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:14 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:10:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:14 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:14 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:10:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:15 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:10:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:15 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:10:18 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:18 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:19 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:10:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:10:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:10:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:10:29 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:10:29 --> Total execution time: 0.1202
DEBUG - 2016-06-28 06:10:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:29 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:29 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:10:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:29 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:29 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:10:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:29 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:29 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:10:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:29 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:29 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:10:34 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:34 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:34 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:10:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:59 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:10:59 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:10:59 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:10:59 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:10:59 --> Total execution time: 0.1230
DEBUG - 2016-06-28 06:10:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:59 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:59 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:10:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:59 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:59 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:10:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:10:59 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:10:59 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:10:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:00 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:00 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:11:00 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:11:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:11:01 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:11:01 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:11:01 --> Total execution time: 0.1333
DEBUG - 2016-06-28 06:11:01 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:01 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:01 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:11:01 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:01 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:01 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:11:01 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:01 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:01 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:11:01 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:01 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:01 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:11:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:03 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:03 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:11:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:11:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:11:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:11:38 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:11:38 --> Total execution time: 0.1321
DEBUG - 2016-06-28 06:11:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:39 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:39 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:11:39 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:39 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:39 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:11:39 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:39 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:39 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:11:39 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:39 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:39 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:11:41 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:11:41 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:11:41 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:12:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:56 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:12:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:12:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:12:56 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:12:56 --> Total execution time: 0.1239
DEBUG - 2016-06-28 06:12:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:56 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:12:56 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:12:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:56 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:12:56 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:12:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:56 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:12:56 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:12:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:56 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:12:56 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:12:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:12:58 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:12:58 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:12:58 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:12:58 --> Total execution time: 0.1227
DEBUG - 2016-06-28 06:12:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:12:58 --> 404 Page Not Found: Machine/vdash
DEBUG - 2016-06-28 06:12:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:12:58 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:12:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:12:58 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:12:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:12:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:12:58 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:13:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:13:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:13:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:13:13 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:13:13 --> Total execution time: 0.1213
DEBUG - 2016-06-28 06:13:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:13 --> 404 Page Not Found: Machine/localhostvdash
DEBUG - 2016-06-28 06:13:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:13 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:13:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:13 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:13:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:13 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:13:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:13:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:13:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:13:14 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:13:14 --> Total execution time: 0.1229
DEBUG - 2016-06-28 06:13:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:14 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:14 --> 404 Page Not Found: Machine/localhostvdash
DEBUG - 2016-06-28 06:13:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:14 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:14 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:13:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:14 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:14 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:13:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:14 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:14 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:13:16 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:16 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:16 --> 404 Page Not Found: Machine/localhostvdash
DEBUG - 2016-06-28 06:13:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:31 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:31 --> 404 Page Not Found: Machine/localhostvdash
DEBUG - 2016-06-28 06:13:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:32 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:13:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:13:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:13:32 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:13:32 --> Total execution time: 0.1282
DEBUG - 2016-06-28 06:13:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:32 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:32 --> 404 Page Not Found: Machine/localhost
DEBUG - 2016-06-28 06:13:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:32 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:32 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:13:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:32 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:32 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:13:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:33 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:33 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:13:35 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:35 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:35 --> 404 Page Not Found: Machine/localhost
DEBUG - 2016-06-28 06:13:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:13:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:13:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:13:52 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:13:52 --> Total execution time: 0.1268
DEBUG - 2016-06-28 06:13:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:52 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:13:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:52 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:13:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:52 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:13:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:56 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:13:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:13:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:13:56 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 06:13:56 --> Total execution time: 0.1393
DEBUG - 2016-06-28 06:13:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:56 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:56 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:13:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:13:56 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:13:56 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:30:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:30:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:30:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:30:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:30:29 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 06:30:29 --> Total execution time: 0.1439
DEBUG - 2016-06-28 06:30:30 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:30:30 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:30:30 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:30:30 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:30:30 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:30:30 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:30:44 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:30:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:30:44 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:30:45 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:30:45 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 06:30:45 --> Total execution time: 0.1256
DEBUG - 2016-06-28 06:30:45 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:30:45 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:30:45 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:30:45 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:30:45 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:30:45 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:31:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:31:19 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:31:19 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:31:19 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 06:31:19 --> Total execution time: 0.1245
DEBUG - 2016-06-28 06:31:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:19 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:31:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:19 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:31:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:32 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:31:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:31:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:31:32 --> Listing query: SELECT `users`.*, `businesses`.*, (
			SELECT MAX(user_sessions.user_session_start)
			FROM user_sessions
			WHERE user_sessions.user_id = users.user_id
		) AS last_logged_in, (
			SELECT SUM(user_sessions.user_session_duration)
			FROM user_sessions
			WHERE user_sessions.user_id = users.user_id AND
				user_sessions.user_session_duration IS NOT NULL
		) AS usage_duration
FROM `users`
JOIN `businesses` ON `users`.`business_id` = `businesses`.`business_id`
ORDER BY `users`.`user_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 06:31:32 --> Total execution time: 0.1800
DEBUG - 2016-06-28 06:31:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:32 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:32 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:31:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:32 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:32 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:31:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:32 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:32 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:31:35 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:31:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:31:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:31:36 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\licenseadd.php 48
ERROR - 2016-06-28 06:31:36 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 06:31:36 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 06:31:36 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 06:31:36 --> Could not find the language line "page_title_license/add"
DEBUG - 2016-06-28 06:31:36 --> Total execution time: 0.1522
DEBUG - 2016-06-28 06:31:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:36 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:36 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:31:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:36 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:36 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:31:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:31:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:31:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:31:38 --> Could not find the language line "on"
ERROR - 2016-06-28 06:31:38 --> Could not find the language line "off"
DEBUG - 2016-06-28 06:31:38 --> Total execution time: 0.2792
DEBUG - 2016-06-28 06:31:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:38 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:38 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:31:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:38 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:38 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:31:39 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:31:39 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:31:39 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:37:02 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:37:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:37:02 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:37:02 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:37:02 --> Could not find the language line "on"
ERROR - 2016-06-28 06:37:02 --> Could not find the language line "off"
DEBUG - 2016-06-28 06:37:02 --> Total execution time: 0.1313
DEBUG - 2016-06-28 06:37:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:37:03 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:37:03 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:37:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:37:03 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:37:03 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:37:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:37:03 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:37:03 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:37:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:37:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:37:04 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:37:04 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:37:04 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 06:37:04 --> Total execution time: 0.1242
DEBUG - 2016-06-28 06:37:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:37:04 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:37:04 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:37:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:37:04 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:37:04 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:42:06 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:06 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:42:07 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:42:07 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:42:07 --> Could not find the language line "on"
ERROR - 2016-06-28 06:42:07 --> Could not find the language line "off"
DEBUG - 2016-06-28 06:42:07 --> Total execution time: 0.1439
DEBUG - 2016-06-28 06:42:07 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:07 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:42:07 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:42:07 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:07 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:42:07 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:42:07 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:07 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:42:07 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:42:08 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:08 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:42:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:42:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:42:08 --> Could not find the language line "on"
ERROR - 2016-06-28 06:42:08 --> Could not find the language line "off"
DEBUG - 2016-06-28 06:42:08 --> Total execution time: 0.2715
DEBUG - 2016-06-28 06:42:08 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:08 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:42:08 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:42:08 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:08 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:42:08 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:42:08 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:08 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:42:08 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:42:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:10 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:42:10 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:42:10 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:42:10 --> Listing query: SELECT *
FROM `businesses`
ORDER BY `business_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 06:42:10 --> Total execution time: 0.1952
DEBUG - 2016-06-28 06:42:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:10 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:42:10 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:42:11 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:42:11 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:42:11 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:43:00 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:43:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:43:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:43:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:43:00 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\licenseadd.php 48
ERROR - 2016-06-28 06:43:00 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 06:43:00 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 06:43:00 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 06:43:00 --> Could not find the language line "page_title_license/add"
DEBUG - 2016-06-28 06:43:00 --> Total execution time: 0.1765
DEBUG - 2016-06-28 06:43:01 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:43:01 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:43:01 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:43:01 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:43:01 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:43:01 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:43:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:43:32 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:43:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:43:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:43:32 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\licenseadd.php 48
ERROR - 2016-06-28 06:43:32 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 06:43:32 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 06:43:32 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 06:43:32 --> Could not find the language line "page_title_license/add"
DEBUG - 2016-06-28 06:43:32 --> Total execution time: 0.1707
DEBUG - 2016-06-28 06:43:33 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:43:33 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:43:33 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:43:33 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:43:33 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:43:33 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:48:43 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:48:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:48:43 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:48:43 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:48:43 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 06:48:43 --> Total execution time: 0.1836
DEBUG - 2016-06-28 06:48:43 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:48:43 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:48:43 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:48:43 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:48:43 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:48:43 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:50:30 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:50:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:50:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:50:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:50:31 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 06:50:31 --> Total execution time: 0.1294
DEBUG - 2016-06-28 06:50:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:50:31 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:50:31 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:50:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:50:31 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:50:31 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:51:20 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:20 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:51:20 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:51:20 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:51:20 --> Total execution time: 0.1317
DEBUG - 2016-06-28 06:51:20 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:20 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:20 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:51:20 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:20 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:20 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:51:23 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:51:23 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:51:23 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:51:23 --> Could not find the language line "on"
ERROR - 2016-06-28 06:51:23 --> Could not find the language line "off"
DEBUG - 2016-06-28 06:51:23 --> Total execution time: 0.1185
DEBUG - 2016-06-28 06:51:23 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:23 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:23 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:51:23 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:23 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:23 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:51:23 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:23 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:23 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:51:24 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:51:24 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:51:24 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:51:24 --> Could not find the language line "on"
ERROR - 2016-06-28 06:51:24 --> Could not find the language line "off"
DEBUG - 2016-06-28 06:51:24 --> Total execution time: 0.1310
DEBUG - 2016-06-28 06:51:24 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:24 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:24 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:51:24 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:24 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:24 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:51:24 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:24 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:24 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:51:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:51:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:51:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 06:51:27 --> Could not find the language line "on"
ERROR - 2016-06-28 06:51:27 --> Could not find the language line "off"
DEBUG - 2016-06-28 06:51:27 --> Total execution time: 0.1162
DEBUG - 2016-06-28 06:51:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:27 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:27 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:51:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:27 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:27 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:51:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:27 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:27 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:51:28 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:28 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:51:28 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:51:28 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:51:28 --> Total execution time: 0.1531
DEBUG - 2016-06-28 06:51:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:29 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:29 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:51:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:29 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:29 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:51:30 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:51:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:51:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:51:30 --> Total execution time: 0.1854
DEBUG - 2016-06-28 06:51:30 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:51:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:51:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:51:30 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:51:30 --> Total execution time: 0.1698
DEBUG - 2016-06-28 06:51:30 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:31 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:31 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:51:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:31 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:31 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:51:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:31 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:31 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:51:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:31 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:31 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:51:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:31 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:51:31 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:51:33 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:51:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:51:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:51:33 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:51:33 --> Total execution time: 0.1572
DEBUG - 2016-06-28 06:51:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:51:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:51:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:51:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:51:36 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:51:38 --> Total execution time: 2.3967
DEBUG - 2016-06-28 06:59:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:59:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:59:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:59:53 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:59:53 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:59:53 --> Total execution time: 0.1617
DEBUG - 2016-06-28 06:59:53 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:59:53 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:59:53 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 06:59:53 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:59:53 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:59:53 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 06:59:53 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:59:53 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 06:59:53 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-28 06:59:54 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 06:59:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 06:59:54 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 06:59:54 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 06:59:54 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 06:59:55 --> Total execution time: 0.8933
DEBUG - 2016-06-28 07:00:39 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:00:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 07:00:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 07:00:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 07:00:39 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 07:00:40 --> Total execution time: 0.8362
DEBUG - 2016-06-28 07:00:40 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:00:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 07:00:40 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 07:00:40 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 07:00:40 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 07:00:41 --> Total execution time: 1.0237
DEBUG - 2016-06-28 07:02:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:02:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 07:02:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 07:02:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 07:02:36 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 07:02:36 --> Total execution time: 0.8833
DEBUG - 2016-06-28 07:02:50 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:02:50 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 07:02:50 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 07:02:50 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 07:02:50 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 07:02:51 --> Total execution time: 0.8504
DEBUG - 2016-06-28 07:03:02 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:03:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 07:03:02 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 07:03:02 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 07:03:02 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 07:03:03 --> Total execution time: 0.9252
DEBUG - 2016-06-28 07:04:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:04:31 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 07:04:31 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 07:04:31 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 07:04:31 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 07:04:32 --> Total execution time: 0.8897
DEBUG - 2016-06-28 07:04:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:04:32 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 07:04:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 07:04:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 07:04:32 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-28 07:04:33 --> Total execution time: 1.3189
DEBUG - 2016-06-28 07:19:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:19:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 07:19:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 07:19:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 07:19:38 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 07:19:38 --> Total execution time: 0.2153
DEBUG - 2016-06-28 07:19:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:19:38 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 07:19:38 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 07:19:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:19:38 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 07:19:38 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 07:49:21 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:49:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 07:49:21 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 07:49:21 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 07:49:21 --> Total execution time: 0.2057
DEBUG - 2016-06-28 07:49:21 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:49:21 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 07:49:22 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 07:49:22 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 07:49:22 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 07:49:22 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 08:14:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 08:14:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 08:14:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 08:14:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 08:14:29 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\licenseadd.php 48
ERROR - 2016-06-28 08:14:29 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 08:14:29 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 08:14:29 --> Could not find the language line "page_title_license/add"
ERROR - 2016-06-28 08:14:29 --> Could not find the language line "page_title_license/add"
DEBUG - 2016-06-28 08:14:29 --> Total execution time: 0.1975
DEBUG - 2016-06-28 08:14:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 08:14:29 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 08:14:29 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-28 08:14:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 08:14:29 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-28 08:14:29 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-28 09:14:05 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:14:05 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:14:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:14:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:14:05 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:14:05 --> Total execution time: 0.1888
DEBUG - 2016-06-28 09:45:12 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:12 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:12 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:12 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:12 --> Total execution time: 0.3569
DEBUG - 2016-06-28 09:45:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:14 --> Listing query: SELECT `users`.*, `businesses`.*, (
			SELECT MAX(user_sessions.user_session_start)
			FROM user_sessions
			WHERE user_sessions.user_id = users.user_id
		) AS last_logged_in, (
			SELECT SUM(user_sessions.user_session_duration)
			FROM user_sessions
			WHERE user_sessions.user_id = users.user_id AND
				user_sessions.user_session_duration IS NOT NULL
		) AS usage_duration
FROM `users`
JOIN `businesses` ON `users`.`business_id` = `businesses`.`business_id`
ORDER BY `users`.`user_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:45:14 --> Total execution time: 0.1605
DEBUG - 2016-06-28 09:45:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:45:15 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:45:15 --> Total execution time: 0.1563
DEBUG - 2016-06-28 09:45:20 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:20 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:20 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:20 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:20 --> Total execution time: 0.1716
DEBUG - 2016-06-28 09:45:25 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:25 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:25 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:25 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-28 09:45:25 --> Total execution time: 0.1610
DEBUG - 2016-06-28 09:45:26 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:26 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:26 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:26 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-28 09:45:26 --> Total execution time: 0.1240
DEBUG - 2016-06-28 09:45:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:27 --> Listing query: SELECT *
FROM `businesses`
ORDER BY `business_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:45:27 --> Total execution time: 0.1260
DEBUG - 2016-06-28 09:45:28 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:28 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:28 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:28 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:28 --> Total execution time: 0.1221
DEBUG - 2016-06-28 09:45:33 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:33 --> Total execution time: 0.1159
DEBUG - 2016-06-28 09:45:35 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:35 --> Total execution time: 0.1126
DEBUG - 2016-06-28 09:45:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:45:38 --> Could not find the language line "on"
ERROR - 2016-06-28 09:45:38 --> Could not find the language line "off"
DEBUG - 2016-06-28 09:45:38 --> Total execution time: 0.1714
DEBUG - 2016-06-28 09:45:39 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:45:39 --> Could not find the language line "on"
ERROR - 2016-06-28 09:45:39 --> Could not find the language line "off"
DEBUG - 2016-06-28 09:45:39 --> Total execution time: 0.1392
DEBUG - 2016-06-28 09:45:42 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:42 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:42 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:42 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:42 --> Total execution time: 0.0986
DEBUG - 2016-06-28 09:45:51 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:51 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:51 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:51 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:51 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-28 09:45:51 --> Total execution time: 0.1264
DEBUG - 2016-06-28 09:45:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:52 --> Listing query: SELECT *
FROM `businesses`
ORDER BY `business_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:45:52 --> Total execution time: 0.1214
DEBUG - 2016-06-28 09:45:53 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:53 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:53 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:53 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:53 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-28 09:45:53 --> Total execution time: 0.1232
DEBUG - 2016-06-28 09:45:54 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:45:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:45:55 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:45:55 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:45:55 --> Total execution time: 0.1739
DEBUG - 2016-06-28 09:46:02 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:46:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:46:02 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:46:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:46:03 --> Total execution time: 0.1212
DEBUG - 2016-06-28 09:46:41 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:46:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:46:41 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:46:41 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:46:41 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:46:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:46:41 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:46:41 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:46:42 --> Listing query: SELECT *
FROM `sys_users`
WHERE `business_id` = 1
ORDER BY `sys_user_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:46:42 --> Total execution time: 0.1603
DEBUG - 2016-06-28 09:46:46 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:46:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:46:46 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:46:46 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:46:46 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-28 09:46:46 --> Total execution time: 0.1264
DEBUG - 2016-06-28 09:46:47 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:46:47 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:46:47 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:46:47 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:46:47 --> Total execution time: 0.1512
DEBUG - 2016-06-28 09:46:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:46:59 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:00 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:00 --> Total execution time: 0.1015
DEBUG - 2016-06-28 09:47:08 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:08 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:08 --> Listing query: SELECT *
FROM `sys_users`
WHERE `business_id` = 1
ORDER BY `sys_user_name` ASC
 LIMIT 10
ERROR - 2016-06-28 09:47:08 --> Could not find the language line "first"
ERROR - 2016-06-28 09:47:08 --> Could not find the language line "last"
DEBUG - 2016-06-28 09:47:08 --> Total execution time: 0.2483
DEBUG - 2016-06-28 09:47:11 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:11 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:11 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:11 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:11 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:11 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:47:11 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:47:11 --> Total execution time: 0.1484
DEBUG - 2016-06-28 09:47:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:47:14 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:47:14 --> Total execution time: 0.1416
DEBUG - 2016-06-28 09:47:18 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:18 --> No URI present. Default controller set.
DEBUG - 2016-06-28 09:47:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:18 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:18 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:18 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:18 --> No URI present. Default controller set.
DEBUG - 2016-06-28 09:47:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:18 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:18 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:18 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:18 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:18 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:47:18 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:47:18 --> Total execution time: 0.1394
DEBUG - 2016-06-28 09:47:23 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:23 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:23 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:23 --> Total execution time: 0.1085
DEBUG - 2016-06-28 09:47:25 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:25 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:25 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:25 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:25 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:25 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:25 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:25 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:25 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:47:25 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:47:25 --> Total execution time: 0.1338
DEBUG - 2016-06-28 09:47:33 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:33 --> No URI present. Default controller set.
DEBUG - 2016-06-28 09:47:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:33 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:47:33 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:47:33 --> Total execution time: 0.1600
DEBUG - 2016-06-28 09:47:34 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:34 --> No URI present. Default controller set.
DEBUG - 2016-06-28 09:47:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:34 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:34 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:34 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:34 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:34 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:47:34 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:47:34 --> Total execution time: 0.1334
DEBUG - 2016-06-28 09:47:44 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:44 --> No URI present. Default controller set.
DEBUG - 2016-06-28 09:47:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:45 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:45 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:47:45 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 09:47:45 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 09:47:45 --> Could not find the language line "page_title_"
ERROR - 2016-06-28 09:47:45 --> Could not find the language line "page_title_"
DEBUG - 2016-06-28 09:47:45 --> Total execution time: 0.2587
DEBUG - 2016-06-28 09:47:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:47:52 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:47:52 --> Total execution time: 0.1357
DEBUG - 2016-06-28 09:47:57 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:57 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:57 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:57 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:57 --> Listing query: SELECT apps.*, (
				SELECT COUNT(*) AS concurrent_count
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id
				GROUP BY app_session_starter_id
				ORDER BY concurrent_count DESC
				LIMIT 1
			) AS concurrent_instances, (
				SELECT COUNT(*) AS instances
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id AND
				  DATE(app_sessions.app_start) BETWEEN "2016-06-27" AND "2016-07-03"
			) AS this_week_instances, (
				SELECT COUNT(*) AS instances
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id AND
				  DATE(app_sessions.app_start) BETWEEN "2016-06-1" AND "2016-06-30"
			) AS this_month_instances
FROM `apps`
WHERE `apps`.`business_id` = 1
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:47:57 --> Total execution time: 0.2544
DEBUG - 2016-06-28 09:47:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:58 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:58 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:58 --> Listing query: SELECT *
FROM `apps`
WHERE `apps`.`business_id` = 1
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:47:58 --> Total execution time: 0.2233
DEBUG - 2016-06-28 09:47:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:59 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:59 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:47:59 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:47:59 --> Total execution time: 0.1950
DEBUG - 2016-06-28 09:47:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:47:59 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:47:59 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:00 --> Total execution time: 0.1714
DEBUG - 2016-06-28 09:48:00 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:00 --> Listing query: SELECT *
FROM `apps`
WHERE `apps`.`business_id` = 1
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:48:00 --> Total execution time: 0.1412
DEBUG - 2016-06-28 09:48:02 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:02 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:02 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:03 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:48:03 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:48:03 --> Total execution time: 0.1422
DEBUG - 2016-06-28 09:48:07 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:07 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:07 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:07 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:07 --> Total execution time: 0.1105
DEBUG - 2016-06-28 09:48:08 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:08 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:08 --> Total execution time: 0.1445
DEBUG - 2016-06-28 09:48:08 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:08 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:08 --> Listing query: SELECT apps.*, (
				SELECT COUNT(*) AS concurrent_count
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id
				GROUP BY app_session_starter_id
				ORDER BY concurrent_count DESC
				LIMIT 1
			) AS concurrent_instances, (
				SELECT COUNT(*) AS instances
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id AND
				  DATE(app_sessions.app_start) BETWEEN "2016-06-27" AND "2016-07-03"
			) AS this_week_instances, (
				SELECT COUNT(*) AS instances
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id AND
				  DATE(app_sessions.app_start) BETWEEN "2016-06-1" AND "2016-06-30"
			) AS this_month_instances
FROM `apps`
WHERE `apps`.`business_id` = 1
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:48:08 --> Total execution time: 0.1352
DEBUG - 2016-06-28 09:48:09 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:09 --> Listing query: SELECT *
FROM `apps`
WHERE `apps`.`business_id` = 1
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:48:09 --> Total execution time: 0.1300
DEBUG - 2016-06-28 09:48:11 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:11 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:11 --> Listing query: SELECT `machine_groups`.*, `businesses`.`business_name`, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id
			) AS total_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status <> "offline"
			) AS online_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status = "offline"
			) AS offline_machines
FROM `machine_groups`
JOIN `businesses` ON `machine_groups`.`business_id` = `businesses`.`business_id`
WHERE `machine_groups`.`business_id` = 1
 LIMIT 10
DEBUG - 2016-06-28 09:48:11 --> Total execution time: 0.2113
DEBUG - 2016-06-28 09:48:12 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:12 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:12 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:12 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:12 --> Listing query: SELECT *
FROM `machines`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
WHERE `machines`.`business_id` = 1
ORDER BY `machines`.`machine_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 09:48:12 --> Total execution time: 0.1881
DEBUG - 2016-06-28 09:48:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:13 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
WHERE `machines`.`business_id` = 1
 LIMIT 10
DEBUG - 2016-06-28 09:48:13 --> Total execution time: 0.1372
DEBUG - 2016-06-28 09:48:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:15 --> Listing query: SELECT `machine_groups`.*, `businesses`.`business_name`, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id
			) AS total_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status <> "offline"
			) AS online_machines, (
				SELECT COUNT(*)
				FROM machines
				WHERE machines.machine_group_id = machine_groups.machine_group_id AND
					machines.machine_status = "offline"
			) AS offline_machines
FROM `machine_groups`
JOIN `businesses` ON `machine_groups`.`business_id` = `businesses`.`business_id`
WHERE `machine_groups`.`business_id` = 1
 LIMIT 10
DEBUG - 2016-06-28 09:48:15 --> Total execution time: 0.1301
DEBUG - 2016-06-28 09:48:16 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:16 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:16 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:16 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:16 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:16 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:48:16 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:48:16 --> Total execution time: 0.1510
DEBUG - 2016-06-28 09:48:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:48:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:48:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:48:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:48:27 --> Total execution time: 0.1064
DEBUG - 2016-06-28 09:51:00 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:51:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:51:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:51:00 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:51:00 --> Total execution time: 0.2471
DEBUG - 2016-06-28 09:51:05 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:51:05 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:51:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:51:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 09:51:05 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 09:51:05 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 09:51:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 09:51:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 09:51:05 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 09:51:05 --> Total execution time: 0.1336
DEBUG - 2016-06-28 11:15:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 11:15:05 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 11:15:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 11:15:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 11:15:06 --> Total execution time: 1.4914
DEBUG - 2016-06-28 11:15:09 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 11:15:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 11:15:10 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 11:15:10 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-28 11:15:10 --> Listing query: SELECT *
FROM `machines`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
ORDER BY `machines`.`machine_name` ASC
 LIMIT 10
DEBUG - 2016-06-28 11:15:10 --> Total execution time: 0.4269
DEBUG - 2016-06-28 11:20:30 --> UTF-8 Support Enabled
DEBUG - 2016-06-28 11:20:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-28 11:20:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-28 11:20:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-28 11:20:30 --> Severity: Notice --> Undefined variable: pesan C:\xampp\htdocs\vdash\application\views\themes\default\dashboard.php 349
DEBUG - 2016-06-28 11:20:30 --> Total execution time: 0.4181
