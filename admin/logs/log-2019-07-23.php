<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2019-07-23 06:32:41 --> 404 Page Not Found: Favicon/favicon-32.png
ERROR - 2019-07-23 06:32:41 --> 404 Page Not Found: Favicon/favicon.ico
ERROR - 2019-07-23 14:25:00 --> 404 Page Not Found: Favicon/favicon-32.png
ERROR - 2019-07-23 14:25:00 --> 404 Page Not Found: Favicon/favicon.ico
ERROR - 2019-07-23 14:25:14 --> 404 Page Not Found: Default/images
ERROR - 2019-07-23 14:25:14 --> 404 Page Not Found: Default/images
ERROR - 2019-07-23 14:38:38 --> Severity: Warning --> mb_detect_encoding() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 233
ERROR - 2019-07-23 14:38:38 --> Severity: Warning --> utf8_encode() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 235
ERROR - 2019-07-23 14:39:43 --> Severity: Warning --> mb_detect_encoding() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 233
ERROR - 2019-07-23 14:39:43 --> Severity: Warning --> utf8_encode() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 235
ERROR - 2019-07-23 14:40:07 --> Severity: Warning --> mb_detect_encoding() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 233
ERROR - 2019-07-23 14:40:07 --> Severity: Warning --> utf8_encode() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 235
ERROR - 2019-07-23 14:40:07 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\realestate\admin\system\core\Exceptions.php:271) C:\xampp\htdocs\realestate\admin\system\core\Common.php 570
ERROR - 2019-07-23 14:40:07 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\realestate\admin\system\core\Exceptions.php:271) C:\xampp\htdocs\realestate\admin\application\libraries\REST_Controller.php 507
ERROR - 2019-07-23 14:40:22 --> Severity: Warning --> mb_detect_encoding() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 233
ERROR - 2019-07-23 14:40:22 --> Severity: Warning --> utf8_encode() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 235
ERROR - 2019-07-23 14:41:00 --> Severity: Notice --> Undefined property: stdClass::$FullName C:\xampp\htdocs\realestate\admin\application\models\Api_model.php 1576
ERROR - 2019-07-23 14:41:00 --> Severity: Notice --> Undefined property: stdClass::$EmailAddress C:\xampp\htdocs\realestate\admin\application\models\Api_model.php 1577
ERROR - 2019-07-23 14:41:00 --> Severity: Notice --> Undefined property: stdClass::$UserContact C:\xampp\htdocs\realestate\admin\application\models\Api_model.php 1578
ERROR - 2019-07-23 14:41:00 --> Severity: Notice --> Undefined property: stdClass::$ProfileImage C:\xampp\htdocs\realestate\admin\application\models\Api_model.php 1579
ERROR - 2019-07-23 14:41:00 --> Severity: Notice --> Undefined property: stdClass::$UsersId C:\xampp\htdocs\realestate\admin\application\models\Api_model.php 1580
ERROR - 2019-07-23 14:41:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\realestate\admin\system\core\Exceptions.php:271) C:\xampp\htdocs\realestate\admin\application\libraries\REST_Controller.php 489
ERROR - 2019-07-23 14:41:00 --> Severity: Warning --> mb_detect_encoding() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 233
ERROR - 2019-07-23 14:41:00 --> Severity: Warning --> utf8_encode() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 235
ERROR - 2019-07-23 14:41:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\realestate\admin\system\core\Exceptions.php:271) C:\xampp\htdocs\realestate\admin\system\core\Common.php 570
ERROR - 2019-07-23 14:41:00 --> Severity: Warning --> Cannot modify header information - headers already sent by (output started at C:\xampp\htdocs\realestate\admin\system\core\Exceptions.php:271) C:\xampp\htdocs\realestate\admin\application\libraries\REST_Controller.php 507
ERROR - 2019-07-23 14:41:07 --> Severity: Warning --> mb_detect_encoding() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 233
ERROR - 2019-07-23 14:41:07 --> Severity: Warning --> utf8_encode() expects parameter 1 to be string, object given C:\xampp\htdocs\realestate\admin\application\libraries\Format.php 235
ERROR - 2019-07-23 14:49:03 --> Severity: error --> Exception: Call to undefined method CI_DB_mysqli_driver::num_rows() C:\xampp\htdocs\realestate\admin\application\models\Api_model.php 1580
ERROR - 2019-07-23 15:02:28 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'OUTER JOIN `tblspecification` `sp` ON `sp`.`project_id`=`pj`.`ProjectId`
WHERE `' at line 5 - Invalid query: SELECT *
FROM `tblprojects` as `pj`
LEFT JOIN `tblplanlayout` `pl` ON `pl`.`project_id`=`pj`.`ProjectId`
JOIN `tblgallery` `ga` ON `ga`.`project_id`=`pj`.`ProjectId`
OUTER JOIN `tblspecification` `sp` ON `sp`.`project_id`=`pj`.`ProjectId`
WHERE `pj`.`ProjectId` = '7'
AND `pl`.`is_deleted` = '0'
AND `pj`.`is_deleted` = '0'
