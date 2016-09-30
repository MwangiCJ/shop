<!DOCTYPE html>
<html>
	<head>
		<title>Sales report</title>
		<style>
			th,td{border:1px solid black; }
			td.number{text-align:right;}
			tr:hover{cursor:pointer;}
		</style>
		<script src="js/functions.js"></script>
	</head>
	<body onload="getSalesReport();">
		<br>
                    <form name="dateFilter">
                            From <input type="date" name="start"> 
                            To <input type="date" name="end"> 
                            <button type="button" onclick="updateSales();">Search</button>
                    <form>                         
		<hr>
                <h2>Showing sales report <span id="period">for today</span></h2>
		<div id="salesList"></div>
	</body>
	
</html>