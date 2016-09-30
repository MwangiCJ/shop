<?php
session_start();

require 'db.php';
require 'functions.php';
if(!loggedin()){
	header('Location: login.php');
}

if(isset($_GET['itemID'])&&isset($_GET['qty'])){
	$itemID = $_GET['itemID'];
	$qty = $_GET['qty'];
	if($qty>=1){
		$query = "SELECT * FROM inventory WHERE itemID = ".$itemID." ";

		$results = $db->query($query)or die($db->error);
		$row = $results->fetch_object();

		$item = $row->item;
		$quantity = $qty;
		$supplierID = $row->supplierID;
		if(insertIntoOrders($itemID,$item,$quantity,$supplierID)){
			echo unsentOrders();
		}
	}
	
}
?>















