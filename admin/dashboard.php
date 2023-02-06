<?php
ob_start();
session_start();
$pageTitle="dashboard";



	if(isset($_SESSION['Username'])){

		include "init.php";
		$latest = getlatest("*","users","UserID",4);

?>

	<div class="conrtainer home-stats text-center">
		<h1>Dashboard</h1>
		<div class="row">
			<div class="col-md-3">
				<div class="stat">
					Members
					<a href="members.php"><span><?php echo countItems("UserId",'users')?></span></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat">Pending Members
									<a href="members.php?page=pending"><span><?php echo countItems("RegStatus",'users WHERE RegStatus=0')?></span></a>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat">
				Items
				<span>200</span>
				</div>
			</div>
			<div class="col-md-3">
				<div class="stat">
				Comments
				<span>200</span>
			</div>
			</div>
	<div class="container latest">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<i class="fa fa-users"></i> Latest Registerd Users
				</div>
				<div class="panel-body">
					<?php
						foreach ($latest as $value) {
					
					echo 	'<table class="main-table manage-members text-center table table-bordered">';
					
					

						
						echo "<tr>";
						echo "<td>" . $value['Username'] . "</td>";
						echo "<td><a href='members.php?do=Edit&userid=" . $value['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
						echo "</td>";
						echo "</tr>";
					

					echo "</table>";
				}
					?>
				</div>
			</div>
		</div>
	</div>
		
	</div>
	<div class="container latest">
		<div class="row">
			<div class="col-sm-6">
				<div class="panel panel-default">
					<i class="fa fa-users"></i> Latest Items
				</div>
				<div class="panel-body">
					test
				</div>
			</div>
		</div>
	</div>
		
	</div>
<?php		include $tpl."footer.php";

		
	}


	else{
			header('location: index.php');
			exit();
	}
ob_end_flush();

?>