<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

DEBUG - 2016-08-01 01:51:24 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 01:51:24 --> No URI present. Default controller set.
DEBUG - 2016-08-01 01:51:24 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 01:51:24 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 01:51:24 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-08-01 01:51:24 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 01:51:24 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 01:51:24 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 01:51:24 --> Could not find the language line "page_title_"
DEBUG - 2016-08-01 01:51:24 --> Total execution time: 0.0362
DEBUG - 2016-08-01 01:51:24 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 01:51:24 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-08-01 01:51:24 --> 404 Page Not Found: Faviconico/index
DEBUG - 2016-08-01 03:18:27 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 03:18:27 --> No URI present. Default controller set.
DEBUG - 2016-08-01 03:18:27 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 03:18:27 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 03:18:27 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-08-01 03:18:27 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 03:18:27 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 03:18:27 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 03:18:27 --> Could not find the language line "page_title_"
DEBUG - 2016-08-01 03:18:27 --> Total execution time: 0.0364
DEBUG - 2016-08-01 03:18:38 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 03:18:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 03:18:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 03:18:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 03:18:38 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 03:18:38 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 03:18:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 03:18:38 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-08-01 03:18:38 --> Severity: Notice --> Undefined variable: pesan /home/changjeh/public_html/vdash.clouddesk.io/application/views/themes/default/dashboard.php 349
DEBUG - 2016-08-01 03:18:38 --> Total execution time: 0.0481
DEBUG - 2016-08-01 03:18:42 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 03:18:42 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-08-01 03:18:42 --> 404 Page Not Found: Faviconico/index
DEBUG - 2016-08-01 03:18:46 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 03:18:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 03:18:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 03:18:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 03:18:46 --> Total execution time: 0.0548
DEBUG - 2016-08-01 03:18:48 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 03:18:48 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 03:18:48 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 03:18:48 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 03:18:48 --> Listing query: SELECT *
FROM `machines`
JOIN `machine_categories` ON `machines`.`machine_category_id` = `machine_categories`.`machine_category_id`
JOIN `businesses` ON `machines`.`business_id` = `businesses`.`business_id`
LEFT JOIN `machine_groups` ON `machines`.`machine_group_id` = `machine_groups`.`machine_group_id`
 LIMIT 10
ERROR - 2016-08-01 03:18:48 --> Could not find the language line "first"
ERROR - 2016-08-01 03:18:48 --> Could not find the language line "last"
DEBUG - 2016-08-01 03:18:48 --> Total execution time: 0.0469
DEBUG - 2016-08-01 03:18:50 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 03:18:50 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 03:18:50 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 03:18:50 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 03:18:50 --> Listing query: SELECT `users`.*, COUNT(*) AS total_sessions, MAX(user_sessions.user_session_start) AS last_login_date
FROM `user_sessions`
JOIN `users` ON `user_sessions`.`user_id` = `users`.`user_id`
WHERE `user_sessions`.`machine_id` = 1
AND `users`.`user_visible` = 1
GROUP BY `user_sessions`.`user_id`
ORDER BY `total_sessions` DESC
 LIMIT 10
ERROR - 2016-08-01 03:18:50 --> Could not find the language line "first"
ERROR - 2016-08-01 03:18:50 --> Could not find the language line "last"
DEBUG - 2016-08-01 03:18:50 --> Listing query: SELECT `apps`.*, COUNT(*) AS total_instances, MAX(app_sessions.app_start) AS last_used_date
FROM `app_sessions`
JOIN `apps` ON `app_sessions`.`app_id` = `apps`.`app_id`
JOIN `user_sessions` ON `app_sessions`.`user_session_id` = `user_sessions`.`user_session_id`
JOIN `users` ON `user_sessions`.`user_id` = `users`.`user_id`
WHERE `apps`.`app_visible` = 1
AND `user_sessions`.`machine_id` = 1
AND `users`.`user_visible` = 1
GROUP BY `app_sessions`.`app_id`
ORDER BY `total_instances` DESC
 LIMIT 10
