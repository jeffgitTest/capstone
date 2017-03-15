<?php
include '../include/connectdb.php';





?>


<table>
  <thead>
    <th>Name</th>
    <th>Product</th>
    <th>Details</th>
    <th>Price</th>
    <th>Proposal file name</th>
    <th>Date</th>
  </thead>

  <?php

  $sql = mysql_query("SELECT supplier_bid.*, supplier.*, uploaded_supp_bid_file.* from supplier_bid inner join supplier on supplier_bid.supplier_id=supplier.id inner join 
uploaded_supp_bid_file on supplier.id=uploaded_supp_bid_file.supplier_id");
  $requestCount = mysql_num_rows($sql);

  if ($requestCount > 0) {
     while ($row = mysql_fetch_array($sql)) {

      $id = $row['id']; 
      $name = $row['name'];
      $product = $row['product_bid'];
      $detail = $row['details'];
      $price = $row['price'];
      $filename = $row['file_name'];
      $date = $row['created_date'];
      

      echo "
        <tr>
          <td>$name</td>
          <td>$product</td>
          <td>$detail</td>
          <td>$price</td>
          <td>$filename</td>
          <td>$date</td>
        </tr>

      ";


     }
  }

   ?>


</table>