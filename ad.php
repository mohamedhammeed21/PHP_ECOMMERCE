
<?php 

session_start();
$pageTitle="new add";
include "init.php";

if(isset( $_SESSION['user'])){
	$user =  $_SESSION['user'];
	if($_SERVER['REQUEST_METHOD']=='POST'){
		$name = $_POST['name'];
		$desc = $_POST['description'];
		$price = $_POST['price'];
		$countary = $_POST['country'];
		$status = $_POST['status'];
		$UID = $_SESSION['id'];
		$cat = $_POST['category'];
		if(!empty($name)){		
		$check = checkitem("Name","items",$name);
			if($check==	1){

				$msg= "<div class='alert alert-danger'> ITEM exist </div>";
				redirecthome($msg,2,"back");

			}else{

			$stmt = $con->prepare("INSERT INTO  items
			(Name,Description,Price,Country,Status,Add_Date,Member_ID,Cat_ID) 	
			VALUES
			(:user, :pass, :email , :name,:com,now(),:mem,:cat      )");

				$stmt->execute(array('user' => $name,'pass' => $desc,'email' => $price,'name' => $countary,'com' => $status,'mem' => $UID,'cat' => $cat ));

				$msg= "<div class='alert alert-success'>" . $stmt->rowCount() . " record </div>";
				 redirecthome($msg,$seconds=3,"back");

			}
	}
	}

	?>
	<h1 class="text-center">add Item</h1>
	<div class="container">
		<form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']; ?> " method="POST">
			<div class="from-group">
				<label class="col-sm-2 control-label">Name</label>
				<div class="col-sm-0">
					<input type="text" name="name" class="form-control" autocomplete="off"  required="required" />
				</div>
			</div>
			<div class="from-group">
				<label class="col-sm-2 control-label">Description</label>
				<div class="col-sm-0">
					<input type="text" name="description" class="form-control" autocomplete="off"   />
				</div>
			</div>
			<div class="from-group">
				<label class="col-sm-2 control-label">Price</label>
				<div class="col-sm-0">
					<input type="text" name="price" class="form-control" autocomplete="off"   />
				</div>
			</div>
			<div class="from-group">
				<label class="col-sm-2 control-label">Country_made</label>
				<div class="col-sm-0">
					<input type="text" name="country" class="form-control" autocomplete="off"   />
				</div>
			</div>
			<div class="from-group">
				<label class="col-sm-2 control-label">Status</label>
				<div class="col-sm-0" name="status">
					<select name="status">
						<option value="0">.....</option>
						<option value="1">new</option>
						<option value="2">like new</option>
						<option value="3">used</option>
						<option value="4">old</option>	
					</select>
				</div>
			</div>
		<!-- members-->
		
<?php 
$stmt=$con->prepare("SELECT UserID FROM users WHERE Username=?");
$stmt->execute(array($_SESSION['user']));
$user=$stmt->fetch();							
$user['UserID'];
?>	


		<div class="from-group">
			<label class="col-sm-2 control-label">category</label>
			<div class="col-sm-0">
				<select name="category">
					<option value="0" >.....</option>
					<?php 

						$stmt=$con->prepare("SELECT * FROM categories ");
						$stmt->execute();
						$users=$stmt->fetchAll();
						foreach ($users as $user) {

echo "<option value='" . $user['ID']."'>".$user['Name']."</option>";
							# code...
						}
						?>	
				</select>
			</div>
		</div>

									
		<div class="from-group">
			<div class="col-sm-offset-2 col-sm-0">
				<input type="submit" value="+ Add" class="btn btn-primary" />
			</div>
		</div>
	</form>
</div>

<?php
}else{

	header('location:login.php');
	exit();
}



include $tpl."footer.php";

?>