DEBUG - 2016-08-01 03:18:50 --> Pagination class already loaded. Second attempt ignored.
ERROR - 2016-08-01 03:18:50 --> Could not find the language line "first"
ERROR - 2016-08-01 03:18:50 --> Could not find the language line "last"
DEBUG - 2016-08-01 03:18:50 --> Total execution time: 0.0529
DEBUG - 2016-08-01 04:01:17 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:01:17 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:01:17 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:01:17 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:01:17 --> Array
(
    [user_session_id] => 
    [app_name] => MpCmdRun.exe
    [app_id] => 2452
    [timestamp] => 1470024094
    [code] => ZuhVbj
    [hash] => 00765564d0b8d8210395f19cb2cf34ce
)

DEBUG - 2016-08-01 04:01:17 --> Total execution time: 0.0350
DEBUG - 2016-08-01 04:01:18 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:01:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:01:18 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:01:18 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:01:18 --> Array
(
    [user_session_id] => 
    [app_name] => MusNotification.exe
    [app_id] => 2576
    [timestamp] => 1470024095
    [code] => ZuhVbj
    [hash] => 4d65840b86885da63ccee3af6d975ee0
)

DEBUG - 2016-08-01 04:01:18 --> Total execution time: 0.0339
DEBUG - 2016-08-01 04:01:19 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:01:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:01:19 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:01:19 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:01:19 --> Array
(
    [app_id] => 2452
    [timestamp] => 1470024096
    [code] => ZuhVbj
    [hash] => 3663bd5fc3d1483a1b63397cb5468793
)

DEBUG - 2016-08-01 04:01:19 --> Total execution time: 0.0471
DEBUG - 2016-08-01 04:01:19 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:01:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:01:19 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:01:19 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:01:19 --> Array
(
    [app_id] => 2576
    [timestamp] => 1470024096
    [code] => ZuhVbj
    [hash] => 3663bd5fc3d1483a1b63397cb5468793
)

DEBUG - 2016-08-01 04:01:19 --> Total execution time: 0.0328
DEBUG - 2016-08-01 04:01:20 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:01:20 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:01:20 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:01:20 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:01:20 --> Array
(
    [user_session_id] => 
    [app_name] => MpCmdRun.exe
    [app_id] => 3284
    [timestamp] => 1470024097
    [code] => ZuhVbj
    [hash] => 6d70d4855f7cf456462b68b2c293086d
)

DEBUG - 2016-08-01 04:01:20 --> Total execution time: 0.0325
DEBUG - 2016-08-01 04:07:02 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:07:02 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:07:02 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:07:02 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:07:02 --> Array
(
    [user_session_id] => 
    [app_name] => sppsvc.exe
    [app_id] => 2324
    [timestamp] => 1470024440
    [code] => ZuhVbj
    [hash] => bad9b6dcf408d2105537b9bec01264b3
)

DEBUG - 2016-08-01 04:07:02 --> Total execution time: 0.0334
DEBUG - 2016-08-01 04:07:03 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:07:03 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:07:03 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:07:03 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:07:03 --> Array
(
    [app_id] => 3176
    [timestamp] => 1470024440
    [code] => ZuhVbj
    [hash] => bad9b6dcf408d2105537b9bec01264b3
)

DEBUG - 2016-08-01 04:07:03 --> Total execution time: 0.0298
DEBUG - 2016-08-01 04:07:54 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:07:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:07:54 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:07:54 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:07:54 --> Array
(
    [user_session_id] => 
    [app_name] => SppExtComObj.Exe
    [app_id] => 1136
    [timestamp] => 1470024491
    [code] => ZuhVbj
    [hash] => 7bcab272735a058e5331ef2e6abf9867
)

DEBUG - 2016-08-01 04:07:54 --> Total execution time: 0.0305
DEBUG - 2016-08-01 04:07:54 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:07:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:07:54 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:07:54 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:07:54 --> Array
(
    [user_session_id] => 
    [app_name] => svchost.exe
    [app_id] => 3548
    [timestamp] => 1470024491
    [code] => ZuhVbj
    [hash] => 7bcab272735a058e5331ef2e6abf9867
)

DEBUG - 2016-08-01 04:07:54 --> Total execution time: 0.0303
DEBUG - 2016-08-01 04:07:54 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:07:54 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:07:54 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:07:54 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:07:54 --> Array
(
    [user_session_id] => 
    [app_name] => slui.exe
    [app_id] => 3924
    [timestamp] => 1470024492
    [code] => ZuhVbj
    [hash] => 26ad7e8e1da87a20a8987a5b62b1a564
)

