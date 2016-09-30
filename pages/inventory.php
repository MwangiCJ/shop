<title>Inventory</title>
<h3>Inventory</h3>
<?php
if(isset($_POST['itemID'])&&
	isset($_POST['itemName'])&&
	isset($_POST['price'])&&
	isset($_POST['instock'])&&
	isset($_POST['supplier'])){
		$id = $_POST['itemID'];
		$item = $db->real_escape_string(strtoupper(trim($_POST['itemName'])));
		$price = $_POST['price'];
		$instock = $_POST['instock'];
		$supplierID = $_POST['supplier'];
	$query = "INSERT INTO inventory (itemID, item, price, instock, supplierID)
	VALUES ({$id}, '{$item}', {$price}, {$instock}, {$supplierID}) ";
	if($insert = $db->query($query)or die($db->error)){
			//echo $db->affected_rows;
		}
	}
?>	
	<form name = "addItem" method = "post" action = "">
		Barcode:<input type = "number" name = "itemID" required/>  
		Item Name: <input type = "text" name = "itemName" required/>
		Price: <input type = "number" name = "price" required/> 
		Instock: <input type = "number" name = "instock" required/> 
		Supplier: <select name="supplier" required>
						<option value = "0">Select Supplier</option>
						<?php
						suppliersDropDown();
						?>
					</select>
					<input type="hidden" name="action"/>
		<input type="hidden" name="hiddenID"/>
		<button type="submit">Add Item</button>
		<button type="reset">Cancel</button>
		<hr>
	</form>
		<?php 
			$records = array();
			$results = $db->query("SELECT * FROM inventory")/*or die($db->error)*/;
			
			//print_r($results);
			
			if($count = $results->num_rows){
				echo '<p>', $count, ' total items: <span style="color:red;">'.lessItems().' </span> needs reodering</p>';
				
				while($row = $results->fetch_object()){
					$records[] = $row;
				}
					$results->free();
			} 
		 if (!count($records)){
			 echo'No items in the db';
		 }else{
		 ?>
<table>
	<tr>
		<th>Item ID</th>
		<th>Item</th>
		<th>Price (KSh)</th>
		<th>Instock</th>
		<th>Supplier</th>
	</tr>
	<?php 
		foreach($records as $r){
	?>
	<tr style="background:<?php if($r->instock<10&&!isOrdered($r->itemID)){echo 'red';}elseif(isOrdered($r->itemID)){echo 'yellow';}else{echo '#456488';} ?>;">
		<td><?php echo $r->itemID;?></td>
		<td><?php echo $r->item;?></td>
		<td class="number"><?php echo formatmoney($r->price, true);?></td>
		<td class="clickable" onclick = 'promptOrder(<?php echo '"'.$r->itemID.'","'.$r->item.'"';?>);'  align="center"><?php echo $r->instock;?></td>
		<td><?php echo @supplierField($r->supplierID, 'name');?></td>
	</tr></a>
	<?php 
		}
	?>
</table>
<hr>
<?php
 }
?>
