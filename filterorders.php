<?php
session_start();
require 'db.php';
require 'functions.php';

if(isset($_GET['oid'])&&isset($_GET['action'])){
	$orderID = $db->real_escape_string($_GET['oid']);
	$action = $db->real_escape_string($_GET['action']);
	switch($action){
		case 'remove':
		$sql = "DELETE FROM orders WHERE orderID = {$orderID}";
		break;
		case 'deliver':
		$sql = "UPDATE orders SET status ='delivered' WHERE orderID = {$orderID}";
		$orderQty = orderField($orderID, 'quantity');
		$itemID = orderField($orderID, 'itemID');
		$instock = inventoryField($itemID, 'instock');
		$new = $instock + $orderQty;
		$db->query("
			UPDATE inventory SET instock = {$new} WHERE itemID = {$itemID}")or die($db->error);
		break;
	}
	$db->query($sql);
}
	$records = array();
		
	$query = "SELECT * FROM orders WHERE status = 'notsent' ORDER BY supplierID ";

	if(isset($_GET['filter'])&&isset($_GET['sid'])){
		$filter = $db->real_escape_string($_GET['filter']);
		$sid = $db->real_escape_string($_GET['sid']);
		$query = "SELECT * FROM orders WHERE status = '{$filter}' AND supplierID = '{$sid}'";
		if($sid==0){
			$query = "SELECT * FROM orders WHERE status = '{$filter}'";
		}
	}
	
	$results = $db->query($query);
	while($row = $results->fetch_object()){
		$records[] = $row;
	}
	$results->free();
	if(count($records)){		
	
		?>
		<table id ="sendResponse" style="margin:1em 0 1em 0;"cellpadding="2" border="1">
			<tr>
				<th>Item ID</th>
				<th>Item</th>
				<th>QTY</th>
				<th>Supplier</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		<?php
		foreach($records as $r){
			?>
			<tr>
				<td><?php echo $r->itemID; ?></td>
				<td><?php echo $r->item; ?></td>
				<td><?php echo $r->quantity; ?></td>
				<td><?php echo supplierField($r->supplierID,"name"); ?></td>
				<td><?php echo $r->status; ?></td>
				<td><?php if($r->status=='notsent'){
					echo '<a href="#" onclick="removeThis('.$r->orderID.');">Remove</a>';
				}elseif($r->status=='pending'){
					echo '<a href="#" onclick="deliverThis('.$r->orderID.');">Delivered</a>';
				} ?></td>
			</tr>
			<?php
		}?>
		</table>
		<?php 
		if(@$filter=='notsent' AND @$sid!=0){
			?>
				<a href="#" class="btn btn-warning" onclick="sendOrder(<?php echo $_GET['sid']; ?>);" >Submit Order</a>
			<?php
	
		}
	}else{
		echo"<p style=\"color:blue;\">No orders matching the search criteria!</p>";
	}
?>