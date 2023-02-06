<?php
	
	include "connect.php";
	$lang = "includes/languages/";
	$tpl = "includes/templates/";  // template dir
	$css = "layout/css/"; //css dir
	$js = "layout/js/"; //js dir
	$func='includes/functions/';

	include $func."functions.php";
	include $lang."english.php";
	include $tpl."header.php";

	if(!isset($noNavbar)){ include $tpl."navbar.php";}