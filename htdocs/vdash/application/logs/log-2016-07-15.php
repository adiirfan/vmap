<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2016-07-15 03:14:32 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:32 --> No URI present. Default controller set.
DEBUG - 2016-07-15 03:14:32 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 03:14:32 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 03:14:32 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 03:14:32 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 03:14:32 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 03:14:32 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 03:14:32 --> Could not find the language line "page_title_"
DEBUG - 2016-07-15 03:14:32 --> Total execution time: 0.0360
DEBUG - 2016-07-15 03:14:33 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:33 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-07-15 03:14:33 --> 404 Page Not Found: Faviconico/index
DEBUG - 2016-07-15 03:14:38 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 03:14:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 03:14:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 03:14:39 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 03:14:39 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 03:14:39 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 03:14:39 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 03:14:39 --> Total execution time: 0.0516
DEBUG - 2016-07-15 03:14:44 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 03:14:44 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 03:14:44 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 03:14:44 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-07-15 03:14:44 --> Total execution time: 0.0420
DEBUG - 2016-07-15 03:14:48 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:48 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 03:14:48 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 03:14:48 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 03:14:48 --> Listing query: SELECT `machine_groups`.*, `businesses`.`business_name`, (
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
DEBUG - 2016-07-15 03:14:48 --> Total execution time: 0.0425
DEBUG - 2016-07-15 03:14:51 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:51 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 03:14:51 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 03:14:51 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 03:14:51 --> Listing query: SELECT *
FROM `machines`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
ORDER BY `machines`.`machine_name` ASC
 LIMIT 10
DEBUG - 2016-07-15 03:14:51 --> Total execution time: 0.0421
DEBUG - 2016-07-15 03:14:54 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 03:14:54 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 03:14:54 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 03:14:54 --> Total execution time: 0.0627
DEBUG - 2016-07-15 03:14:55 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:55 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 03:14:55 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 03:14:55 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 03:14:55 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 03:14:55 --> Total execution time: 0.0519
DEBUG - 2016-07-15 03:14:58 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 03:14:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 03:14:58 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 03:14:58 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 03:14:58 --> Total execution time: 0.0484
DEBUG - 2016-07-15 06:48:01 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 06:48:01 --> No URI present. Default controller set.
DEBUG - 2016-07-15 06:48:01 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 06:48:01 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 06:48:01 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 06:48:01 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 06:48:01 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 06:48:01 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 06:48:01 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 06:48:01 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 06:48:01 --> Total execution time: 0.0719
DEBUG - 2016-07-15 06:48:04 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 06:48:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 06:48:04 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 06:48:05 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 06:48:05 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 06:48:05 --> Total execution time: 0.0520
DEBUG - 2016-07-15 06:49:25 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 06:49:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 06:49:25 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 06:49:25 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 06:49:25 --> Listing query: SELECT *
FROM `businesses`
ORDER BY `business_name` ASC
 LIMIT 10
ERROR - 2016-07-15 06:49:25 --> Could not find the language line "first"
ERROR - 2016-07-15 06:49:25 --> Could not find the language line "last"
DEBUG - 2016-07-15 06:49:25 --> Total execution time: 0.0440
DEBUG - 2016-07-15 06:49:29 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 06:49:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 06:49:29 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 06:49:29 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 06:49:29 --> Listing query: SELECT *
FROM `sys_users`
WHERE `business_id` = 1
ORDER BY `sys_user_name` ASC
 LIMIT 10
ERROR - 2016-07-15 06:49:29 --> Could not find the language line "first"
ERROR - 2016-07-15 06:49:29 --> Could not find the language line "last"
DEBUG - 2016-07-15 06:49:29 --> Total execution time: 0.0494
DEBUG - 2016-07-15 06:49:31 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 06:49:31 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 06:49:31 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 06:49:31 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 06:49:31 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 06:49:31 --> Total execution time: 0.0417
DEBUG - 2016-07-15 06:49:33 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 06:49:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 06:49:33 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 06:49:33 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 06:49:33 --> Total execution time: 0.0475
DEBUG - 2016-07-15 06:49:34 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 06:49:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 06:49:34 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 06:49:34 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 06:49:34 --> Total execution time: 0.0467
DEBUG - 2016-07-15 06:49:38 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 06:49:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 06:49:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 06:49:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 06:49:38 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 06:49:38 --> Total execution time: 0.0409
DEBUG - 2016-07-15 08:08:04 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:08:04 --> No URI present. Default controller set.
DEBUG - 2016-07-15 08:08:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:08:04 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:08:04 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:08:04 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:08:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:08:04 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:08:04 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:08:04 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 08:08:04 --> Total execution time: 0.0523
DEBUG - 2016-07-15 08:08:14 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:08:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:08:14 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:08:14 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:08:14 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/licenseadd.php 48
ERROR - 2016-07-15 08:08:14 --> Could not find the language line "page_title_license/add"
ERROR - 2016-07-15 08:08:14 --> Could not find the language line "page_title_license/add"
ERROR - 2016-07-15 08:08:14 --> Could not find the language line "page_title_license/add"
ERROR - 2016-07-15 08:08:14 --> Could not find the language line "page_title_license/add"
DEBUG - 2016-07-15 08:08:14 --> Total execution time: 0.0389
DEBUG - 2016-07-15 08:08:23 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:08:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:08:23 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:08:23 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:08:23 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 08:08:23 --> Total execution time: 0.0412
DEBUG - 2016-07-15 08:08:35 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:08:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:08:35 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:08:35 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:08:35 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 08:08:35 --> Total execution time: 0.0528
DEBUG - 2016-07-15 08:13:22 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:13:22 --> No URI present. Default controller set.
DEBUG - 2016-07-15 08:13:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:13:22 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:13:22 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:13:22 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:13:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:13:22 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:13:22 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:13:22 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 08:13:22 --> Total execution time: 0.0702
DEBUG - 2016-07-15 08:40:42 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:40:42 --> No URI present. Default controller set.
DEBUG - 2016-07-15 08:40:42 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:40:42 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:40:42 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:40:42 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 08:40:42 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 08:40:42 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 08:40:42 --> Could not find the language line "page_title_"
DEBUG - 2016-07-15 08:40:42 --> Total execution time: 0.0341
DEBUG - 2016-07-15 08:40:48 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:40:48 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-07-15 08:40:48 --> 404 Page Not Found: Api/index
DEBUG - 2016-07-15 08:40:53 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:40:53 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-07-15 08:40:53 --> 404 Page Not Found: Api/index
DEBUG - 2016-07-15 08:48:09 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:09 --> No URI present. Default controller set.
DEBUG - 2016-07-15 08:48:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:09 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:09 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:48:09 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 08:48:09 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 08:48:09 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 08:48:09 --> Could not find the language line "page_title_"
DEBUG - 2016-07-15 08:48:09 --> Total execution time: 0.0427
DEBUG - 2016-07-15 08:48:09 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:09 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-07-15 08:48:09 --> 404 Page Not Found: Faviconico/index
DEBUG - 2016-07-15 08:48:15 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:15 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:15 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:48:15 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:15 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:15 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:48:15 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 08:48:15 --> Total execution time: 0.0551
DEBUG - 2016-07-15 08:48:21 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:21 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:21 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:48:21 --> Total execution time: 0.0482
DEBUG - 2016-07-15 08:48:24 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:24 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:24 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:48:24 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 08:48:24 --> Total execution time: 0.0516
DEBUG - 2016-07-15 08:48:26 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:26 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:26 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:27 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:48:27 --> Total execution time: 0.0486
DEBUG - 2016-07-15 08:48:27 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:27 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:27 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:48:27 --> Total execution time: 0.0436
DEBUG - 2016-07-15 08:48:28 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:28 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:28 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:28 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:48:28 --> Listing query: SELECT *
FROM `apps`
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-07-15 08:48:28 --> Total execution time: 0.0457
DEBUG - 2016-07-15 08:48:30 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:30 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:30 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:48:30 --> Could not find the language line "on"
ERROR - 2016-07-15 08:48:30 --> Could not find the language line "off"
DEBUG - 2016-07-15 08:48:30 --> Total execution time: 0.0398
DEBUG - 2016-07-15 08:48:33 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:33 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:33 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:48:33 --> Total execution time: 0.0658
DEBUG - 2016-07-15 08:48:35 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:35 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:35 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:48:35 --> Total execution time: 0.0447
DEBUG - 2016-07-15 08:48:36 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:36 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:36 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 08:48:36 --> Total execution time: 0.0389
DEBUG - 2016-07-15 08:48:38 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:48:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:48:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:48:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:48:38 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 08:48:38 --> Total execution time: 0.0406
DEBUG - 2016-07-15 08:50:46 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:50:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:50:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:50:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:50:46 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 08:50:46 --> Total execution time: 0.0510
DEBUG - 2016-07-15 08:58:38 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 08:58:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 08:58:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 08:58:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 08:58:38 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 08:58:38 --> Total execution time: 0.0532
DEBUG - 2016-07-15 09:12:12 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:12:12 --> No URI present. Default controller set.
DEBUG - 2016-07-15 09:12:12 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:12:12 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:12:12 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 09:12:12 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 09:12:12 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 09:12:12 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 09:12:12 --> Could not find the language line "page_title_"
DEBUG - 2016-07-15 09:12:12 --> Total execution time: 0.0384
DEBUG - 2016-07-15 09:12:13 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:12:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-07-15 09:12:13 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-07-15 09:12:13 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:12:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-07-15 09:12:13 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-07-15 09:12:13 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:12:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-07-15 09:12:13 --> 404 Page Not Found: Faviconico/index
DEBUG - 2016-07-15 09:29:24 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:29:24 --> No URI present. Default controller set.
DEBUG - 2016-07-15 09:29:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:29:24 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:29:24 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 09:29:24 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 09:29:24 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 09:29:24 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 09:29:24 --> Could not find the language line "page_title_"
DEBUG - 2016-07-15 09:29:24 --> Total execution time: 0.0323
DEBUG - 2016-07-15 09:29:27 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:29:27 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-07-15 09:29:27 --> 404 Page Not Found: Faviconico/index
DEBUG - 2016-07-15 09:35:01 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:35:01 --> No URI present. Default controller set.
DEBUG - 2016-07-15 09:35:01 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:35:01 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:35:01 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 09:35:01 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 09:35:01 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 09:35:01 --> Could not find the language line "page_title_"
ERROR - 2016-07-15 09:35:01 --> Could not find the language line "page_title_"
DEBUG - 2016-07-15 09:35:01 --> Total execution time: 0.0345
DEBUG - 2016-07-15 09:35:09 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:35:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:35:09 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:35:09 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 09:35:10 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:35:10 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:35:10 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:35:10 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 09:35:10 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 09:35:10 --> Total execution time: 0.0526
DEBUG - 2016-07-15 09:35:13 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:35:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:35:13 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:35:13 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-07-15 09:35:13 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-07-15 09:35:13 --> Total execution time: 0.0501
DEBUG - 2016-07-15 09:35:18 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:35:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:35:18 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:35:18 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 09:35:18 --> Total execution time: 0.0376
DEBUG - 2016-07-15 09:35:18 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:35:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:35:18 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:35:18 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 09:35:18 --> Total execution time: 0.0385
DEBUG - 2016-07-15 09:35:21 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:35:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:35:21 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:35:21 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 09:35:21 --> Listing query: SELECT `machine_groups`.*, `businesses`.`business_name`, (
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
DEBUG - 2016-07-15 09:35:21 --> Total execution time: 0.0445
DEBUG - 2016-07-15 09:35:24 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:35:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:35:24 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:35:24 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 09:35:24 --> Listing query: SELECT *
FROM `machines`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
ORDER BY `machines`.`machine_name` ASC
 LIMIT 10
DEBUG - 2016-07-15 09:35:24 --> Total execution time: 0.0512
DEBUG - 2016-07-15 09:35:25 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 09:35:25 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 09:35:25 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 09:35:25 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 09:35:25 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-07-15 09:35:25 --> Total execution time: 0.0504
DEBUG - 2016-07-15 10:16:22 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 10:16:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 10:16:22 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 10:16:23 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 10:16:23 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 10:16:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-07-15 10:16:23 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-07-15 10:16:23 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-07-15 10:16:23 --> Total execution time: 0.0321
DEBUG - 2016-07-15 10:16:23 --> UTF-8 Support Enabled
DEBUG - 2016-07-15 10:16:23 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-07-15 10:16:23 --> 404 Page Not Found: Faviconico/index