DEBUG - 2016-08-01 04:07:54 --> Total execution time: 0.0293
DEBUG - 2016-08-01 04:07:58 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:07:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:07:58 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:07:58 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:07:58 --> Array
(
    [app_id] => 3924
    [timestamp] => 1470024496
    [code] => ZuhVbj
    [hash] => 4f2b0e508d31fbdddc03e98a6d958170
)

DEBUG - 2016-08-01 04:07:58 --> Total execution time: 0.0294
DEBUG - 2016-08-01 04:08:29 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:08:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:08:29 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:08:29 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:08:29 --> Array
(
    [app_id] => 1136
    [timestamp] => 1470024526
    [code] => ZuhVbj
    [hash] => 029532daf7c3031a30ee6f97e30d7fc1
)

DEBUG - 2016-08-01 04:08:29 --> Total execution time: 0.0344
DEBUG - 2016-08-01 04:08:29 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:08:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:08:29 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:08:29 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:08:29 --> Array
(
    [app_id] => 2324
    [timestamp] => 1470024526
    [code] => ZuhVbj
    [hash] => 029532daf7c3031a30ee6f97e30d7fc1
)

DEBUG - 2016-08-01 04:08:29 --> Total execution time: 0.0339
DEBUG - 2016-08-01 04:11:20 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:11:20 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:11:20 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:11:20 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:11:20 --> Array
(
    [app_id] => 3284
    [timestamp] => 1470024697
    [code] => ZuhVbj
    [hash] => ced7ceaa3c14bdb37439ba1964285d5a
)

DEBUG - 2016-08-01 04:11:20 --> Total execution time: 0.0335
DEBUG - 2016-08-01 04:12:55 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:12:55 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:12:55 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:12:55 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 04:12:55 --> Array
(
    [app_id] => 3548
    [timestamp] => 1470024793
    [code] => ZuhVbj
    [hash] => de3c996e99342bcb3bab87cd76550a51
)

DEBUG - 2016-08-01 04:12:55 --> Total execution time: 0.0296
DEBUG - 2016-08-01 04:36:31 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:36:31 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-08-01 04:36:31 --> 404 Page Not Found: Vdash/index
DEBUG - 2016-08-01 04:36:32 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:36:32 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-08-01 04:36:32 --> 404 Page Not Found: Faviconico/index
DEBUG - 2016-08-01 04:36:39 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 04:36:39 --> No URI present. Default controller set.
DEBUG - 2016-08-01 04:36:39 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 04:36:39 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 04:36:39 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-08-01 04:36:39 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 04:36:39 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 04:36:39 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 04:36:39 --> Could not find the language line "page_title_"
DEBUG - 2016-08-01 04:36:39 --> Total execution time: 0.0335
DEBUG - 2016-08-01 06:09:36 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 06:09:36 --> No URI present. Default controller set.
DEBUG - 2016-08-01 06:09:36 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 06:09:36 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 06:09:36 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
ERROR - 2016-08-01 06:09:36 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 06:09:36 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 06:09:36 --> Could not find the language line "page_title_"
ERROR - 2016-08-01 06:09:36 --> Could not find the language line "page_title_"
DEBUG - 2016-08-01 06:09:36 --> Total execution time: 0.0414
DEBUG - 2016-08-01 06:09:37 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 06:09:37 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-08-01 06:09:37 --> 404 Page Not Found: Faviconico/index
DEBUG - 2016-08-01 08:31:40 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:31:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:31:40 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:31:40 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:31:40 --> Array
(
    [user_session_id] => 
    [app_name] => conhost.exe
    [app_id] => 176
    [timestamp] => 1470040318
    [code] => ZuhVbj
    [hash] => 6f46f151211d6fb2c06649bffe181966
)

DEBUG - 2016-08-01 08:31:40 --> Total execution time: 0.0336
DEBUG - 2016-08-01 08:31:40 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:31:40 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:31:40 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:31:40 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:31:40 --> Array
(
    [user_session_id] => 
    [app_name] => UsoClient.exe
    [app_id] => 524
    [timestamp] => 1470040318
    [code] => ZuhVbj
    [hash] => 6f46f151211d6fb2c06649bffe181966
)

