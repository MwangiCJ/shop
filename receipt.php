<?php
session_start();
require 'db.php';
require 'functions.php';
if(!loggedin()){
	header('Location: login.php');
}

if(isset($_GET['receiptNO'])){
	$receipt = $db->real_escape_string($_GET['receiptNO']);
	$query = "SELECT * FROM sales WHERE receiptNO = {$receipt}";
	$results = $db->query($query);
	$records = array();
	if($count = $results->num_rows){
		while($row = $results->fetch_object()){
				$records[] = $row;
			}
		$results->free();
	}
	
	if(!count($records)){
		echo 'No items found for the receipt number!';
	}else{
		?>
		<div id="saleReceipt">
			<table style="border:1px solid black;" cellpadding="2">
				<tr>
					<td align="center" colspan="5">JONTEK SHOP<br>002 Workshop RD off Haileselasie Avenue<br>0724 384 488</td>
				</tr>
				<tr>
					<td colspan="2">
						Sale Receipt<br>
						Receipt NO: <?php echo $receipt; ?>
						
						<td colspan="3"align="right">Sale Date <?php echo saleField($receipt, 'date')."<br>".saleField($receipt, 'time');  ?></td>
					</td>				
				</tr>
				<tr>
					<th>ID</th>
					<th>ITEM</th>
					<th>QTY</th>
					<th>PRICE</th>
					<th>SUBTOTAL</th>
				</tr>
				<?php 
				$sum=0;
					foreach($records as $r){
						$sum += ($r-> quantity) * ($r-> price);
				?>
				<tr>
					<td><?php echo $r->itemID;?></td>
					<td><?php echo $r->item;?></td>
					<td align="center"><?php echo $r->quantity;?></td>
					<td align="right"><?php echo formatmoney($r->price, false);?></td>
					<td align="right"><?php echo formatmoney($r->subtotal, false);?></td>
				</tr>
					<?php } ?>
					<tr>
						<td align="right" colspan="4">Sum total</td>
						<td align="right"><?php echo formatmoney($sum, false); ?></td>
					</tr>
					<tr>
						<td align="right" colspan="4">Paid</td>
						<td align="right"><?php echo formatmoney(saleField($receipt, 'paid'), false); ?></td>
					</tr>
					<tr>
						<td align="right" colspan="4">Change</td>
						<td align="right"><?php echo formatmoney(saleField($receipt, 'paid') - $sum, false); ?></td>
					</tr>
					<tr>
						<td align="center" colspan="5">Prices Inclusive of Taxes Where Applicable</td>
					</tr>
					<tr>
						<td align="center" colspan="5">You were served by <?php echo saleField($receipt, 'cashier'); ?>
						<br><em>Thank you for shopping with us.</em>
						<hr>
						<br><br>
						<small>MwangiCJ.com</small></td>
					</tr>
			</table>
		</div>
		<br>
		<button type="button" onclick="printReceipt();">Print</button>
		<?php
	}
}
?>














