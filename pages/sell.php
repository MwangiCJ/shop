<!DOCTYPE html>
<html>
	<head>
		<title>Sell</title>
		<script src="js/functions.js"></script>
	</head>
	<body onload="addToList();">	
		<br>	
		<form name = "sellItemForm" method = "post" action = "">
			Item:<input type = "search" onkeyup = "searchItems();" name = "searchText" placeholder="Search by name or code"/>
			<div id="autoList"></div>
			<div id = "itemDiv">
			<br>
				<table>
					<tr>
						<td>Item ID</td>
						<td>Item</td>
						<td>Price</td>
						<td>Qty</td>
						
						<td></td>
					</tr>
					<tr>
						<td><span id="itemID"></span></td>
						<td><span id = "selectedItem"></span></td>
						<td><span id = "itemPrice"></span></td>
						<td><input name = "qty" type="number" min="1" value="1"></td>
						<td><button type="button" onclick="addToList();">Add</button></td>
					</tr>
				</table>
			</div>
			<hr>
		</form>
		<div id="shoppingList"></div>
	</body>
</html>