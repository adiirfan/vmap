<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2016-06-02 08:53:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 08:53:29 --> No URI present. Default controller set.
DEBUG - 2016-06-02 08:53:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 08:53:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
ERROR - 2016-06-02 08:53:29 --> Severity: Warning --> mysqli::real_connect(): (HY000/1045): Access denied for user 'root'@'localhost' (using password: NO) C:\xampp\htdocs\vdash\system\database\drivers\mysqli\mysqli_driver.php 135
ERROR - 2016-06-02 08:53:29 --> Unable to connect to the database
DEBUG - 2016-06-02 08:55:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 08:55:13 --> No URI present. Default controller set.
DEBUG - 2016-06-02 08:55:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 08:55:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
ERROR - 2016-06-02 08:55:13 --> Severity: Warning --> mysqli::real_connect(): (HY000/1045): Access denied for user 'root'@'localhost' (using password: NO) C:\xampp\htdocs\vdash\system\database\drivers\mysqli\mysqli_driver.php 135
ERROR - 2016-06-02 08:55:13 --> Unable to connect to the database
DEBUG - 2016-06-02 08:55:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 08:55:15 --> No URI present. Default controller set.
DEBUG - 2016-06-02 08:55:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 08:55:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
ERROR - 2016-06-02 08:55:15 --> Severity: Warning --> mysqli::real_connect(): (HY000/1045): Access denied for user 'root'@'localhost' (using password: NO) C:\xampp\htdocs\vdash\system\database\drivers\mysqli\mysqli_driver.php 135
ERROR - 2016-06-02 08:55:15 --> Unable to connect to the database
DEBUG - 2016-06-02 08:55:56 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 08:55:56 --> No URI present. Default controller set.
DEBUG - 2016-06-02 08:55:56 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 08:55:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 08:55:56 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-02 08:55:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-02 08:55:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-02 08:55:57 --> Could not find the language line "page_title_"
ERROR - 2016-06-02 08:55:57 --> Could not find the language line "page_title_"
DEBUG - 2016-06-02 08:55:57 --> Total execution time: 0.4809
DEBUG - 2016-06-02 08:56:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 08:56:03 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 08:56:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 08:56:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 08:56:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 08:56:03 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 08:56:04 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 08:56:04 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 08:56:04 --> Total execution time: 0.3885
DEBUG - 2016-06-02 08:57:27 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 08:57:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 08:57:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 08:57:27 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-02 08:57:27 --> Could not find the language line "on"
ERROR - 2016-06-02 08:57:27 --> Could not find the language line "off"
DEBUG - 2016-06-02 08:57:27 --> Total execution time: 0.2918
DEBUG - 2016-06-02 09:00:30 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:00:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:00:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:00:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-02 09:00:30 --> Could not find the language line "on"
ERROR - 2016-06-02 09:00:30 --> Could not find the language line "off"
DEBUG - 2016-06-02 09:00:30 --> Total execution time: 0.2659
DEBUG - 2016-06-02 09:00:35 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:00:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:00:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:00:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:00:35 --> Listing query: SELECT apps.*, (
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
				  DATE(app_sessions.app_start) BETWEEN "2016-05-30" AND "2016-06-05"
			) AS this_week_instances, (
				SELECT COUNT(*) AS instances
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id AND
				  DATE(app_sessions.app_start) BETWEEN "2016-06-1" AND "2016-06-30"
			) AS this_month_instances, `businesses`.`business_name`
FROM `apps`
JOIN `businesses` ON `apps`.`business_id` = `businesses`.`business_id`
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-02 09:00:35 --> Total execution time: 0.2621
DEBUG - 2016-06-02 09:00:35 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:00:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:00:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:00:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:00:35 --> Total execution time: 0.1140
DEBUG - 2016-06-02 09:00:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:00:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:00:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:00:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:00:36 --> Total execution time: 0.1287
DEBUG - 2016-06-02 09:00:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:00:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:00:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:00:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:00:36 --> Listing query: SELECT apps.*, (
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
				  DATE(app_sessions.app_start) BETWEEN "2016-05-30" AND "2016-06-05"
			) AS this_week_instances, (
				SELECT COUNT(*) AS instances
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id AND
				  DATE(app_sessions.app_start) BETWEEN "2016-06-1" AND "2016-06-30"
			) AS this_month_instances, `businesses`.`business_name`
