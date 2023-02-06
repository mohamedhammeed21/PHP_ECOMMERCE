<?php 
	session_start();
	
	$pageTitle="login";

	if(isset($_SESSION['user'])){
			header('location:index.php');
	}
	include "init.php";


	if ($_SERVER['REQUEST_METHOD'] == "POST") {

			if(isset($_POST['login'])){

			$username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
			$password = $_POST['password'];
			$hashedpass = sha1($password);

			$stmt = $con->prepare("SELECT UserID,Username,Password FROM  users WHERE Username = ? AND Password = ? ");

			$stmt->execute(array($username,$hashedpass));
			$row = $stmt->fetch();
			$count = $stmt->rowCount();
				if($count > 0){
					
					$_SESSION['user'] = $username;
					$_SESSION['id'] = $row['UserID'];
					header('location:index.php');
					exit();

					}else{
						echo "failed";
				}
			}

			elseif (isset($_POST['signup'])) {
				$username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
				$password = $_POST['password'];
				$email    = filter_var($_POST['email'],FILTER_SANITIZE_EMAIL);
				$hashedpass = sha1($password);

				$check= checkitem("Username","users",$username);
				if($check == 0){

				$stmt=$con->prepare("INSERT INTO users (Username,Email,Password)
												 VALUES(:user,:mail,:pass)");

				$stmt->execute(array('user'=>$username,'mail'=>$email,'pass'=>$hashedpass));

				$msg = "user registered successfuly";
				redirecthome($msg,2,'login.php');
				}else{
					echo 'user exists';
				}

				
			}else{
				$formErrors = array();
				if(isset($_POST['username'])){
					$user = filter_var($_POST['username'],FILTER_SANITIZE_STRING);

					echo $user;
				}
			}



	}

?>
<div class="container">
	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
		<h1 class="text-center"><span class="login">login</span> </h1>
		<input class="form-control" type="text" name="username" autocomplete="off" placeholder="username">
		<input class="form-control" type="password" name="password" autocomplete="new-password"  placeholder="password">
		<input class="btn btn-primary" type="submit" name="login" value="login" autocomplete="off">
	</form>

	<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST"> 
		<h1 class="text-center"><span class="login">signup</span> </h1>
		<input class="form-control" type="text" name="username" autocomplete="off" placeholder="username">
		<input class="form-control" type="email" name="email" autocomplete="off" placeholder="email">
		<input class="form-control" type="password" name="password" autocomplete="new-password" placeholder="password">

		<input class="btn btn-success" type="submit" name="signup" value="signup" autocomplete="off" >
	</form>
</div>


<?php include $tpl."footer.php"; ?>