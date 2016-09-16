-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema vdash
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Table `sys_users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sys_users` (
  `sys_user_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NULL DEFAULT NULL COMMENT 'If the user type is admin or viewer, this will be the business that assigned to this user.',
  `sys_user_email` VARCHAR(255) NOT NULL,
  `sys_user_password` VARCHAR(255) NOT NULL,
  `sys_user_name` VARCHAR(80) NOT NULL COMMENT 'The display name shows.',
  `sys_user_phone` VARCHAR(20) NULL DEFAULT NULL,
  `sys_user_mobile` VARCHAR(20) NULL DEFAULT NULL,
  `sys_user_remark` TEXT NULL DEFAULT NULL COMMENT 'For internal remark only.',
  `sys_user_type` VARCHAR(20) NOT NULL DEFAULT 'viewer' COMMENT 'superadmin - To administrate the vdash system.\nadmin - To administrate only their assigned business.\nviewer - Able to view their assigned business.',
  `sys_user_valid` TINYINT(1) UNSIGNED ZEROFILL NOT NULL DEFAULT 1 COMMENT '0 - Suspended\n1 - Active',
  `sys_user_last_login` DATETIME NULL DEFAULT NULL,
  `sys_user_created` DATETIME NOT NULL,
  `sys_user_created_by` INT(9) UNSIGNED NOT NULL,
  PRIMARY KEY (`sys_user_id`))
ENGINE = InnoDB
COMMENT = 'The system users. This table is used to login to vdash system.';


-- -----------------------------------------------------
-- Table `sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` VARCHAR(40) NOT NULL DEFAULT 0,
  `ip_address` VARCHAR(45) NOT NULL DEFAULT 0,
  `timestamp` INT(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0,
  `data` BLOB NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = 'User login session to vdash.';

CREATE INDEX `CI_SESSION_TIMESTAMP` ON `sessions` (`timestamp` ASC);


-- -----------------------------------------------------
-- Table `user_sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_sessions` (
  `user_session_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `machine_id` INT(9) UNSIGNED NOT NULL COMMENT 'Which machine the user is using on this session.',
  `user_id` INT(9) UNSIGNED NOT NULL,
  `user_session_start` DATETIME NOT NULL,
  `user_session_end` DATETIME NULL DEFAULT NULL,
  `user_session_starter` INT(9) UNSIGNED NOT NULL COMMENT 'For concurrent session use.',
  `user_session_duration` INT(9) UNSIGNED ZEROFILL NULL DEFAULT NULL,
  `user_session_status` VARCHAR(30) NOT NULL DEFAULT 'online' COMMENT 'online\noffline',
  PRIMARY KEY (`user_session_id`))
ENGINE = InnoDB
COMMENT = 'The user who logged into the machine.';


-- -----------------------------------------------------
-- Table `app_sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `app_sessions` (
  `app_session_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `app_id` INT(9) NOT NULL,
  `user_session_id` INT(9) UNSIGNED NOT NULL,
  `app_session_starter_id` INT(9) UNSIGNED NOT NULL COMMENT 'For generating concurrent result use.',
  `app_local_system_id` VARCHAR(25) NOT NULL COMMENT 'Used to track the application ID in the local system.',
  `app_start` DATETIME NOT NULL,
  `app_end` DATETIME NULL,
  `app_duration` INT(9) UNSIGNED ZEROFILL NULL DEFAULT NULL,
  PRIMARY KEY (`app_session_id`))
ENGINE = InnoDB
COMMENT = 'The session for each application lanched from user site.';


