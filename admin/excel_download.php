<?php
include '../include/connectdb.php';

  $name_csv = "Orders_".strtotime("now").".csv";
  header('Content-type: application/csv; charset=UTF-8');
  header('Content-Disposition: attachment; filename='.$name_csv);
  $fp = fopen("php://output","w");

  $stack = array(
    array("Transactions"),
    array("Order List"),
    array("TXN : number","Customer","Status","Date Purchased","Payment")
    );

  $sql = mysql_query("SELECT * FROM transactions ORDER BY id DESC");
$productCount = mysql_num_rows($sql); // count the output amount
if ($productCount > 0) {
  while($row = mysql_fetch_array($sql)){ 
    $txn_id = $row["txn_id"];
    $firstname = $row["first_name"];
    $lastname = $row["last_name"];
    $datepayment = strftime("%b %d, %Y", strtotime($row["payment_date"]));
    $stat= $row["payment_status"];
    $gross = $row["mc_gross"];
    array_push($stack,
          array($txn_id, $firstname.' '. $lastname, $stat, $datepayment, $gross)
          );
  }
}
  

  foreach ($stack as $field) {
    fputcsv($fp, $field);
  }


?>