<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8" />
		<title><?php  getTitle(); ?></title>

		
<?php

if(isset($_SESSION['user'])){
echo '<a href="profile.php">profile</a>';
}else{
?>
<a href="login.php">
          <span class="pull-right">login/signup </span>
      </div>
    </div>
<?php 
} 
?>
		<a href="ad.php"> | new_add   </a>
		<link rel="stylesheet" href="<?php echo $css; ?>bootstrap.css">
		<link rel="stylesheet" href="<?php echo $css; ?>font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo $css; ?>backend.css">

	</head>
	<body>