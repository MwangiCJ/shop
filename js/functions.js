//Show items on search area
function searchItems(){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("autoList").innerHTML = xmlhttp.responseText;
		}
	}
	st  = document.sellItemForm.searchText.value;
	xmlhttp.open('GET', 'search.php?s='+st,true);
	xmlhttp.send();
}

//Load selected item to bay -> to set quantity
function pickThis(itemID, item, price){
	document.getElementById("itemID").innerHTML = itemID;
	document.getElementById("selectedItem").innerHTML = item;
	document.getElementById("itemPrice").innerHTML = price;
	document.getElementById("autoList").innerHTML = "";
	document.sellItemForm.searchText.value = "";
}
//add selected item and selected quantity to the list
function addToList(){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("shoppingList").innerHTML = xmlhttp.responseText;
		}
	}
	
	id = document.getElementById("itemID").innerHTML;
	qty = document.sellItemForm.qty.value;
	
	if(id==""){
		//Just show the list
		xmlhttp.open('GET', 'shoppinglist.php',true);
	}else{
		//add item and refresh the list
		xmlhttp.open('GET', 'shoppinglist.php?itemID='+id+'&qty='+qty,true);
	}
	xmlhttp.send();
	//Clear loaded item 
	document.getElementById("itemID").innerHTML = "";
	document.sellItemForm.qty.value="1";
	document.getElementById("selectedItem").innerHTML = "";
	document.getElementById("itemPrice").innerHTML = "";
}
//remove selected item from list
function deleteEntry(index){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("shoppingList").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open('GET', 'shoppinglist.php?index='+index+'&action=remove',true);
	xmlhttp.send();
}
//Check out
function checkOut(){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("shoppingList").innerHTML = xmlhttp.responseText;
			printReceipt();
		}
	}
	totalAmount = document.getElementById("total").innerHTML;
	var paidAmount = prompt("Enter paid amount");
	if(totalAmount !=null){
		var balance = paidAmount - totalAmount;
		if(balance<0){
			alert('The customer must pay at least\nKsh '+totalAmount);
		}else{
			xmlhttp.open('GET', 'shoppinglist.php?action=checkout&paid='+paidAmount,true);
			xmlhttp.send();
		}
	}
}
//Prompt to place order
function promptOrder(itemID, item){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("orders").innerHTML = xmlhttp.responseText;
		}
	}
	var qty = prompt("How much of\n"+item+"\nWould you like to order?");
	if(qty!=null){
		xmlhttp.open('GET', 'orderlist.php?itemID='+itemID+'&qty='+qty,true);
		xmlhttp.send();
	}
}
//load orders in background
function loadOrders(){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("orderlist").innerHTML = xmlhttp.responseText;
		}
	}
	
	xmlhttp.open('GET', 'filterorders.php',true);
	xmlhttp.send();
}
//filter orders in background
function filterOrders(){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("orderlist").innerHTML = xmlhttp.responseText;
		}
	}
	st = document.searchOrders.st.value;
	filter = document.searchOrders.filter.value;
	xmlhttp.open('GET', 'filterorders.php?st='+st+'&filter='+filter,true);
	xmlhttp.send();
}
//On filter change
function newFilter(){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("orderlist").innerHTML = xmlhttp.responseText;
		}
	}
	flt = document.filterOrders.filter.value;
	supplierID = document.filterOrders.supplier.value;
	xmlhttp.open('GET', 'filterorders.php?filter='+flt+'&sid='+supplierID,true);
	xmlhttp.send();
}

function sendOrder(sid){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("sendResponse").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open('GET', 'sendorder.php?sid='+sid,true);
	xmlhttp.send();
}
//Remove order from order list
function removeThis(oid){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			newFilter();
		}
	}
	xmlhttp.open('GET', 'filterorders.php?oid='+oid+'&action=remove',true);
	xmlhttp.send();
}
//mark pending order as delivered
function deliverThis(oid){
	if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			newFilter();
		}
	}
	xmlhttp.open('GET', 'filterorders.php?oid='+oid+'&action=deliver',true);
	xmlhttp.send();
}

//load sales report
function getSalesReport(){
    if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("salesList").innerHTML = xmlhttp.responseText;
		}
	}
	xmlhttp.open('GET', 'salesreport.php',true);
	xmlhttp.send();
}

function updateSales(){
        sd = document.dateFilter.start.value;
        ed = document.dateFilter.end.value;
    if(window.XMLHttpRequest){
		xmlhttp = new XMLHttpRequest();
	}else{
		xmlhttp = new ActiveXObject('Microsoft.XMLHTTP');
	}
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200){
			document.getElementById("salesList").innerHTML = xmlhttp.responseText;
                        document.getElementById("period").innerHTML = "between "+ sd+" and "+ed ;
		}
	}
       
	if(sd === null || sd === "" || ed === null || ed === ""){
		return false;
	}else{
		xmlhttp.open('GET', 'salesreport.php?start='+sd+'&end='+ed,true);
		xmlhttp.send();
	}
}

//print sale receipt
function printReceipt(){
	var restorePage = document.body.innerHTML;
	var printable = document.getElementById("saleReceipt").innerHTML;
	document.body.innerHTML = printable;
	window.print();
	document.body.innerHTML = restorePage;
	
}












