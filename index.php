<?php 
session_start();
require 'db.php';
require 'functions.php';
if(!loggedin()){
	header('Location: login.php');
}else{
	?>
<!DOCTYPE html>
<html>
	<head>
		<script src="js/functions.js"></script>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/custom.css" rel="stylesheet">
	</head>
	<body>	
		<div class="row">
			<div class="col-sm-2 rightPane">
				<ul>
					<li>
				<a class="btn btn-info btn-block" href="../shop/?p=inventory">Inventory (<span id="lessItems" style="color:red;"><?php echo lessItems(); ?></span>)</a>
					</li>
					<li>
				<a class="btn btn-info btn-block" href="../shop/?p=orders">Orders (<span id="orders" style="color:red;"><?php echo unsentOrders(); ?></span>) </a>
				</li>
					<li>
				<a class="btn btn-info btn-block" href="../shop/?p=sales">Sales</a>
				</li>
					<li>
				<a class="btn btn-info btn-block" href="../shop/?p=suppliers">Suppliers</a>
				</li>
					<li>
				<a class="btn btn-info btn-block" href="../shop/?p=sell">Sell</a>
				</li>
					<li>
				<a class="btn btn-info btn-block" href="../shop/logout.php">Logout</a> 
					</li>
				</ul>
			</div>
			<div class="col-sm-10 workArea">
				<?php
					if (isset($_GET['p'])){
						$p = $_GET['p'];
						switch ($p){
							case 'inventory':
								require 'pages/inventory.php';
							break;
							case 'sell':
								require 'pages/sell.php';
							break;
							case 'orders':
								require 'pages/orders.php';
							break;
							case 'suppliers':
								require 'pages/suppliers.php';
							break;
							case 'sales':
								require 'pages/sales.php';
							break;
							default:
								echo'The requested page <u><strong>',$p,'</strong></u> was not found!';
							break;
						}
					}else{
						echo "<h1 class='text-center'>John Tek Shop</h1>";
					}
				}
				?>
			</div>
		</div>
	</body>
	
</html>
