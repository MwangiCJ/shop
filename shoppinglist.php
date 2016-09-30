<?php
session_start();

require 'db.php';
require 'functions.php';
if(!loggedin()){
	header('Location: login.php');
}

class Item{
	var $itemID;
	var $item;
	var $price;
	var $quantity;
}

if(isset($_GET['itemID'])&&isset($_GET['qty'])){
	$itemID = $_GET['itemID'];
	$qty = $_GET['qty'];

		$query = "SELECT * FROM inventory WHERE itemID = ".$itemID." ";

		$results = $db->query($query)or die($db->error);
		$row = $results->fetch_object();
		
		$item = new Item();
		$item->itemID = $itemID;
		$item->item = $row->item;
		$item->price = $row->price;
		$item->quantity = $qty;
		
		$_SESSION['list'][] = $item;		
}

//Remove items from list
if(isset($_GET['action'])&&isset($_GET['index'])){
	if($_GET['action']=='remove'){
		$index = $_GET['index'];
		if($index=='all'){
			unset($_SESSION['list']);
		}else{
			unset($_SESSION['list'][$index]);
		}
	}
}
//Check out
if(isset($_GET['action'])&&isset($_GET['paid'])){
	if($_GET['action']=='checkout'){
		@$list = unserialize(serialize($_SESSION['list']));
		$x=0;
		$sum = 0;
		$paid = $_GET['paid'];
		$receiptNO = lastReceiptNumber()+1;
		while($x<count($list)){
			$itemID = $list[$x]-> itemID;
			$item = $list[$x]-> item;
			$quantity = $list[$x]-> quantity;
			$price =$list[$x]-> price;
			$subtotal = $quantity * $price;
			$newValue = currentValue($itemID) - $quantity;
			$db->query("INSERT INTO sales (itemID, item, quantity, price, subtotal, receiptNO)
			VALUES ({$itemID}, '{$item}', '{$quantity}', {$price}, {$subtotal}, {$receiptNO}) ");
			$db->query("UPDATE inventory SET instock = {$newValue} WHERE itemID = {$itemID}");
			$sum += $subtotal;
			$x++;
		}
		//$cashier = $_SESSION['cahier']['id'];
		$cashier = userField('username');
		$time = date("H:i:s");
		$date = date("Y-m-d");
		$db->query("INSERT INTO revenues (receiptNO, cashier, price, paid, time, date)
			VALUES ({$receiptNO}, '{$cashier}', {$sum}, {$paid}, '{$time}', '{$date}' )")or die($db->error);
		unset($_SESSION['list']);
		header('Location: receipt.php?receiptNO='.$receiptNO);
	}	
}
?>

<table cellpadding="2" border="1">
	<tr>
		<td>Item ID</td>
		<td>Item Name</td>
		<td>Price</td>
		<td>Quantity</td>
		<td>Sub Total</td>
		<td>Action</td>
	</tr>
	<?php
		@$list = unserialize(serialize($_SESSION['list']));
		$sum = 0;
		  $x = 0;
		while($x<count($list)){
			$sum += ($list[$x]-> quantity) * ($list[$x]-> price);
	?>
	<tr>
		<td><?php echo $list[$x]-> itemID; ?></td>
		<td><?php echo $list[$x]-> item; ?></td>
		<td><?php echo formatmoney($list[$x]-> price, true); ?></td>
		<td align="center"><?php echo $list[$x]-> quantity; ?></td>
		<td><?php echo formatmoney(($list[$x]-> quantity) * ($list[$x]-> price), true); ?></td>
		<td><button type="button" onclick = "deleteEntry('<?php echo $x;?>');">Remove</button></td>
	<tr>
	<?php
	 $x++;
		}
	?>
	<tr>
		<td colspan="4" align="right">
			<span style="visibility:hidden;" id="total"><?php echo $sum;?></span>
			Total
		</td>
		<td><?php echo formatmoney($sum, true);?></td>
		<td>
			<?php if(isset($_SESSION['list'])&&!empty($_SESSION['list'])){ ?>
				<button type="button" onclick = "deleteEntry('all');">Remove All</button>
			<?php } ?>
		</td>
	</tr>
	<?php if(isset($_SESSION['list'])&&!empty($_SESSION['list'])){
		?>
		<tr>
			<td colspan="6" align="center">
				<button type="button" onclick="checkOut();">Save</button>
			</td>
		</tr>
	<?php } ?>
</table>