FROM `apps`
JOIN `businesses` ON `apps`.`business_id` = `businesses`.`business_id`
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-02 09:00:36 --> Total execution time: 0.1395
DEBUG - 2016-06-02 09:00:39 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:00:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:00:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:00:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:00:39 --> Total execution time: 0.1185
DEBUG - 2016-06-02 09:02:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:02:31 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:02:31 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:02:31 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:02:31 --> Total execution time: 0.1233
DEBUG - 2016-06-02 09:02:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:02:32 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:02:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:02:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:02:33 --> Total execution time: 0.1331
DEBUG - 2016-06-02 09:02:34 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:02:34 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:02:34 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:02:34 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:02:34 --> Total execution time: 0.1150
DEBUG - 2016-06-02 09:03:28 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:28 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:28 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:28 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:28 --> Total execution time: 0.2226
DEBUG - 2016-06-02 09:03:29 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:29 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:29 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-02 09:03:29 --> Total execution time: 0.1869
DEBUG - 2016-06-02 09:03:30 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:30 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:30 --> Listing query: SELECT `machine_groups`.*, `businesses`.`business_name`, (
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
DEBUG - 2016-06-02 09:03:30 --> Total execution time: 0.2228
DEBUG - 2016-06-02 09:03:31 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:31 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:32 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 09:03:32 --> Total execution time: 0.1748
DEBUG - 2016-06-02 09:03:32 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:32 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:32 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:32 --> Listing query: SELECT *
FROM `businesses`
ORDER BY `business_name` ASC
 LIMIT 10
DEBUG - 2016-06-02 09:03:32 --> Total execution time: 0.1564
DEBUG - 2016-06-02 09:03:33 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:33 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:33 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:33 --> Total execution time: 0.1409
DEBUG - 2016-06-02 09:03:35 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:35 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:35 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:35 --> Total execution time: 0.1294
DEBUG - 2016-06-02 09:03:36 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:36 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:36 --> Listing query: SELECT `users`.*, `businesses`.*, (
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
DEBUG - 2016-06-02 09:03:36 --> Total execution time: 0.1858
DEBUG - 2016-06-02 09:03:38 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:38 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:38 --> Total execution time: 0.1063
DEBUG - 2016-06-02 09:03:39 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:39 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:39 --> Total execution time: 0.1424
DEBUG - 2016-06-02 09:03:39 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:39 --> Listing query: SELECT apps.*, (
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
				  DATE(app_sessions.app_start) BETWEEN "2016-05-30" AND "2016-06-05"
			) AS this_week_instances, (
				SELECT COUNT(*) AS instances
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id AND
				  DATE(app_sessions.app_start) BETWEEN "2016-06-1" AND "2016-06-30"
			) AS this_month_instances, `businesses`.`business_name`
FROM `apps`
JOIN `businesses` ON `apps`.`business_id` = `businesses`.`business_id`
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-02 09:03:39 --> Total execution time: 0.1612
DEBUG - 2016-06-02 09:03:40 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:40 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:40 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:40 --> Listing query: SELECT *
FROM `apps`
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-02 09:03:40 --> Total execution time: 0.1400
DEBUG - 2016-06-02 09:03:41 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:41 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:41 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:42 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:42 --> Listing query: SELECT `machine_groups`.*, `businesses`.`business_name`, (
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
DEBUG - 2016-06-02 09:03:42 --> Total execution time: 0.1353
DEBUG - 2016-06-02 09:03:42 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:42 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:42 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:42 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:42 --> Listing query: SELECT *
FROM `machines`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
ORDER BY `machines`.`machine_name` ASC
 LIMIT 10
DEBUG - 2016-06-02 09:03:42 --> Total execution time: 0.1572
DEBUG - 2016-06-02 09:03:43 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:43 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:43 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:43 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
DEBUG - 2016-06-02 09:03:43 --> Total execution time: 0.1267
DEBUG - 2016-06-02 09:03:44 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:44 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:44 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:03:44 --> Total execution time: 0.1428
DEBUG - 2016-06-02 09:03:45 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:45 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:46 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-02 09:03:46 --> Could not find the language line "on"
ERROR - 2016-06-02 09:03:46 --> Could not find the language line "off"
DEBUG - 2016-06-02 09:03:46 --> Total execution time: 0.2325
DEBUG - 2016-06-02 09:03:46 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:46 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:46 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-02 09:03:46 --> Could not find the language line "on"
ERROR - 2016-06-02 09:03:46 --> Could not find the language line "off"
DEBUG - 2016-06-02 09:03:46 --> Total execution time: 0.1156
DEBUG - 2016-06-02 09:03:46 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:03:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:03:46 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:03:47 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-02 09:03:47 --> Could not find the language line "on"
ERROR - 2016-06-02 09:03:47 --> Could not find the language line "off"
DEBUG - 2016-06-02 09:03:47 --> Total execution time: 0.1136
DEBUG - 2016-06-02 09:04:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:04:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:04:13 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-02 09:04:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:04:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:04:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:04:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:04:13 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
ERROR - 2016-06-02 09:04:13 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 09:08:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:08:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:08:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:08:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:08:13 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 09:08:13 --> Total execution time: 0.1649
DEBUG - 2016-06-02 09:08:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:08:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:08:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:08:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:08:13 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:08:13 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:08:20 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:08:20 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:08:20 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:08:21 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:08:21 --> Total execution time: 0.1217
DEBUG - 2016-06-02 09:08:21 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:08:21 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:08:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:08:21 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:08:21 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:08:21 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:33:02 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:33:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:33:02 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:33:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:33:03 --> Total execution time: 0.1629
DEBUG - 2016-06-02 09:33:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:33:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:33:03 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:33:03 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:33:03 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
ERROR - 2016-06-02 09:33:03 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 09:33:06 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:33:06 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:33:06 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:33:06 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:33:06 --> Total execution time: 0.1225
DEBUG - 2016-06-02 09:33:06 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:33:06 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:33:06 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:33:06 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:33:06 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:33:06 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:34:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:34:10 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:34:10 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:34:10 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:34:10 --> Total execution time: 0.1246
DEBUG - 2016-06-02 09:34:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:34:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:34:10 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:34:10 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:34:10 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
ERROR - 2016-06-02 09:34:10 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 09:34:12 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:34:12 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:34:12 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:34:12 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:34:12 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 09:34:12 --> Total execution time: 0.1758
DEBUG - 2016-06-02 09:34:12 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:34:12 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:34:12 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:34:12 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:34:12 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:34:12 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:34:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:34:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:34:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:34:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:34:14 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 09:34:14 --> Total execution time: 0.1204
DEBUG - 2016-06-02 09:34:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:34:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:34:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:34:14 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:34:14 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:34:15 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:38:49 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:38:49 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:38:49 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:38:49 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:38:49 --> Total execution time: 0.1233
DEBUG - 2016-06-02 09:38:49 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:38:49 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:38:49 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:38:49 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:38:49 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:38:49 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:38:51 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:38:51 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:38:51 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:38:51 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:38:51 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 09:38:51 --> Total execution time: 0.1215
DEBUG - 2016-06-02 09:38:51 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:38:51 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:38:51 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:38:51 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:38:51 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
ERROR - 2016-06-02 09:38:51 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 09:39:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:04 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:39:04 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:39:04 --> Listing query: SELECT *
FROM `businesses`
ORDER BY `business_name` ASC
 LIMIT 10
DEBUG - 2016-06-02 09:39:04 --> Total execution time: 0.1201
DEBUG - 2016-06-02 09:39:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:04 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:39:04 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:39:04 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:39:05 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:05 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:39:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:39:05 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 09:39:05 --> Total execution time: 0.1181
DEBUG - 2016-06-02 09:39:06 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:06 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:06 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:06 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:39:06 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:39:06 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:39:09 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:39:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:39:09 --> Listing query: SELECT *
FROM `businesses`
ORDER BY `business_name` ASC
 LIMIT 10
DEBUG - 2016-06-02 09:39:09 --> Total execution time: 0.1206
DEBUG - 2016-06-02 09:39:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:10 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:10 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:39:10 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:39:10 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:39:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:39:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:39:13 --> Total execution time: 0.1166
DEBUG - 2016-06-02 09:39:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:13 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:39:13 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:39:13 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:39:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:39:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
ERROR - 2016-06-02 09:39:15 --> Could not find the language line "on"
ERROR - 2016-06-02 09:39:15 --> Could not find the language line "off"
DEBUG - 2016-06-02 09:39:15 --> Total execution time: 0.1162
DEBUG - 2016-06-02 09:39:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:39:15 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:39:15 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:39:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:39:15 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-02 09:39:20 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:20 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:20 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:39:20 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:39:20 --> Total execution time: 0.1163
DEBUG - 2016-06-02 09:39:21 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:21 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:39:21 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:39:21 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:39:21 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:39:21 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:40:01 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:01 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:01 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:01 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:01 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 09:40:01 --> Total execution time: 0.1217
DEBUG - 2016-06-02 09:40:02 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:02 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:02 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:40:02 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:40:02 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:40:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:03 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:03 --> Total execution time: 0.1185
DEBUG - 2016-06-02 09:40:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:03 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:03 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:40:03 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
ERROR - 2016-06-02 09:40:03 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 09:40:05 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:05 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:05 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:05 --> Total execution time: 0.1448
DEBUG - 2016-06-02 09:40:06 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:06 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:06 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:06 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:06 --> Total execution time: 0.1340
DEBUG - 2016-06-02 09:40:07 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:07 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:07 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:07 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:07 --> Total execution time: 0.1340
DEBUG - 2016-06-02 09:40:08 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:08 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:08 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:08 --> Total execution time: 0.1380
DEBUG - 2016-06-02 09:40:09 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:09 --> Total execution time: 0.1471
DEBUG - 2016-06-02 09:40:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:10 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:10 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:10 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:10 --> Total execution time: 0.1382
DEBUG - 2016-06-02 09:40:11 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:11 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:11 --> Total execution time: 0.1351
DEBUG - 2016-06-02 09:40:12 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:12 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:12 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:12 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:12 --> Total execution time: 0.1413
DEBUG - 2016-06-02 09:40:13 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:13 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:13 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:13 --> Total execution time: 0.1377
DEBUG - 2016-06-02 09:40:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:14 --> Total execution time: 0.1393
DEBUG - 2016-06-02 09:40:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:40:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:40:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:40:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:40:15 --> Total execution time: 0.1409
DEBUG - 2016-06-02 09:43:11 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:43:11 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:43:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:43:11 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:43:11 --> Total execution time: 0.1235
DEBUG - 2016-06-02 09:43:12 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:43:12 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:43:12 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:43:12 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:43:12 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
ERROR - 2016-06-02 09:43:12 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 09:43:14 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:43:14 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:43:14 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:43:15 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:43:15 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 09:43:15 --> Total execution time: 0.1249
DEBUG - 2016-06-02 09:43:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:43:15 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:43:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:43:15 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:43:15 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:43:15 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:51:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:51:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:51:04 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:51:04 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:51:04 --> Total execution time: 0.2184
DEBUG - 2016-06-02 09:51:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:51:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:51:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:51:04 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:51:04 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:51:04 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:51:18 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:51:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:51:19 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:51:19 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:51:19 --> Total execution time: 0.1576
DEBUG - 2016-06-02 09:51:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:51:19 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:51:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:51:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:51:19 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:51:19 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:51:22 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:51:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:51:22 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:51:22 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:51:22 --> Total execution time: 0.1195
DEBUG - 2016-06-02 09:51:22 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:51:22 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:51:22 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:51:22 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:51:22 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:51:22 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:56:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:56:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:56:52 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:56:52 --> Total execution time: 0.1712
DEBUG - 2016-06-02 09:56:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:52 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:52 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:56:52 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:56:52 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:56:52 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:56:53 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:53 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:56:53 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:56:53 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:56:53 --> Total execution time: 0.1482
DEBUG - 2016-06-02 09:56:53 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:54 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:56:54 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:56:54 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:56:54 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 09:56:55 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:55 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:56:55 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:56:55 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:56:55 --> Total execution time: 0.1420
DEBUG - 2016-06-02 09:56:55 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:55 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:55 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:56:55 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:56:55 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
ERROR - 2016-06-02 09:56:55 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 09:56:57 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:57 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:56:57 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:56:57 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:56:57 --> Listing query: SELECT apps.*, (
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
				  DATE(app_sessions.app_start) BETWEEN "2016-05-30" AND "2016-06-05"
			) AS this_week_instances, (
				SELECT COUNT(*) AS instances
				FROM app_sessions
				WHERE app_sessions.app_id = apps.app_id AND
				  DATE(app_sessions.app_start) BETWEEN "2016-06-1" AND "2016-06-30"
			) AS this_month_instances, `businesses`.`business_name`
FROM `apps`
JOIN `businesses` ON `apps`.`business_id` = `businesses`.`business_id`
ORDER BY `apps`.`app_friendly_name` ASC
 LIMIT 10
DEBUG - 2016-06-02 09:56:57 --> Total execution time: 0.1348
DEBUG - 2016-06-02 09:56:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:56:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:56:58 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
ERROR - 2016-06-02 09:56:58 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 09:56:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:56:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:56:58 --> 404 Page Not Found: Js/bootstrap-toggle.min.js.map
DEBUG - 2016-06-02 09:58:09 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:58:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:58:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 09:58:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 09:58:09 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 09:58:09 --> Total execution time: 0.1268
DEBUG - 2016-06-02 09:58:09 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:58:09 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 09:58:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 09:58:09 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 09:58:09 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 09:58:09 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 10:00:44 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:00:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:00:44 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 10:00:45 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 10:00:45 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 10:00:45 --> Total execution time: 0.1373
DEBUG - 2016-06-02 10:00:45 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:00:45 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:00:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:00:45 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 10:00:45 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 10:00:45 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 10:06:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:06:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:06:58 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 10:06:58 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 10:06:58 --> Total execution time: 0.1666
DEBUG - 2016-06-02 10:06:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:06:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:06:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:06:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 10:06:58 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 10:06:58 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 10:15:09 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:15:09 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:15:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 10:15:09 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 10:15:09 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 10:15:09 --> Total execution time: 0.1424
DEBUG - 2016-06-02 10:15:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:15:10 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:15:10 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:15:10 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 10:15:10 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 10:15:10 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 10:22:23 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:22:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:22:23 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 10:22:23 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 10:22:23 --> Total execution time: 0.1567
DEBUG - 2016-06-02 10:22:23 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:22:23 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:22:23 --> UTF-8 Support Enabled
ERROR - 2016-06-02 10:22:23 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 10:22:23 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 10:22:23 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 10:30:57 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:30:57 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:30:57 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 10:30:57 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 10:30:57 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 10:30:57 --> Total execution time: 0.1401
DEBUG - 2016-06-02 10:30:57 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:30:58 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:30:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 10:30:58 --> 404 Page Not Found: Css/bootstrap.min.css.map
DEBUG - 2016-06-02 10:30:58 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 10:30:58 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 10:30:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:30:59 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:30:59 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 10:30:59 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 10:30:59 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 10:30:59 --> Total execution time: 0.1328
DEBUG - 2016-06-02 10:30:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:30:59 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:30:59 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:30:59 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 10:30:59 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 10:30:59 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
DEBUG - 2016-06-02 10:36:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:36:03 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:36:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/application.php
DEBUG - 2016-06-02 10:36:03 --> Config file loaded: C:\xampp\htdocs\vdash\application\config/authentication.php
DEBUG - 2016-06-02 10:36:03 --> Listing query: SELECT *
FROM `sys_users`
LEFT JOIN `businesses` ON `sys_users`.`business_id` = `businesses`.`business_id`
WHERE `sys_users`.`business_id` IS NOT NULL
 LIMIT 10
DEBUG - 2016-06-02 10:36:03 --> Total execution time: 0.1493
DEBUG - 2016-06-02 10:36:03 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:36:04 --> UTF-8 Support Enabled
DEBUG - 2016-06-02 10:36:04 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-06-02 10:36:04 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-06-02 10:36:04 --> 404 Page Not Found: Css/bootstrap.min.css.map
ERROR - 2016-06-02 10:36:04 --> 404 Page Not Found: Css/bootstrap-theme.min.css.map
