<?php  include "init.php";?>


<div class="container">

	<h1 class="text-center" ><?php echo $_GET['name']; ?></h1>
<?php 


  $item= getitem2($_GET['pageid']);
  foreach ($item as $a ) {

    echo $a['Name']."<br>";        
 }?>
</div>




<?php include $tpl."footer.php"; ?>