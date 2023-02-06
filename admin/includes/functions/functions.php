<?php

	

	function getTitle() {

		global $pageTitle;

		if (isset($pageTitle)) {

			echo $pageTitle;

		} else {

			echo 'Default';

		}
	}
function redirecthome($msg,$seconds=3,$url=null){

	if($url==null){
		$url="index.php";

	}elseif(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== ''){
		
		$url=$_SERVER['HTTP_REFERER'];
	
	}else{

		$url="index.php";
	}
	
	echo $msg;
	echo "<div class='alert alert-info'> you will be reirect after " .$seconds ." seconds " . "</div>";
	header("refresh:$seconds;url=$url");
	exit();

	}



	
function checkitem($select,$from,$value){
	global $con;
	$statement=$con->prepare("SELECT $select FROM $from WHERE $select =?");
	$statement->execute(array($value));
	$count = $statement->rowCount();
	
	return $count;





}


function countItems($item,$table){
	
		global $con;


		$stmt2=$con->prepare("SELECT COUNT($item) FROM $table");
		$stmt2->execute();

		return $stmt2->fetchColumn();
}

function getlatest($recoed,$table,$order,$limit=3){

	global $con;

	$gstmt=$con->prepare("SELECT $recoed FROM $table ORDER BY $order DESC LIMIT  $limit ");
	$gstmt->execute();
	$rows=$gstmt->fetchAll();
	return $rows;
}