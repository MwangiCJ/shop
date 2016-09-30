<?php
require 'db.php';
require 'functions.php';

if(isset($_GET['s'])){
	$searchText = $db->real_escape_string(trim($_GET['s']));
	if(!empty($searchText)){
		$query = "SELECT * FROM inventory WHERE itemID LIKE '%{$searchText}%' OR item LIKE '%{$searchText}%' LIMIT 10";

	$results = $db->query($query)or die($db->error);

	if($count = $results->num_rows){
		//loop throug results and dispaly items
		while($row = $results->fetch_object()){
			$price = formatMoney($row->price, true);
			echo '<a href="#" onclick= "pickThis(\'',$row->itemID,'\',\'',$row->item,'\', \'',$price,'\');">',$row->itemID,' ', $row->item, ' ', $price, '</a> <br> ';		
			}
				$results->free();
		}else{
			echo'No result found!';
		}
	}
}
?>