<?php
require 'db.php';
require 'functions.php';
if(isset($_GET['sid'])){
	$supplierID = $db->real_escape_string($_GET['sid']);
	$email = supplierField($supplierID, "email");
	$name = supplierField($supplierID, "name");
	
	$query = "SELECT * FROM orders WHERE status = 'notsent'
	AND supplierID = {$supplierID} ";
	
	$update = "UPDATE orders SET status = 'pending' WHERE 
	supplierID = {$supplierID} AND status='notsent'";
	
	$records = array();
	if($results= $db->query($query)or die($db->error)){
		while($row = $results->fetch_object()){
		$records[] = $row;
	}
	$results->free();
	if(count($records)){
		$items=array();
		foreach($records as $r){
			$items[]= $r->quantity." ".$r->item.",
			";
		}
		$i = 0;
		$list = "";
		$top = "JONTEK SHOP
		002 Workshop RD off Haileselasie Avenue
				0724 384 488
				";
		 $salutation = "Dear ".$name." 
		 please deliver the following items to our shop.
		 ";
		while($i<count($items)){
			$list .= $items[$i];
			$i++;
		}
			$body = $top.$salutation.$list;
			$subject='Order';
			$from = 'noreply@johntekshop.com';
			$headers = 'From: ' . strip_tags($from);
			//$headers .= "Reply-To: ". strip_tags($from) . "\r\n";
			//$headers .= "MIME-Version: 1.0\r\n";
			//$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			if(mail($email,$subject,$body,$headers)){
				$db->query($update);
				echo 'Order sent to '.$name;
			}
		}

	}	
}

?>