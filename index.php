<?php
/* SERVER SETTINGS */

$basePath = '/babytracker/';
$dbSettings = array('host', 'schema', 'user', 'password');

/* --------------- */

session_start();

function __autoload($class) {
    include 'class.'.$class.'.php';
}
$db = new db($dbSettings);
$db->setErrorCallbackFunction('print');

$settingsFile = fopen(".settings", "r");
$settingsContent = fread($settingsFile, filesize(".settings"));
fclose($settingsFile);
$settings = unserialize($settingsContent);

foreach($settings as $var => $val) {
	$con = strtoupper($var);
	define($con, $val);
}


$babytracker = new babytracker();

$urlInfo = parse_url('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
$paths = explode('/',str_replace($basePath, "", $urlInfo['path']));

$mainPath = $paths[0];
$infoPath = !empty($paths[1]) ? $paths[1] : null;

if(!empty($mainPath)) $view = "inc_{$mainPath}.php";
else $view = "inc_list.php";


include("inc_header.php");

include($view);

include("inc_footer.php");


?>