-- -----------------------------------------------------
-- Table `machines`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `machines` (
  `machine_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NOT NULL COMMENT 'Which business that this machine belongs to.',
  `machine_category_id` INT(9) UNSIGNED NOT NULL COMMENT 'To which category this machine belongs to.',
  `machine_group_id` INT(9) UNSIGNED NULL DEFAULT NULL COMMENT 'The machine group of which this machine assigned.',
  `machine_mac_address` VARCHAR(50) NOT NULL COMMENT 'The MAC address without any separator charactor such as dash or colon.',
  `machine_ip_address` VARCHAR(50) NOT NULL COMMENT 'The IP Address might change if the DHCP refresh the client\'s IP.',
  `machine_os_name` VARCHAR(150) NOT NULL COMMENT 'The full operating system name.',
  `machine_domain_name` VARCHAR(150) NULL DEFAULT NULL,
  `machine_default_name` VARCHAR(100) NOT NULL COMMENT 'The original PC name sent from client side.',
  `machine_name` VARCHAR(100) NOT NULL COMMENT 'The friendly name of this machine.',
  `machine_serial_number` VARCHAR(100) NULL DEFAULT NULL,
  `machine_model` VARCHAR(150) NULL DEFAULT NULL,
  `machine_processor` VARCHAR(150) NULL DEFAULT NULL,
  `machine_ram` VARCHAR(50) NULL DEFAULT NULL,
  `machine_year` SMALLINT(4) UNSIGNED NULL DEFAULT NULL,
  `machine_support_expiry` SMALLINT(4) UNSIGNED NULL DEFAULT NULL,
  `machine_physical_status` VARCHAR(20) NULL DEFAULT NULL,
  `machine_visible` TINYINT(1) UNSIGNED ZEROFILL NOT NULL DEFAULT 0 COMMENT 'This flag determine whether this machine should visible on the statistic. If 0, this machine will not shows on the report.',
  `machine_status` VARCHAR(30) NOT NULL DEFAULT 'offline' COMMENT 'The status of the machine:\noccupied - the machine currently occupied.\nonline - the machine is currently turned on but no one using it.\noffline - the machine is currently turned off.',
  `machine_last_connected` DATETIME NULL DEFAULT NULL COMMENT 'The last connected date/time. When the machine is turned on, this will be updated.',
  `machine_last_login` DATETIME NULL DEFAULT NULL COMMENT 'The last logged in by user.',
  `machine_last_login_user` INT(9) NULL DEFAULT NULL,
  `machine_created` DATETIME NOT NULL COMMENT 'The date/time when this machine was added in the system.',
  PRIMARY KEY (`machine_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `password_recovers`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `password_recovers` (
  `password_recover_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(9) NOT NULL,
  `password_recover_date` DATETIME NOT NULL COMMENT 'The date when this recover record was created.',
  `password_recover_code` VARCHAR(255) NOT NULL COMMENT 'This code is used to verify the transaction was valid from the recipient.',
  `password_recover_reset_date` DATETIME NULL DEFAULT NULL COMMENT 'The date when the user reset the password.',
  `password_recover_status` VARCHAR(30) NOT NULL COMMENT 'valid\nused',
  PRIMARY KEY (`password_recover_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `machine_categories`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `machine_categories` (
  `machine_category_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `machine_category_name` VARCHAR(150) NOT NULL,
  `machine_category_code` VARCHAR(20) NOT NULL COMMENT 'This code will used to assign to the HTML class.',
  `machine_category_regex` VARCHAR(150) NULL DEFAULT NULL COMMENT 'This regex will used to match when a new machine connected. It will based on the machine OS name. If matched, automatically the machine will fall under this category.',
  `machine_category_order` SMALLINT(2) UNSIGNED ZEROFILL NOT NULL DEFAULT 0 COMMENT 'This order will affect the matching priority.',
  PRIMARY KEY (`machine_category_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `app_filters`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `app_filters` (
  `app_filter_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NOT NULL,
  `app_filter_name` VARCHAR(50) NOT NULL,
  `app_filter_sys_name` VARCHAR(255) NOT NULL COMMENT 'Inclue wildcard. Match with the app_sys_name.',
  `app_filter_negate` TINYINT(1) UNSIGNED ZEROFILL NOT NULL DEFAULT 0,
  `app_filter_action` VARCHAR(30) NOT NULL DEFAULT 'allow' COMMENT 'The actions for this rules. Available options:\n- allow\n- block',
  `app_filter_on_success` VARCHAR(30) NOT NULL DEFAULT 'stop' COMMENT 'This is the action to take after the filter successfully matched. Two possible options:\n- stop\n- pass',
  `app_filter_on_fail` VARCHAR(30) NOT NULL DEFAULT 'stop' COMMENT 'This is the action to take after the filter failed to match. Two possible options:\n- stop\n- pass',
  `app_filter_order` SMALLINT(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 0,
  `app_filter_created` DATETIME NOT NULL,
  `app_filter_created_by` INT(9) UNSIGNED NOT NULL,
  PRIMARY KEY (`app_filter_id`))
ENGINE = InnoDB
COMMENT = 'The application filters. When it matched, it will blacklist the application. Unlike other filter, the application filter only has one action which is to blacklist the application and prevent it from showing on the front end.';


-- -----------------------------------------------------
-- Table `user_filters`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_filters` (
  `user_filter_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NOT NULL,
  `user_filter_name` VARCHAR(50) NOT NULL,
  `user_filter_username_full` VARCHAR(255) NULL DEFAULT NULL COMMENT 'This match full username.',
  `user_filter_domain` VARCHAR(150) NULL DEFAULT NULL COMMENT 'Match domain exactly.',
  `user_filter_username` VARCHAR(150) NULL DEFAULT NULL COMMENT 'Match username exactly.',
  `user_filter_ad_group` VARCHAR(150) NULL DEFAULT NULL COMMENT 'Match if the user AD group contains the words here.',
  `user_filter_negate` TINYINT(1) UNSIGNED ZEROFILL NOT NULL DEFAULT 0,
  `user_filter_action` VARCHAR(20) NOT NULL DEFAULT 'allow' COMMENT 'Available options:\n- allow\n- block\n- group',
  `user_filter_group_assigned` INT(9) UNSIGNED NULL DEFAULT NULL,
  `user_filter_on_success` VARCHAR(30) NOT NULL DEFAULT 'stop' COMMENT 'This is the action to take after the filter has successfully matched. Two possible options:\n- stop\n- pass',
  `user_filter_on_fail` VARCHAR(30) NOT NULL DEFAULT 'stop' COMMENT 'This is the action to take after the filter failed to match. Two possible options:\n- stop\n- pass',
  `user_filter_order` SMALLINT(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 0,
  `user_filter_created` DATETIME NOT NULL,
  `user_filter_created_by` INT(9) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_filter_id`))
ENGINE = InnoDB
COMMENT = 'The user filtering rules.';


-- -----------------------------------------------------
-- Table `machine_filters`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `machine_filters` (
  `machine_filter_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NOT NULL,
  `machine_filter_name` VARCHAR(50) NOT NULL COMMENT 'A given name for this filter.',
  `machine_filter_mac_address` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Wildcard match. Eg: 00* will match all mac address starting with 00.',
  `machine_filter_pc_name` VARCHAR(100) NULL DEFAULT NULL COMMENT 'Contain search. Accept wildcard.',
  `machine_filter_ip_address` VARCHAR(50) NULL DEFAULT NULL COMMENT 'It will match if the dot is leave empty. Eg: 192.168. will match 192.168.0.0 till 192.168.255.255.',
  `machine_filter_negate` TINYINT(1) UNSIGNED ZEROFILL NOT NULL DEFAULT 0 COMMENT 'If negate is 1, then this filter will match if the filter rules did not match. ',
  `machine_filter_action` VARCHAR(20) NOT NULL DEFAULT 'allow' COMMENT 'The action for this filter.\n- allow\n- block\n- group',
  `machine_filter_group_assigned` INT(9) UNSIGNED NULL DEFAULT NULL COMMENT 'If the action is \'group\', this will be the machine_group_id.',
  `machine_filter_on_success` VARCHAR(30) NOT NULL DEFAULT 'stop' COMMENT 'This is the action to take after the successfully matched. Two possible options:\n- stop\n- pass',
  `machine_filter_on_fail` VARCHAR(30) NOT NULL DEFAULT 'stop' COMMENT 'This is the action to take after the filter failed to match. Two possible options:\n- stop\n- pass',
  `machine_filter_order` SMALLINT(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 0 COMMENT 'This will affect the matching priority.',
  `machine_filter_created` DATETIME NOT NULL,
  `machine_filter_created_by` INT(9) UNSIGNED NOT NULL,
  PRIMARY KEY (`machine_filter_id`))
ENGINE = InnoDB
COMMENT = 'This is the filter rules that used to filter the incoming connected machine. If either one of the rule matched, the specified action will be carried out.';


-- -----------------------------------------------------
-- Table `sys_user_settings`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sys_user_settings` (
  `setting_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT(9) UNSIGNED NOT NULL,
  `setting_name` VARCHAR(50) NOT NULL,
  `setting_value` VARCHAR(255) NOT NULL,
  `setting_modified` DATETIME NOT NULL,
  `setting_modifier` INT(9) UNSIGNED NOT NULL,
  PRIMARY KEY (`setting_id`))
ENGINE = InnoDB
COMMENT = 'The user settings.';


-- -----------------------------------------------------
-- Table `apps`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `apps` (
  `app_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NOT NULL,
  `app_sys_name` VARCHAR(255) NOT NULL COMMENT 'The system default name. Eg: notepad.exe. This will used to uniquely identify the application.',
  `app_friendly_name` VARCHAR(255) NOT NULL COMMENT 'The friendly name of the application. If not set, default to the app_sys_name.',
  `app_license_count` MEDIUMINT(6) UNSIGNED ZEROFILL NOT NULL DEFAULT 0 COMMENT 'The maximum license allowed. If 0, unlimited.',
  `app_version` VARCHAR(50) NULL DEFAULT NULL,
  `app_license_type` VARCHAR(100) NULL DEFAULT NULL,
  `app_vendor` VARCHAR(255) NULL DEFAULT NULL,
  `app_purchase_date` DATE NULL DEFAULT NULL,
  `app_expiry_date` DATE NULL DEFAULT NULL,
  `app_virtualized` VARCHAR(255) NULL DEFAULT NULL,
  `app_visible` TINYINT(1) UNSIGNED ZEROFILL NOT NULL DEFAULT 0,
  `app_created` DATETIME NOT NULL,
  PRIMARY KEY (`app_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `notifications`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `notifications` (
  `notification_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NOT NULL,
  `notification_type` VARCHAR(50) NOT NULL COMMENT 'The notification type. Each notification type will have different output.',
  `notification_parameters` TEXT NULL COMMENT 'This is the parameter in JSON formatted string.',
  `notification_date` DATETIME NOT NULL,
  PRIMARY KEY (`notification_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `businesses`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `businesses` (
  `business_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_code` VARCHAR(20) NOT NULL COMMENT 'The code is to represent this business. Is an aliase to the business_id.',
  `business_name` VARCHAR(150) NOT NULL,
  `business_site_domain` VARCHAR(255) NULL DEFAULT NULL COMMENT 'This domain will used to access the vdash portal. Eg: vdash.domain.com',
  `business_phone` VARCHAR(20) NULL DEFAULT NULL,
  `business_fax` VARCHAR(20) NULL DEFAULT NULL,
  `business_email` VARCHAR(255) NULL DEFAULT NULL,
  `business_profile` TEXT NULL DEFAULT NULL,
  `business_max_agent` INT(8) UNSIGNED ZEROFILL NOT NULL DEFAULT 0 COMMENT 'The maximum agents allowed to installed for this business. 0 to indicate unlimited.',
  `business_connected_agent` INT(8) UNSIGNED ZEROFILL NOT NULL DEFAULT 0 COMMENT 'This is the number of connected agents. This number will be increasing from time to time. Basically when a new mac address is found for this business, this number will increase  one. Blacklisted machine will also deducted one from here.',
  `business_picture` VARCHAR(255) NULL DEFAULT NULL,
  `business_created` DATETIME NOT NULL,
  `business_created_by` INT(9) NOT NULL,
  PRIMARY KEY (`business_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `machine_groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `machine_groups` (
  `machine_group_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NOT NULL,
  `machine_group_code` VARCHAR(20) NOT NULL COMMENT 'This code will used in the HTML class. No space and special character allowed.',
  `machine_group_name` VARCHAR(50) NOT NULL,
  `machine_group_desc` TEXT NULL DEFAULT NULL,
  `machine_group_order` SMALLINT(4) UNSIGNED ZEROFILL NOT NULL DEFAULT 0,
  `machine_group_created` DATETIME NOT NULL,
  `machine_group_created_by` INT(9) UNSIGNED NOT NULL,
  PRIMARY KEY (`machine_group_id`))
ENGINE = InnoDB
COMMENT = 'This can used to group the machine and for better reporting analysis.';


-- -----------------------------------------------------
-- Table `machine_sessions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `machine_sessions` (
  `machine_session_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `machine_id` INT(9) UNSIGNED NOT NULL,
  `machine_session_starter_id` INT(9) UNSIGNED NOT NULL COMMENT 'Concurrent starter session ID. ',
  `machine_session_start` DATETIME NOT NULL,
  `machine_session_end` DATETIME NULL DEFAULT NULL,
  `machine_session_duration` INT(10) UNSIGNED ZEROFILL NULL DEFAULT NULL,
  PRIMARY KEY (`machine_session_id`))
ENGINE = InnoDB
COMMENT = 'This store each sessions the machine connected or startup.';


-- -----------------------------------------------------
-- Table `users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NOT NULL,
  `user_group_id` INT(9) NULL DEFAULT NULL,
  `user_name_full` VARCHAR(255) NOT NULL COMMENT 'The full username domain\\username.',
  `user_domain` VARCHAR(150) NOT NULL COMMENT 'The user domain. If the user is not connected to AD, this will be the PC name.',
  `user_name` VARCHAR(150) NOT NULL,
  `user_ad_group` VARCHAR(255) NULL DEFAULT NULL COMMENT 'The AD groups this user belongs to.',
  `user_remark` TEXT NULL DEFAULT NULL COMMENT 'For internal use only.',
  `user_visible` TINYINT(1) UNSIGNED ZEROFILL NOT NULL DEFAULT 0 COMMENT 'This tells whether to shows this user statistics in the report or statistics or not.',
  `user_status` VARCHAR(20) NOT NULL DEFAULT 'offline' COMMENT 'online and offline.',
  `user_last_connected` DATETIME NULL DEFAULT NULL COMMENT 'The last connected date/time.',
  `user_last_connected_machine` INT(9) UNSIGNED NULL DEFAULT NULL COMMENT 'The last connected machine ID.',
  `user_created` DATETIME NOT NULL,
  PRIMARY KEY (`user_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `user_groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `user_groups` (
  `user_group_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `business_id` INT(9) UNSIGNED NOT NULL,
  `user_group_code` VARCHAR(20) NOT NULL COMMENT 'This code will used in the HTML class.',
  `user_group_name` VARCHAR(150) NOT NULL,
  `user_group_desc` TEXT NULL DEFAULT NULL,
  `user_group_created` DATETIME NOT NULL,
  `user_group_created_by` INT(9) UNSIGNED NOT NULL,
  PRIMARY KEY (`user_group_id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `sys_user_notification_groups`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sys_user_notification_groups` (
  `sys_user_notification_group_id` INT(9) UNSIGNED NOT NULL AUTO_INCREMENT,
  `sys_user_id` INT(9) NOT NULL,
  `notification_id` INT(9) UNSIGNED NOT NULL COMMENT 'This is the first notification ID for this notification group.',
  `sys_user_notification_group_date` DATETIME NOT NULL,
  `sys_user_notification_group_read` TINYINT(1) ZEROFILL UNSIGNED NOT NULL DEFAULT 0 COMMENT 'Whether the post has read or not.',
  `sys_user_notification_group_read_date` DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (`sys_user_notification_group_id`, `sys_user_id`))
ENGINE = InnoDB
COMMENT = 'This table stores the grouped notification message. ';


-- -----------------------------------------------------
-- Table `sys_notification_notification_group_maps`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `sys_notification_notification_group_maps` (
  `sys_user_notification_group_id` INT(9) UNSIGNED NOT NULL,
  `notification_id` INT(9) UNSIGNED NOT NULL,
  PRIMARY KEY (`sys_user_notification_group_id`, `notification_id`))
ENGINE = InnoDB
COMMENT = 'This table map between the notification group and the notification.';


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `sys_users`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `sys_users` (`sys_user_id`, `business_id`, `sys_user_email`, `sys_user_password`, `sys_user_name`, `sys_user_phone`, `sys_user_mobile`, `sys_user_remark`, `sys_user_type`, `sys_user_valid`, `sys_user_last_login`, `sys_user_created`, `sys_user_created_by`) VALUES (1, NULL, 'admin@local', '$2y$10$EoKPxbZItPz9cbhr85hF5.3QI0G8khhuHKASvtUOlRnQ6Pyzlz6eC', 'Administrator', NULL, NULL, NULL, 'superadmin', 1, NULL, '2015-12-16 17:38:33', 1);

COMMIT;


-- -----------------------------------------------------
-- Data for table `machine_categories`
-- -----------------------------------------------------
START TRANSACTION;
INSERT INTO `machine_categories` (`machine_category_id`, `machine_category_name`, `machine_category_code`, `machine_category_regex`, `machine_category_order`) VALUES (1, 'Server', 'server', 'server', 0);
INSERT INTO `machine_categories` (`machine_category_id`, `machine_category_name`, `machine_category_code`, `machine_category_regex`, `machine_category_order`) VALUES (2, 'Client', 'client', '^((?!server).)*$', 1);

COMMIT;