DEBUG - 2016-08-01 08:31:40 --> Total execution time: 0.0461
DEBUG - 2016-08-01 08:31:42 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:31:42 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:31:42 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:31:42 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:31:42 --> Array
(
    [user_session_id] => 
    [app_name] => MusNotification.exe
    [app_id] => 3284
    [timestamp] => 1470040319
    [code] => ZuhVbj
    [hash] => 7d6fcbc6ce6f556d89905318a3dba51e
)

DEBUG - 2016-08-01 08:31:42 --> Total execution time: 0.0323
DEBUG - 2016-08-01 08:31:42 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:31:42 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:31:42 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:31:42 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:31:42 --> Array
(
    [app_id] => 176
    [timestamp] => 1470040320
    [code] => ZuhVbj
    [hash] => 7ae3f16a6c0b4b8a4c7273695a2842e7
)

DEBUG - 2016-08-01 08:31:42 --> Total execution time: 0.0323
DEBUG - 2016-08-01 08:31:43 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:31:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:31:43 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:31:43 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:31:43 --> Array
(
    [app_id] => 3284
    [timestamp] => 1470040321
    [code] => ZuhVbj
    [hash] => b1d311b5f5de2e7dc2351be5cd7bd24f
)

DEBUG - 2016-08-01 08:31:43 --> Total execution time: 0.0573
DEBUG - 2016-08-01 08:31:45 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:31:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:31:45 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:31:45 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:31:45 --> Array
(
    [user_session_id] => 
    [app_name] => sppsvc.exe
    [app_id] => 2544
    [timestamp] => 1470040323
    [code] => ZuhVbj
    [hash] => 98429afe50ff604535fb5de753fd4eff
)

DEBUG - 2016-08-01 08:31:45 --> Total execution time: 0.0365
DEBUG - 2016-08-01 08:31:45 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:31:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:31:45 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:31:45 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:31:45 --> Array
(
    [user_session_id] => 
    [app_name] => TrustedInstaller.exe
    [app_id] => 3868
    [timestamp] => 1470040323
    [code] => ZuhVbj
    [hash] => 98429afe50ff604535fb5de753fd4eff
)

DEBUG - 2016-08-01 08:31:45 --> Total execution time: 0.0332
DEBUG - 2016-08-01 08:31:46 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:31:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:31:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:31:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:31:46 --> Array
(
    [user_session_id] => 
    [app_name] => TiWorker.exe
    [app_id] => 3960
    [timestamp] => 1470040323
    [code] => ZuhVbj
    [hash] => 98429afe50ff604535fb5de753fd4eff
)

DEBUG - 2016-08-01 08:31:46 --> Total execution time: 0.0359
DEBUG - 2016-08-01 08:32:15 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:32:15 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:32:15 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:32:15 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:32:15 --> Array
(
    [app_id] => 2544
    [timestamp] => 1470040353
    [code] => ZuhVbj
    [hash] => 3d5c6984beb6f5988165e00f213a991a
)

DEBUG - 2016-08-01 08:32:15 --> Total execution time: 0.0380
DEBUG - 2016-08-01 08:32:29 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:32:29 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:32:29 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:32:29 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:32:29 --> Array
(
    [user_session_id] => 
    [app_name] => wuauclt.exe
    [app_id] => 3668
    [timestamp] => 1470040367
    [code] => ZuhVbj
    [hash] => 9adbd703bd1f94a45fa272617baf1d0c
)

DEBUG - 2016-08-01 08:32:29 --> Total execution time: 0.0389
DEBUG - 2016-08-01 08:32:30 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:32:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:32:30 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:32:30 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:32:30 --> Array
(
    [user_session_id] => 
    [app_name] => AM_Delta.exe
    [app_id] => 3296
    [timestamp] => 1470040368
    [code] => ZuhVbj
    [hash] => 7e49679adac391ceb1853c003893ed75
)

DEBUG - 2016-08-01 08:32:30 --> Total execution time: 0.0350
DEBUG - 2016-08-01 08:32:30 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:32:30 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:32:30 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:32:30 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:32:30 --> Array
(
    [user_session_id] => 
    [app_name] => MpSigStub.exe
    [app_id] => 3416
    [timestamp] => 1470040368
    [code] => ZuhVbj
    [hash] => 7e49679adac391ceb1853c003893ed75
)

