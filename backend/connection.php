<?php

ini_set('zlib.output_compression','On');
ini_set('display_errors', '0');
ini_set('session.auto_start', '0');
ini_set('session.use_cookies', '1');
ini_set('session.gc_maxlifetime', 43200);
ini_set('register_globals', '0');
ini_set('auto_detect_line_endings', true);

session_set_cookie_params (0);
session_cache_limiter('nocache');
session_name('BXAF_' . md5(dirname(__FILE__)));
session_start();
error_reporting(0);

include_once("library/bxaf_mysqli.min.php");


// Database Connection
$db_settings = array(
	'user'    => 'qqqlllyyyy',
	'pass'    => 'bioinforx',
	'db'      => 'michael'
);
$DB = new bxaf_mysqli($db_settings);
$DB->Execute("SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
$DB->SetFetchMode(ADODB_FETCH_ASSOC);

// Config Settings
$CONFIG['TBL_USER'] = 'UserAuth_User';
