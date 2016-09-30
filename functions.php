<?php
function formatMoney($number, $fractional=false) {
	if ($fractional) {
		$number = sprintf('%.2f', $number);
	}
	while (true) {
		$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
		if ($replaced != $number) {
			$number = $replaced;
		} else {
			break;
		}
	}
	return $number;
}

function lastReceiptNumber(){
	include "db.php";
	$results = $db->query("SELECT * FROM sales ORDER BY saleID DESC LIMIT 0,1");
	if($count = $results->num_rows){
		while($row = $results->fetch_object()){
			return $row->receiptNO;
		}
	}else{
		return 0;
	}
}

function currentValue($itemID){
	include "db.php";
	$results = $db->query("SELECT * FROM inventory WHERE itemID = {$itemID}");
	if($count = $results->num_rows){
		while($row = $results->fetch_object()){
			return $row->instock;
		}
	}else{
		return 0;
	}
}

function supplierField($supplierID, $field){
	include "db.php";
	$results = $db->query("SELECT * FROM suppliers WHERE supplierID = {$supplierID}");
	if($count = $results->num_rows){
		while($row = $results->fetch_object()){
			return $row->$field;
		}
	}else{
		return "Unknown";
	}
}

function saleField($receiptNO, $field){
	include "db.php";
	$results = $db->query("SELECT * FROM revenues WHERE receiptNO = {$receiptNO}");
	if($count = $results->num_rows){
		while($row = $results->fetch_object()){
			return $row->$field;
		}
	}else{
		return "Unknown";
	}
}
function inventoryField($itemID, $field){
	include "db.php";
	$results = $db->query("SELECT * FROM inventory WHERE itemID = {$itemID}");
	if($count = $results->num_rows){
		while($row = $results->fetch_object()){
			return $row->$field;
		}
	}
}
function orderField($orderID, $field){
	include "db.php";
	$results = $db->query("SELECT * FROM orders WHERE orderID = {$orderID}");
	if($count = $results->num_rows){
		while($row = $results->fetch_object()){
			return $row->$field;
		}
	}
}
//authorize access
function loggedin(){
	if(isset($_SESSION['user'])&&!empty($_SESSION['user'])){
		return true;
	}else{
		return false;
	}
}
//user field
function userField($field){
	require 'db.php';
	if(loggedin()){
		$results = $db->query("SELECT * FROM users WHERE id = {$_SESSION['user']}");
		if($count = $results->num_rows){
			while($row = $results->fetch_object()){
				return $row->$field;
			}
		}else{
			return "Unknown";
		}	
	}
}
//Insert order row
function insertIntoOrders($itemID,$item,$quantity,$supplierID){
	require "db.php";
	$query = "INSERT INTO orders (itemID, item, quantity, supplierID, status)
	VALUES({$itemID},'{$item}', {$quantity}, {$supplierID},'notsent')";
	if($db->query($query)){
		return true;
	}
}
//Check Unsent orders
function unsentOrders(){
	require "db.php";
	$query = "SELECT orderID FROM orders WHERE status='notsent'";
	$results = $db->query($query);
	return($results->num_rows);
}

function lessItems(){
	require "db.php";
	$query = "SELECT itemID FROM inventory WHERE instock<10";
	$results = $db->query($query);
	return($results->num_rows);
}
//check if there is pending order for this item
function isOrdered($itemID){
	require "db.php";
	$query = "SELECT * FROM orders WHERE itemID = {$itemID} AND status = 'pending'";
	$results = $db->query($query);
	if($results->num_rows){
		return true;
	}else{
		return false;
	}
}

function queryOrders($field, $value){
	require "db.php";
	$query = "SELECT * FROM orders WHERE $field = {$value}";
	$results = $db->query($query);
	return $results;
}
//get suppliers as drop down
function suppliersDropDown(){
	require "db.php";
	$results = $db->query("SELECT * FROM suppliers")/*or die($db->error)*/;
	if($count = $results->num_rows){							
		while($row = $results->fetch_object()){
			?>
			<option value = "<?php echo $row->supplierID; ?>"> <?php echo $row->name;?></option>
			<?php
		}
			$results->free();
	}
}
?>