DEBUG - 2016-08-01 08:32:30 --> Total execution time: 0.0391
DEBUG - 2016-08-01 08:32:43 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:32:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:32:43 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:32:43 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:32:43 --> Array
(
    [app_id] => 3296
    [timestamp] => 1470040381
    [code] => ZuhVbj
    [hash] => 365e99d08aff3679f37334254ae9e384
)

DEBUG - 2016-08-01 08:32:43 --> Total execution time: 0.0389
DEBUG - 2016-08-01 08:32:43 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:32:43 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:32:43 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:32:44 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:32:44 --> Array
(
    [app_id] => 3416
    [timestamp] => 1470040381
    [code] => ZuhVbj
    [hash] => 365e99d08aff3679f37334254ae9e384
)

DEBUG - 2016-08-01 08:32:44 --> Total execution time: 0.0354
DEBUG - 2016-08-01 08:32:44 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:32:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:32:44 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:32:44 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:32:44 --> Array
(
    [app_id] => 3668
    [timestamp] => 1470040381
    [code] => ZuhVbj
    [hash] => 365e99d08aff3679f37334254ae9e384
)

DEBUG - 2016-08-01 08:32:44 --> Total execution time: 0.0345
DEBUG - 2016-08-01 08:33:51 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:33:51 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:33:51 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:33:51 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:33:51 --> Array
(
    [app_id] => 3868
    [timestamp] => 1470040449
    [code] => ZuhVbj
    [hash] => 5723f56fee32209ea7e55cd6d56ff727
)

DEBUG - 2016-08-01 08:33:51 --> Total execution time: 0.0331
DEBUG - 2016-08-01 08:33:51 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:33:51 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:33:51 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:33:51 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:33:51 --> Array
(
    [app_id] => 3960
    [timestamp] => 1470040449
    [code] => ZuhVbj
    [hash] => 5723f56fee32209ea7e55cd6d56ff727
)

DEBUG - 2016-08-01 08:33:51 --> Total execution time: 0.0321
DEBUG - 2016-08-01 08:45:46 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:45:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:45:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:45:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:45:46 --> Array
(
    [user_session_id] => 
    [app_name] => MusNotification.exe
    [app_id] => 2348
    [timestamp] => 1470041163
    [code] => ZuhVbj
    [hash] => 8e1fe25f54836927333daabe6eea6465
)

DEBUG - 2016-08-01 08:45:46 --> Total execution time: 0.0328
DEBUG - 2016-08-01 08:45:48 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:45:48 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:45:48 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:45:48 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:45:48 --> Array
(
    [app_id] => 2348
    [timestamp] => 1470041166
    [code] => ZuhVbj
    [hash] => 4fe00c49e941a076225b2faa7cac6308
)

DEBUG - 2016-08-01 08:45:48 --> Total execution time: 0.0301
DEBUG - 2016-08-01 08:45:51 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:45:51 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:45:51 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:45:51 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:45:51 --> Array
(
    [user_session_id] => 
    [app_name] => wermgr.exe
    [app_id] => 3516
    [timestamp] => 1470041169
    [code] => ZuhVbj
    [hash] => 7ae696e58fd5cf95a1e6b170fb19ac3c
)

DEBUG - 2016-08-01 08:45:51 --> Total execution time: 0.0311
DEBUG - 2016-08-01 08:45:53 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 08:45:53 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 08:45:53 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 08:45:53 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 08:45:53 --> Array
(
    [app_id] => 3516
    [timestamp] => 1470041171
    [code] => ZuhVbj
    [hash] => 1b580f8e7c520340d749e629fed29611
)

DEBUG - 2016-08-01 08:45:53 --> Total execution time: 0.0308
DEBUG - 2016-08-01 09:45:57 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 09:45:57 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 09:45:57 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 09:45:57 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 09:45:57 --> Array
(
    [user_session_id] => 
    [app_name] => conhost.exe
    [app_id] => 1892
    [timestamp] => 1470044775
    [code] => ZuhVbj
    [hash] => a9f9d1006bcc36a01d45b60a3a8eec6e
)

DEBUG - 2016-08-01 09:45:57 --> Total execution time: 0.0347
DEBUG - 2016-08-01 09:45:58 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 09:45:58 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 09:45:58 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 09:45:58 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 09:45:58 --> Array
(
    [user_session_id] => 
    [app_name] => SIHClient.exe
    [app_id] => 3680
    [timestamp] => 1470044776
    [code] => ZuhVbj
    [hash] => e1c3da50993a5e74f574314397b23b70
)

