<?php
session_start();
$pageTitle="members";

if(isset($_SESSION['Username'])){
	include "init.php";
	include $tpl."footer.php";

	$do = isset($_GET['do']) ? $_GET['do'] : 'manage';
	
	
	if($do=='manage'){ 

		$query='';
		if(isset($_GET['page']) && $_GET['page'] == "pending" ){
			$query='AND RegStatus=0';
		}
	$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query  ORDER BY UserID DESC");
	$stmt->execute();
	$rows = $stmt->fetchAll();
	if (! empty($rows)) {	?>
	<h1 class="text-center">Manage Members</h1>
	<div class="container">
		<div class="table-responsive">
			<table class="main-table manage-members text-center table table-bordered">
				<tr>
					<td>#ID</td>
					<td>Avatar</td>
					<td>Username</td>
					<td>Email</td>
					<td>Full Name</td>
					<td>Registered Date</td>
					<td>Control</td>
				</tr>
				<?php
					foreach($rows as $row) {
						echo "<tr>";
						echo "<td>" . $row['UserID'] . "</td>";
						echo "<td>";
						if (empty($row['avatar'])) {
							echo 'No Image';
						} else {
							echo "<img src='uploads/avatars/" . $row['avatar'] . "' alt='' />";
						}
						echo "</td>";
						echo "<td>" . $row['Username'] . "</td>";
						echo "<td>" . $row['Email'] . "</td>";
						echo "<td>" . $row['FullName'] . "</td>";
						echo "<td>" . $row['Date'] ."</td>";
						echo "<td>
							<a href='members.php?do=Edit&userid=" . $row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
							<a href='members.php?do=Delete&userid=" . $row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete </a>";
							if ($row['RegStatus'] == 0) {
								echo "<a href='members.php?do=Activate&userid=" . $row['UserID'] . "' 
								class='btn btn-info activate'>
								<i class='fa fa-check'></i> Activate</a>";
								}
								echo "</td>";
								echo "</tr>";
							}
						?>
						<tr>
					</table>
				</div>
				<a href="members.php?do=add" class="btn btn-primary">
					<i class="fa fa-plus"></i> New Member
				</a>
			</div>

<?php 	}}elseif($do=='Edit'){ 

		$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?	 intval($_GET['userid']) :  0;
		// echo $user;
		$stmt = $con->prepare("SELECT * FROM  users WHERE UserID=? LIMIT 1");

		$stmt->execute(array($userid));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();
		
		if($count > 0){
			?>

		<h1 class="text-center">Edit members</h1>
			<div class="container">
				<form class="form-horizontal" action="?do=update" method="POST">
					<input type="hidden" name="userid" value="<?php echo $userid ?> " >
					<dev class="from-group">
						<label class="col-sm-2 control-label">UserName</label>
						<div class="col-sm-0">
							<input type="text" name="username" class="form-control" autocomplete="off" value="<?php echo $row['Username']; ?>" required="required" />
						</div>
					</dev>
					<dev class="from-group">
						<label class="col-sm-2 control-label">Password</label>
						<div class="col-sm-0">
							<input type="hidden" name="oldpassword" class="form-control" value="<?php echo $row['Password']; ?>"/>
							<input type="password" name="newpassword" class="form-control" autocomplete="new-password" />
						</div>
					</dev>
					<dev class="from-group">
						<label class="col-sm-2 control-label">Emial</label>
						<div class="col-sm-0">
							<input type="email" name="email" class="form-control" value="<?php echo $row['Email']; ?>" required="required"/>
						</div>
					</dev>
					<dev class="from-group">
						<label class="col-sm-2 control-label">FullName</label>
						<div class="col-sm-0">
							<input type="text" name="FullName" class="form-control" value="<?php echo $row['FullName']; ?>" required="required" />
						</div>
					</dev>
					<dev class="from-group">
						<div class="col-sm-offset-2 col-sm-0">
							<input type="submit" value="save" class="btn btn-primary" />
						</div>
					</dev>
				</form>
			</div>


<?php	

		}else{
			$error = "user not found";
				redirecthome($error,5);
		}

	}elseif ($do=='add') {
	
	?>

		<h1 class="text-center">Add members</h1>
			<div class="container">
				<form class="form-horizontal" action="members.php?do=insert" method="POST"  enctype="multipart/form-data">
					<dev class="from-group">
						<label class="col-sm-2 control-label">UserName</label>
						<div class="col-sm-0">
							<input type="text" name="username" class="form-control" autocomplete="off"   />
						</div>
					</dev>
					<dev class="from-group">
						<label class="col-sm-2 control-label">Password</label>
						<div class="col-sm-0">
							
							<input type="password" name="password" class="form-control" autocomplete="new-password" />
						</div>
					</dev>
					<dev class="from-group">
						<label class="col-sm-2 control-label">Emial</label>
						<div class="col-sm-0">
							<input type="email" name="email" class="form-control" />
						</div>
					</dev>
					<dev class="from-group">
						<label class="col-sm-2 control-label">FullName</label>
						<div class="col-sm-0">
							<input type="text" name="FullName" class="form-control"   />
						</div>
					</dev>
					<dev class="from-group">
						<label class="col-sm-2 control-label">image</label>
						<div class="col-sm-0">
							<input type="file" name="file" class="form-control"   />
						</div>
					</dev>
					<dev class="from-group">
						<div class="col-sm-offset-2 col-sm-0">
							<input type="submit" value="Add" class="btn btn-primary" />
						</div>
					</dev>
				</form>
			</div>


<?php	

}elseif ($do=='insert') {

	if($_SERVER['REQUEST_METHOD'] == "POST"){

			echo '<h1 class="text-center">Insert members</h1>';
			
			$user 	= $_POST['username'];
			$email 	= $_POST['email'];
			$name 	= $_POST['FullName'];
			$pass 	= $_POST['password'];
			
			$hpass 	= sha1($_POST['password']);

			$target_dir = "C:\Users\pc\Desktop\\";
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

			// Check if image file is a actual image or fake image

			
			    $check = getimagesize($_FILES["file"]["tmp_name"]);
			    if($check !== false) {
			        
			        echo "<br>";
			        echo "<br>";
			        $uploadOk = 1;
			    } else {
			        echo "File is not an image.";
			        echo "<br>";
			        echo "<br>";
			        $uploadOk = 0;
			    }
			

		// Check if file already exists

			if (file_exists($target_file)) {
			    echo "Sorry, file already exists.";
			    echo "<br>";
			    echo "<br>";
			    $uploadOk = 0;
			}

		// Check file size

			if ($_FILES["file"]["size"] > 500000) {
			    echo "Sorry, your file is too large.";
			    echo "<br>";
			    echo "<br>";
			    $uploadOk = 0;
			}

		// Allow certain file formats

			if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
			&& $imageFileType != "gif" ) {
			    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
				echo "<br>";
				echo "<br>";
			    $uploadOk = 0;
			}

		// Check if $uploadOk is set to 0 by an error

			if ($uploadOk == 0) {
			    echo "Sorry, your file was not uploaded.";
			    echo "<br>";
			    echo "<br>";

		// if everything is ok, try to upload file

			} else {
			    if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
			        echo "The file ". basename( $_FILES["file"]["name"]). " has been uploaded.";
			        echo "<br>";
			        echo "<br>";
			    } else {
			        echo "Sorry, there was an error uploading your file.";
			        echo "<br>";
			        echo "<br>";
			    }
			}
				

			//validate

			$formerrors = array();
			if(strlen($user) < 4 ){
				$formerrors[]="<div class='alert alert-danger'> user cant be less than 4 chars </div>";
			}
			if(empty($user)){
					$formerrors[]="<div class='alert alert-danger'>user cant be empty</div>";

			}
			if(empty($name)){
					$formerrors[]="<div class='alert alert-danger'>full name cant be empty</div>";
					
			}
			if(empty($email)){
					$formerrors[]="<div class='alert alert-danger'>email cant be empty </div>";
					
			}
			if(empty($pass)){
					$formerrors[]="<div class='alert alert-danger'>password cant be empty </div>";
					
			}
			foreach ($formerrors as $error) {
				echo $error . "<br>";
				}
			//insert
				if(empty($formerrors)){

					$check= checkitem("Username","users",$user);
	
					if($check == 0){
						
					

					$stmt = $con->prepare("INSERT INTO  users
						(Username,Password,Email,FullName,RegStatus,Date) 	
						VALUES
						(:user, :pass, :email , :name,1,now())");

					$stmt->execute(array('user' => $user,'pass' => $hpass,'email' => $email,'name' => $name));

					$msg= "<div class='alert alert-success'>" . $stmt->rowCount() . " record </div>";
					 redirecthome($msg,$seconds=3,"back");

					}else{
							$msg= "<div class='alert alert-danger'> username exist </div>";
							redirecthome($msg,3,"back");
						}
					}
		}else{
			$msg = "<div class='alert alert-danger'>u cant browse this page directly </div>";
			redirecthome($msg,3,"back");
			}
		echo '</div>'; 


	# code...
}elseif ($do=='Delete') {
	echo '<h1 class="text-center">Delete members</h1>';
	echo '<div class="container">';

	$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?	 intval($_GET['userid']) :  0;
		// echo $user;
		$stmt = $con->prepare("SELECT * FROM  users WHERE UserID=? LIMIT 1");

		$stmt->execute(array($userid));
		$count = $stmt->rowCount();
		
		if($count > 0){
			
			$stmt=$con->prepare("DELETE FROM users WHERE UserID=?");
			$stmt->execute(array($userid));
			$msg= "<div class='alert alert-success'>user deleted successfully </div>";
					 redirecthome($msg,$seconds=1,"back");
		}else{
			$msg= "<div class='alert alert-success'> user not exist </div>";
					 redirecthome($msg,$seconds=1,"back");
		}

	# code...
}
elseif ($do == 'update') {
	
	echo '<h1 class="text-center">Update members</h1>';
	echo '<div class="container">';
	if($_SERVER['REQUEST_METHOD'] == "POST"){

			$id 	= $_POST['userid'];
			$user 	= $_POST['username'];
			$email 	= $_POST['email'];
			$name 	= $_POST['FullName'];
			//echo $user.$email.$name;
			$pass= empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

			//validate
			$formerrors = array();
			if(strlen($user) < 4 ){
				$formerrors[]="<div class='alert alert-danger'> user cant be less than 4 chars </div>";
			}
			if(empty($user)){
					$formerrors[]="<div class='alert alert-danger'>user cant be empty</div>";

			}
			if(empty($name)){
					$formerrors[]="<div class='alert alert-danger'>full name cant be empty</div>";
					
			}
			if(empty($email)){
					$formerrors[]="<div class='alert alert-danger'>email cant be empty </div>";
					
			}
			foreach ($formerrors as $error) {
				echo $error . "<br>";
				# code...
			}
			//update
				if(empty($formerrors)){
				$stmt = $con->prepare("UPDATE users SET Username =?, Email= ?, FullName= ?,Password=? WHERE UserID= ?");

				$stmt->execute(array($user,$email,$name,$pass,$id));
				echo "<div class='alert alert-success'>" . $stmt->rowCount() . " record updated </div>";
				}
			}else{
				$error = "u cant browse this page directly ";
				redirecthome($error,5);
			}
			echo '</div>';

		}elseif ($do == "Activate") {
			echo '<h1 class="text-center">Activate members</h1>';
			echo '<div class="container">';

			$userid = isset($_GET['userid']) && is_numeric($_GET['userid']) ?	 intval($_GET['userid']) :  0;
			// echo $user;
			$stmt = $con->prepare("SELECT * FROM  users WHERE UserID=? LIMIT 1");

			$stmt->execute(array($userid));
			$count = $stmt->rowCount();
		
			if($count > 0){
			
			$stmt=$con->prepare("UPDATE users SET Regstatus = 1  WHERE UserID=?");
			$stmt->execute(array($userid));
			$msg= "<div class='alert alert-success'>user Activated successfully </div>";
					 redirecthome($msg,$seconds=1,"back");
		}else{
			$msg= "<div class='alert alert-success'> user not exist </div>";
					 redirecthome($msg,$seconds=1,"back");
		}
		}

}else{
	header('location: index.php');
	exit();
}
