<?php

ob_start();
$pageTitle="categories";

session_start();

if(isset($_SESSION['Username'])){

		include "init.php";
		
		$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

		if($do=='manage'){

			

			$stmt2=$con->prepare("SELECT * FROM items");
			$stmt2->execute();
			$rows = $stmt2->fetchAll();

			if (! empty($rows)) {	?>
	<h1 class="text-center">Manage Members</h1>
	<div class="container">
		<div class="table-responsive">
			<table class="main-table manage-members text-center table table-bordered">
				<tr>
					<td>#ID</td>
					<td>name</td>
					<td>description</td>
					<td>Price</td>
					<td>Add_Date</td>
					<td>Country</td>
					<td>Image</td>
					<td>Status</td>
					<td>Rating</td>
					<td>Cat_ID</td>
					<td>Member_ID</td>

				</tr>
				<?php
					foreach($rows as $row) {
						echo "<tr>";
						echo "<td>" . $row['item_ID'] . "</td>";
						echo "<td>" . $row['Name'] . "</td>";
						echo "<td>" . $row['Description'] . "</td>";
						echo "<td>" . $row['Price'] . "</td>";
						echo "<td>" . $row['Add_Date'] ."</td>";
						echo "<td>" . $row['Country'] ."</td>";
						echo "<td>" . $row['Image'] ."</td>";
						echo "<td>" . $row['Status'] ."</td>";
						echo "<td>" . $row['Rating'] ."</td>";
						echo "<td>" . $row['Cat_ID'] ."</td>";
						echo "<td>" . $row['Member_ID'] ."</td>";
						echo "<td>
						<a href='items.php?do=Edit&item_ID=" . $row['item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
						<a href='items.php?do=Delete&item_ID=" . $row['item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
						echo "</td>";
						echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a href="items.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Member
				</a>
			</div>

<?php 	}
		}elseif ($do=="insert") {

				if($_SERVER['REQUEST_METHOD'] == "POST"){
				echo '<h1 class="text-center">Insert Category</h1>';

			$name 		= $_POST['name'];
			$desc 		= $_POST['description'];
			$price 		= $_POST['price'];
			$countary 	= $_POST['country'];
			$status 	= $_POST['status'];
			$member 	= $_POST['member'];
			$cat 		= $_POST['category'];
			

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

						$stmt->execute(array('user' => $name,'pass' => $desc,'email' => $price,'name' => $countary,'com' => $status,'mem' => $member,'cat' => $cat ));

						$msg= "<div class='alert alert-success'>" . $stmt->rowCount() . " record </div>";
						 redirecthome($msg,$seconds=3,"back");

						}
				}

			}else{
			$msg = "<div class='alert alert-danger'>u cant browse this page directly </div>";
			redirecthome($msg,3,"back");
			}
			echo '</div>'; 
	

		}elseif ($do=="Delete") {

		}elseif ($do=='Update') {
	
		}elseif ($do=="Edit") {
			
		}elseif ($do=="Add") { 

?>
		
			<h1 class="text-center">Add Item</h1>
			<div class="container">
				<form class="form-horizontal" action="items.php?do=insert" method="POST">
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
						<div class="col-sm-0">
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
					<div class="from-group">
						<label class="col-sm-2 control-label">member</label>
						<div class="col-sm-0">
							<select name="member">
								<option value="0">.....</option>
								<?php 

									$stmt=$con->prepare("SELECT * FROM users ");
									$stmt->execute();
									$users=$stmt->fetchAll();
									foreach ($users as $user) {

	echo "<option value='" . $user['UserID']."'>".$user['Username']."</option>";
										# code...
									}
									?>	
							</select>
						</div>
					</div>

					<div class="from-group">
						<label class="col-sm-2 control-label">category</label>
						<div class="col-sm-0">
							<select name="category">
								<option value="0">.....</option>
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
				
		}elseif ($do=="Approve") { 
				
		}

		include $tpl."footer.php";
		


}else{

	header("location:index.php");
}
ob_end_flush();
 	