<?php  include "init.php";

			$stmt2=$con->prepare("SELECT * FROM items");
			$stmt2->execute();
			$rows = $stmt2->fetchAll();

			if (! empty($rows)) {	
?>
	<h1 class="text-center">ITEMS</h1>
	<div class="container">
		<div class="table-responsive">
			<table class="main-table manage-members text-center table table-bordered">
				<tr>
					<td>name</td>
					<td>description</td>
					<td>Price</td>
					<td>Add_Date</td>
					<td>Country</td>
					<td>Image</td>
					<td>Status</td>
					<td>Rating</td>

				</tr>
<?php
					foreach($rows as $row) {
						echo "<tr>";
						echo "<td>" . $row['Name'] . "</td>";
						echo "<td>" . $row['Description'] . "</td>";
						echo "<td>" . $row['Price'] . "</td>";
						echo "<td>" . $row['Add_Date'] ."</td>";
						echo "<td>" . $row['Country'] ."</td>";
						echo "<td>" . $row['Image'] ."</td>";
						echo "<td>" . $row['Status'] ."</td>";
						echo "<td>" . $row['Rating'] ."</td>";
						echo "</tr>";
							}
?>
						<tr>
					</table>
				</div>

			</div>






<?php }
include $tpl."footer.php"; 
?>
