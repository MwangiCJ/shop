<!DOCTYPE html>
<html>
	<head>
		<title>Orders</title>
		<script src="js/functions.js"></script>
	</head>
	<body onload = "loadOrders();">	
		<h3>Orders</h3>
		<form name="filterOrders" action="" method="get">
				Filter: <select name="filter" onchange="newFilter();">
				<option value="notsent">Unsent</option>
				<option value="pending">Pending</option>
				<option value="delivered">Delivered</option>
			</select>
			Supplier <select name="supplier" onchange="newFilter();">
				<option value="0">Select Supplier</option>
				<?php suppliersDropDown(); ?>
			</select>
		</form>
		<hr>	
		<div id="orderlist"></div>
	</body>
</html>