DEBUG - 2016-08-01 09:45:58 --> Total execution time: 0.0332
DEBUG - 2016-08-01 09:45:59 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 09:45:59 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 09:45:59 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 09:45:59 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 09:45:59 --> Array
(
    [app_id] => 3680
    [timestamp] => 1470044777
    [code] => ZuhVbj
    [hash] => 6e05bb92f255a4b7fb34413bede812ba
)

DEBUG - 2016-08-01 09:45:59 --> Total execution time: 0.0365
DEBUG - 2016-08-01 09:46:00 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 09:46:00 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 09:46:00 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 09:46:00 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 09:46:00 --> Array
(
    [app_id] => 1892
    [timestamp] => 1470044778
    [code] => ZuhVbj
    [hash] => 25c62fe288e574ffb8a0253be8d1a622
)

DEBUG - 2016-08-01 09:46:00 --> Total execution time: 0.0307
DEBUG - 2016-08-01 10:01:16 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 10:01:16 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 10:01:16 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 10:01:16 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 10:01:16 --> Listing query: SELECT `users`.*, COUNT(*) AS total_sessions, MAX(user_sessions.user_session_start) AS last_login_date
FROM `user_sessions`
JOIN `users` ON `user_sessions`.`user_id` = `users`.`user_id`
WHERE `user_sessions`.`machine_id` = 1
AND `users`.`user_visible` = 1
GROUP BY `user_sessions`.`user_id`
ORDER BY `total_sessions` DESC
 LIMIT 10
ERROR - 2016-08-01 10:01:16 --> Could not find the language line "first"
ERROR - 2016-08-01 10:01:16 --> Could not find the language line "last"
DEBUG - 2016-08-01 10:01:16 --> Listing query: SELECT `apps`.*, COUNT(*) AS total_instances, MAX(app_sessions.app_start) AS last_used_date
FROM `app_sessions`
JOIN `apps` ON `app_sessions`.`app_id` = `apps`.`app_id`
JOIN `user_sessions` ON `app_sessions`.`user_session_id` = `user_sessions`.`user_session_id`
JOIN `users` ON `user_sessions`.`user_id` = `users`.`user_id`
WHERE `apps`.`app_visible` = 1
AND `user_sessions`.`machine_id` = 1
AND `users`.`user_visible` = 1
GROUP BY `app_sessions`.`app_id`
ORDER BY `total_instances` DESC
 LIMIT 10
DEBUG - 2016-08-01 10:01:16 --> Pagination class already loaded. Second attempt ignored.
ERROR - 2016-08-01 10:01:16 --> Could not find the language line "first"
ERROR - 2016-08-01 10:01:16 --> Could not find the language line "last"
DEBUG - 2016-08-01 10:01:16 --> Total execution time: 0.0538
DEBUG - 2016-08-01 11:51:59 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 11:51:59 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 11:51:59 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 11:51:59 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 11:51:59 --> Array
(
    [user_session_id] => 
    [app_name] => taskhostw.exe
    [app_id] => 3240
    [timestamp] => 1470052336
    [code] => ZuhVbj
    [hash] => d90fe50ac7a85a03c0e2600ce37753e0
)

DEBUG - 2016-08-01 11:51:59 --> Total execution time: 0.0362
DEBUG - 2016-08-01 12:24:19 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 12:24:19 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 12:24:19 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 12:24:19 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 12:24:19 --> Array
(
    [mac_address] => 0A002700000F
    [ip_address] => 192.168.56.1
    [os] => Microsoft Windows 10 Pro
    [domain] => 
    [pc_name] => DESKTOP-5HMUCMR
    [processor] => Intel(R) Core(TM) i3-4005U CPU @ 1.70GHz
    [ram] => 4196429824
    [timestamp] => 1469421592
    [code] => QObYXz
    [model] => X455LAB
    [machineserialnumber] => FAN0WU077004428 
    [hash] => 5fac76a661d2c142edc8f6bed2398102
)

