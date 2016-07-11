<!doctype html>
<html class="no-js" lang="en" style="height: 100%;">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php print NAME; ?></title>

    <link rel="stylesheet" href="<?php print $basePath; ?>css/app.css">
    <link rel="stylesheet" href="<?php print $basePath; ?>css/foundation-icons/foundation-icons.css">

  </head>
  <body>

	<div data-sticky-container>  	
		<div class="expanded button-group" data-sticky data-options="marginTop:0;" style="width:100%; height: 40px;">
<?php
	$activeNew = $mainPath == 'new' ? 'success' : null;
	$activeCharts = $mainPath == 'charts' ? 'success' : null;
	$activeSettings = $mainPath =='settings' ? 'success' : null;
	$activeList = empty($mainPath) ? 'success' : null;

	print <<< html
		  <a href="{$basePath}new" class="button nav-button $activeNew"><i class="fi-plus button-icon"></i></a>
		  <a href="{$basePath}charts" class="button nav-button $activeCharts"><i class="fi-graph-trend button-icon"></i></a>
		  <a href="{$basePath}" class="button nav-button $activeList"><i class="fi-list button-icon"></i></a>
		  <a href="{$basePath}settings" class="button nav-button $activeSettings"><i class="fi-widget button-icon"></i></a>
html;
?>
		</div>
	</div>
	<div class="row">
		<div class="small-12 columns">