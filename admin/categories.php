<?php

ob_start();
$pageTitle="categories";

session_start();

if(isset($_SESSION['Username'])){

		include "init.php";
		
		$do = isset($_GET['do']) ? $_GET['do'] : 'manage';

		if($do=='manage'){

			$sort="DESC";
			$sort_array=array('ASC','DESC');
			if(isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
				$sort=$_GET['sort'];
			}

			$stmt2=$con->prepare("SELECT * FROM categories ORDER BY ordering $sort");
			$stmt2->execute();
			$get = $stmt2->fetchAll();?>

			<h1 class="text-center">Categories</h1>
			<div class="ordering pull-center">
				ORDERING
				<a href="?sort=ASC">ASC </a> |
				<a href="?sort=DESC">DESC</a>
			</div>
			<div class="container">
				<div class="panel panel-default">
					<div class="panel-heading">manage categories</div>
					<div class="panle-body"></div>
					<?php
						foreach ($get  as $a ) {

							echo "<h3>" . $a['Name']."<br>" . "</h3>";
							echo $a['Description'];
							echo " visibility ".$a['Visibility'];
							echo " comments ".$a['Allow_Comment'];
							echo " ads  ".$a['Allow_Ads'];
							echo "<a href='categories.php?do=Edit&catid=" . $a['ID'] . "' class='btn btn-success text-left' ><i class='fa fa-edit'></i> Edit</a>";
							echo "<a href='categories.php?do=Delete&catid=" . $a['ID'] . "' 
								class='btn btn-danger'>
								<i class='fa fa-close'></i> Delete</a>";
							# code...
						}
					?>
				</div>
			</div>

			<?php

		}elseif ($do=="insert") {

		if($_SERVER['REQUEST_METHOD'] == "POST"){

			echo '<h1 class="text-center">Insert Category</h1>';

			$name 	= $_POST['name'];
			$desc 	= $_POST['description'];
			$order 	= $_POST['ordering'];
			$visible 	= $_POST['visibility'];
			$comment 	= $_POST['commenting'];
			$ads 	= $_POST['ads'];
			

				if(!empty($name)){	
						
					$check = checkitem("Name","categories",$name);
					if($check==	1){

						$msg= "<div class='alert alert-danger'> category exist </div>";
						redirecthome($msg,2,"back");

					}else{

						$stmt = $con->prepare("INSERT INTO  categories
							(Name,Description,Ordering,Visibility,Allow_Comment,Allow_Ads) 	
							VALUES
							(:user, :pass, :email , :name,:com,:ads)");

						$stmt->execute(array('user' => $name,'pass' => $desc,'email' => $order,'name' => $visible,'com' => $comment,'ads' => $ads ));

						$msg= "<div class='alert alert-success'>" . $stmt->rowCount() . " record </div>";
						 redirecthome($msg,$seconds=3,"back");

						}
				}

			}else{
			$msg = "<div class='alert alert-danger'>u cant browse this page directly </div>";
			redirecthome($msg,3,"back");
			}
			echo '</div>'; 
	

			# code...
		}elseif ($do=="Delete") {

			echo '<h1 class="text-center">Delete categories</h1>';
			echo '<div class="container">';

			$id = isset($_GET['catid']) && is_numeric($_GET['catid']) ?	 intval($_GET['catid']) :  0;
		// echo $user;
		$stmt = $con->prepare("SELECT * FROM  categories WHERE ID=? LIMIT 1");

		$stmt->execute(array($id));
		$count = $stmt->rowCount();
		
		if($count > 0){
			
			$stmt=$con->prepare("DELETE FROM categories WHERE ID=?");
			$stmt->execute(array($id));
			$msg= "cat deleted successfully ";
					 redirecthome($msg,1,"back");
		}else{
			$msg= "cat not exist ";
					 redirecthome($msg,2,"back");
		}

			# code...
		}elseif ($do=='Update') {

	echo '<h1 class="text-center">Update categories</h1>';
	echo '<div class="container">';
	if($_SERVER['REQUEST_METHOD'] == "POST"){


			$name 	= $_POST['name'];
			$desc 	= $_POST['description'];
			$order 	= $_POST['ordering'];
			$visible 	= $_POST['visibility'];
			$comment 	= $_POST['commenting'];
			$ads 	= $_POST['ads'];
			$id=$_POST['id'];

			$stmt4=$con->prepare("UPDATE categories SET Name =?, Description= ?, Ordering= ?,Visibility=?,Allow_Comment=?,Allow_Ads=? WHERE ID= ?");

			$stmt4->execute(array($name,$desc,$order,$visible,$comment,$ads,$id));
				$msg = $stmt4->rowCount() . " recoed updated";
				redirecthome($msg,2);
			
			
			}else{
				$error = "u cant browse this page directly ";
				redirecthome($error,5);
			}
			echo '</div>';

		}
		elseif ($do=="Edit") {
			$catid = isset($_GET['catid']) && is_numeric($_GET['catid']) ?	 intval($_GET['catid']) :  0;
		// echo $user;
		$stmt = $con->prepare("SELECT * FROM  categories WHERE ID =? LIMIT 1");

		$stmt->execute(array($catid));

		$cat = $stmt->fetch();
		$count = $stmt->rowCount();

		
		if($count > 0){?>
			<h1 class="text-center">Edit category</h1>
			<div class="container">
				<form class="form-horizontal" action="categories.php?do=Update" method="POST">
					<input type="hidden" name="id" value="<?php echo $cat['ID']; ?>">
					<div class="from-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-0">
							<input type="text" name="name" class="form-control" value="<?php echo $cat['Name']; ?>"  required="required" />
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">description</label>
						<div class="col-sm-0">
							<input type="text" name="description" class="form-control"  value="<?php echo $cat['Description']; ?>"/>
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">orerding</label>
						<div class="col-sm-0">
							<input type="text" name="ordering" class="form-control"/
							value="<?php echo $cat['Ordering']; ?>">
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">visibility</label>
						<div class="col-sm-0">
							<div class="text-left">
								<input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility']==0){echo 'checked';} ?>>
								<label for="vis-yes">yes</label>
							</div>
							<div class="text-left">
								<input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility']==1){echo 'checked';} ?> >
								<label for="vis-no">no</label>
							</div>
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">allow commenting</label>
						<div class="col-sm-0">
							<div class="text-left">
								<input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment']==0){echo 'checked';} ?>>
								<label for="com-yes">yes</label>
							</div>
							<div class="text-left">
								<input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment']==1){echo 'checked';} ?>>
								<label for="com-no">no</label>
							</div>
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">allow ads</label>
						<div class="col-sm-0">
							<div class="text-left">
								<input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads']==0){echo 'checked';} ?>>
								<label for="ads-yes">yes</label>
							</div>
							<div class="text-left">
								<input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads']==1){echo 'checked';} ?> >
								<label for="ads-no">no</label>
							</div>
						</div>
					</div>							
					<div class="from-group">
						<div class="col-sm-offset-2 col-sm-0">
							<input type="submit" value="Update" class="btn btn-primary" />
						</div>
					</iev>
				</form>
			</div>

		


<?php	

		}else{
			$error = "  ID not found";
				redirecthome($error,5);
		}
			# code...
		}elseif ($do=="Add") { 
		?>
		
			<h1 class="text-center">Add category</h1>
			<div class="container">
				<form class="form-horizontal" action="categories.php?do=insert" method="POST">
					<div class="from-group">
						<label class="col-sm-2 control-label">Name</label>
						<div class="col-sm-0">
							<input type="text" name="name" class="form-control" autocomplete="off"  required="required" />
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">description</label>
						<div class="col-sm-0">
							<input type="text" name="description" class="form-control"  />
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">orerding</label>
						<div class="col-sm-0">
							<input type="text" name="ordering" class="form-control"/>
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">visibility</label>
						<div class="col-sm-0">
							<div class="text-left">
								<input id="vis-yes" type="radio" name="visibility" value="0" checked>
								<label for="vis-yes">yes</label>
							</div>
							<div class="text-left">
								<input id="vis-no" type="radio" name="visibility" value="1" >
								<label for="vis-no">no</label>
							</div>
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">allow commenting</label>
						<div class="col-sm-0">
							<div class="text-left">
								<input id="com-yes" type="radio" name="commenting" value="0" checked>
								<label for="com-yes">yes</label>
							</div>
							<div class="text-left">
								<input id="com-no" type="radio" name="commenting" value="1" >
								<label for="com-no">no</label>
							</div>
						</div>
					</div>
					<div class="from-group">
						<label class="col-sm-2 control-label">allow ads</label>
						<div class="col-sm-0">
							<div class="text-left">
								<input id="ads-yes" type="radio" name="ads" value="0" checked>
								<label for="ads-yes">yes</label>
							</div>
							<div class="text-left">
								<input id="ads-no" type="radio" name="ads" value="1" >
								<label for="ads-no">no</label>
							</div>
						</div>
					</div>							
					<div class="from-group">
						<div class="col-sm-offset-2 col-sm-0">
							<input type="submit" value="Add" class="btn btn-primary" />
						</div>
					</iev>
				</form>
			</div>



		<?php
		
		}

		include $tpl."footer.php";
		echo "<a href=?do=Add>Add category</a>";


}else{

	header("location:index.php");
}
ob_end_flush();
 	