DEBUG - 2016-08-01 12:24:19 --> Total execution time: 0.0353
DEBUG - 2016-08-01 12:24:19 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 12:24:19 --> Global POST, GET and COOKIE data sanitized
ERROR - 2016-08-01 12:24:19 --> 404 Page Not Found: Faviconico/index
DEBUG - 2016-08-01 20:43:44 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 20:43:44 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 20:43:44 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 20:43:44 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 20:43:44 --> Array
(
    [user_session_id] => 
    [app_name] => rundll32.exe
    [app_id] => 1040
    [timestamp] => 1470084242
    [code] => ZuhVbj
    [hash] => 328206a9fd94320bb400efa82029f751
)

DEBUG - 2016-08-01 20:43:44 --> Total execution time: 0.0348
DEBUG - 2016-08-01 20:43:45 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 20:43:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 20:43:45 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 20:43:45 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 20:43:45 --> Array
(
    [user_session_id] => 
    [app_name] => CompatTelRunner.exe
    [app_id] => 1332
    [timestamp] => 1470084244
    [code] => ZuhVbj
    [hash] => 151582d1c8e5296cdbcce9738742cdc9
)

DEBUG - 2016-08-01 20:43:45 --> Total execution time: 0.0302
DEBUG - 2016-08-01 20:43:45 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 20:43:45 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 20:43:45 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 20:43:45 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 20:43:45 --> Array
(
    [user_session_id] => 
    [app_name] => rundll32.exe
    [app_id] => 3332
    [timestamp] => 1470084244
    [code] => ZuhVbj
    [hash] => 151582d1c8e5296cdbcce9738742cdc9
)

DEBUG - 2016-08-01 20:43:45 --> Total execution time: 0.0289
DEBUG - 2016-08-01 20:43:46 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 20:43:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 20:43:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 20:43:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 20:43:46 --> Array
(
    [app_id] => 1332
    [timestamp] => 1470084245
    [code] => ZuhVbj
    [hash] => 3959dbfb59f0ba342740358daa29905d
)

DEBUG - 2016-08-01 20:43:46 --> Total execution time: 0.0298
DEBUG - 2016-08-01 20:43:46 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 20:43:46 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 20:43:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 20:43:46 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 20:43:46 --> Array
(
    [user_session_id] => 
    [app_name] => sppsvc.exe
    [app_id] => 2440
    [timestamp] => 1470084245
    [code] => ZuhVbj
    [hash] => 3959dbfb59f0ba342740358daa29905d
)

DEBUG - 2016-08-01 20:43:46 --> Total execution time: 0.0287
DEBUG - 2016-08-01 20:43:47 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 20:43:47 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 20:43:47 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 20:43:47 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 20:43:47 --> Array
(
    [app_id] => 1040
    [timestamp] => 1470084246
    [code] => ZuhVbj
    [hash] => c90153b42bce2a5af437c7f0f39ea76b
)

DEBUG - 2016-08-01 20:43:47 --> Total execution time: 0.0310
DEBUG - 2016-08-01 20:43:47 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 20:43:47 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 20:43:47 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 20:43:47 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 20:43:47 --> Array
(
    [user_session_id] => 
    [app_name] => svchost.exe
    [app_id] => 3756
    [timestamp] => 1470084246
    [code] => ZuhVbj
    [hash] => c90153b42bce2a5af437c7f0f39ea76b
)

DEBUG - 2016-08-01 20:43:47 --> Total execution time: 0.0294
DEBUG - 2016-08-01 20:44:18 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 20:44:18 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 20:44:18 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 20:44:18 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 20:44:18 --> Array
(
    [app_id] => 2440
    [timestamp] => 1470084276
    [code] => ZuhVbj
    [hash] => 5d3a3346ceeed34a736654d27e2d9350
)

DEBUG - 2016-08-01 20:44:18 --> Total execution time: 0.0297
DEBUG - 2016-08-01 20:58:47 --> UTF-8 Support Enabled
DEBUG - 2016-08-01 20:58:47 --> Global POST, GET and COOKIE data sanitized
DEBUG - 2016-08-01 20:58:47 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/application.php
DEBUG - 2016-08-01 20:58:47 --> Config file loaded: /home/changjeh/public_html/vdash.clouddesk.io/application/config/authentication.php
DEBUG - 2016-08-01 20:58:47 --> Array
(
    [app_id] => 3756
    [timestamp] => 1470085146
    [code] => ZuhVbj
    [hash] => d69d0823e1d60129508967c314988645
)

DEBUG - 2016-08-01 20:58:47 --> Total execution time: 0.0333
