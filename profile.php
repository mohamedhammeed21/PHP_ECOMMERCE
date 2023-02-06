<?php 

	session_start();
	
	$pageTitle="profile";
	include "init.php";
	if(isset( $_SESSION['user'])){
	$user =  $_SESSION['user'];
	echo "<center>welcome   ";
	 echo "<b>".$_SESSION['user']."<b>"; 
	$stmt=$con->prepare("SELECT * FROM users where Username=?");
	$stmt->execute(array($user));
	$datas=$stmt->fetch();

	?>
	<center>
	<h1 class="text-center">profile</h1>
		
	<label > +--+ username: <?php echo $datas['Username'];?></label>
	</br>
	<label>+--+ Email: <?php echo $datas['Email']; ?></label>
	</br>

	<label >+--+ Fullname: <?php echo $datas['FullName']; ?></label>
	</br>				
		<div class="container">
	<label><h1 class="text-center">ITEMS</h1></label>
	<br>

    </div>

<?php 


  $item= getitem($datas['UserID']);
  foreach ($item as $a ) {

    echo "#  ".$a['Name']."<br>";        
 }
 ?>
 </br>
 	<a href="ad.php" class="btn btn-primary">

					<i class="fa fa-plus"></i> New item
				</a>
</br>
</br>
</br>
</br>
<a href="?do=edit">## edit_profile</a>
</center>
<?php 

		




}else{

	header('location:login.php');
	exit();
}



include $tpl."footer.php";

?>