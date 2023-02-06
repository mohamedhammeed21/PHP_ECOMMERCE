<?php

ob_start();
$pageTitle="";
session_start();

if(isset($_SESSION['username'])){

		include "init.php";
		include $tpl."footer.php";

		$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

		if($do=='manage'){

		}elseif ($do=="insert") {
			# code...
		}elseif ($do=="Delete") {
			# code...
		}elseif ($do=="Update") {
			# code...
		}elseif ($do=="Activate") {
			# code...
		}elseif ($do=="Add") {
			# code...
		}

}else{

	header("location:index.php");
}
ob_end_flush();
