<?php
if(isset($_POST['supplierName'])&&
	isset($_POST['contact'])&&
	isset($_POST['email'])){
		
		$name = $db->real_escape_string(strtoupper(trim($_POST['supplierName'])));
		$contact = $db->real_escape_string(trim($_POST['contact']));
		$email = $db->real_escape_string(trim($_POST['email']));

	if($insert = $db->query("INSERT INTO suppliers (name, contact, email)
		VALUES ('{$name}', '{$contact}', '{$email}')")or die($db->error)){
			//echo $db->affected_rows;
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Suppliers</title>
		<style>
			th,td{border:1px solid black; }
			td.number{text-align:right;}
		</style>
	</head>
	<body>		
		<form name = "addSupplier" method = "post" action = "">
			Supplier Name: <input type = "text" name = "supplierName" required/>
			Contact: <input type = "phone" name = "contact" required/> 
			Email: <input type = "email" name = "email"/> 
			<button type="submit">Add Supplier</button>
			<button type="reset">Cancel</button>
			<hr>
		</form>
		<?php 
			$records = array();
			$results = $db->query("SELECT * FROM suppliers")/*or die($db->error)*/;
		
			if($count = $results->num_rows){
				echo '<p>', $count, ' suppliers</p>';
				
				while($row = $results->fetch_object()){
					$records[] = $row;
				}
					$results->free();
			}
		?>
		 <?php  
		 if (!count($records)){
			 echo'No suppliers in the db';
		 }else{
		 ?>
		<table>
			<tr>
				<th>Supplier ID</th>
				<th>Name</th>
				<th>Contact</th>
				<th>Email</th>
				
			</tr>
			<?php 
				foreach($records as $r){
			?>
			<tr>
				<td><?php echo $r->supplierID;?></td>
				<td><?php echo $r->name;?></td>
				<td><?php echo $r->contact;?></td>
				<td><?php echo $r->email;?></td>
			</tr></a>
			<?php 
				}
			?>
		</table>
		<?php
		 }
		?>
	</body>
</html>