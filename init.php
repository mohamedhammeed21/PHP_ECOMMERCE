<?php
	// connect data base
	include "admin/connect.php";
	$lang = "includes/languages/";
	$tpl = "includes/templates/";  // template dir
	$css = "layout/css/"; //css dir
	$js = "layout/js/"; //js dir
	$func='includes/functions/';

	include $func."functions.php";
	include $lang."english.php";
	include $tpl."header.php";

	if(!isset($noNavbar)){ include $tpl."navbar.php";}

    // insert
    $stmt = $con->prepare("INSERT INTO  users
	   					(Username,Password,Email,FullName,RegStatus,Date) 	
						VALUES
						(:user, :pass, :email , :name,1,now())");

	$stmt->execute(array('user' => $user,'pass' => $hpass,'email' => $email,'name' => $name));

    //delete
    $stmt=$con->prepare("DELETE FROM users WHERE UserID=?");
			$stmt->execute(array($userid));

    //update
    $stmt = $con->prepare("UPDATE users 
                           SET
                           Username =?, Email= ?, FullName= ?,Password=? WHERE UserID= ?");
    $stmt->execute(array($user,$email,$name,$pass,$id));

    //foreach
    $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query  ORDER BY UserID DESC");
	$stmt->execute();
	$rows = $stmt->fetchAll();
	<tr>
    <td>#ID</td>
	</tr>
	<?php
	foreach($rows as $row) {
	echo "<tr>";
    echo "<td>" . $row['UserID'] . "</td>";
    echo "<tr>";
        
    //special if
    $do = isset($_GET['do']) ? $_GET['do'] : 'manage';
   
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        
        