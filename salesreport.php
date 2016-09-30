<?php 
require 'db.php';
require 'functions.php';
$today = date("Y-m-d");
$query = "SELECT * FROM revenues WHERE date = '{$today}'";
$records = array();

if (isset($_GET['start'])&&isset($_GET['end'])){
   $start =  $_GET['start']; $end = $_GET['end'];
   $query = "SELECT * FROM revenues WHERE date BETWEEN '{$start}' AND '{$end}'";
}

if($results = $db->query($query)){
    if($results->num_rows){
        while($row = $results->fetch_object()){
            $records[] = $row;
        }
        $results->free();
    }
    
    if(!count($records)){
        echo'There are no matching sales for this date!';
    }else{
        ?>
<table>
    <tr>
        <th>Sales ID</th>
        <th>Cashier</th>
        <th>Price</th>
        <th>Timestamp</th> 
    </tr>
    <?php 
        $total = 0;
        foreach($records as $r){
            $total +=$r->price;
    ?>
    <tr>
        <td><?php echo $r->receiptNO; ?></td>
        <td><?php echo $r->cashier; ?></td>
        <td align="right"><?php echo formatMoney($r->price,true); ?></td>
        <td><?php echo $r->time." ".$r->date; ?></td>
    </tr>
    <?php } ?>
    <tr>
        <td colspan="2" align="right">Total</td>
        <td align="right"><b><u><?php echo formatMoney($total, true); ?></u></b></td>
    </tr>
</table>
<?php
    }
    
}else{
    echo $db->error;
}
?>