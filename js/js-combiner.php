<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require("/www/php_includes/minify/src/Minify.php");
require("/www/php_includes/minify/src/JS.php");
require("/www/php_includes/minify/src/Exception.php");
use MatthiasMullie\Minify;
$minifier = new Minify\JS();

function jsCombiner($files, $filename, $create = false) {
	global $minifier;

	$cachefile = '/www/cast/js/'.$filename;
	if(file_exists($cachefile) && !$create) { 
		$content = file_get_contents($cachefile);
		if(!empty($content)) {
			echo $content;
			die();
		}
	}

	foreach($files as $file) {
		$minifier->add("/www/cast/js/".$file);
	}
	$content = $minifier->minify();

	$cached = fopen($cachefile, 'w');
	fwrite($cached, $content);
	fclose($cached);
}

function jsMinify($files, $create = false) {
	global $minifier;

	foreach($files as $file) {
		$cachefile = '/www/cast/js/m.'.$file;
		if(file_exists($cachefile) && !$create) { 
			$content = file_get_contents($cachefile);
			if(!empty($content)) {
				echo "<script>$content</script>";
				die();
			}
		}

		$minifier->add("/www/cast/js/".$file);
		$content = $minifier->minify();
		print "<script>$content</script>";

		$cached = fopen($cachefile, 'w');
		fwrite($cached, $content);
		fclose($cached);
	}
}

?>