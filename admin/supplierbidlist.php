<?php
include '../include/connectdb.php';
  include 'include/check_login.php';
if (!isset($_SESSION["manager"])) {
    header("location: login.php"); 
    exit();
  
  
  
}?>

<?php
    
    $username="";
      if (loggedin())
      {
        $query = mysql_query("SELECT * FROM admin WHERE username ='$_SESSION[manager]' ");
          while ($row = mysql_fetch_assoc($query))
          {
            $userid = $row ['id'];
            $username = $row ['username'];
            
          
          }
        
        }
      else
      { 
      //header("Location:login.php");
    //  exit();
      }
      ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Administrator</title>

    <link href="css/bootstrap.css" rel="stylesheet">

    <link href="css/sb-admin.css" rel="stylesheet">-->

    <link rel="stylesheet" href="css/morris-0.4.3.min.css">
  </head>

  <body>

    <div id="wrapper">
  <!-- Sidebar -->
      <nav class="navbar navbar-inverse  navbar-fixed-top" role="navigation">
      <?php include 'template/sidebar.php';?>
    <?php include 'template/top.php';?>
    </nav>

    <div class="table-responsive">
      <table class="table table-striped">
        <thead>
    <th>Name</th>
    <th>Product</th>
    <th>Details</th>
    <th>Price</th>
    <th>Proposal file name</th>
    <th>Date</th>
  </thead>

  <?php

  $sql = mysql_query("SELECT supplier_bid.*, users.*, uploaded_supp_bid_file.* from supplier_bid inner join users on supplier_bid.supplier_id=users.id inner join 
uploaded_supp_bid_file on users.id=uploaded_supp_bid_file.supplier_id where users.user_type=3");
  $requestCount = mysql_num_rows($sql);

  if ($requestCount > 0) {
     while ($row = mysql_fetch_array($sql)) {

      $id = $row['id']; 
      $fname = $row['fname'];
      $lname = $row['lname'];
      $product = $row['product_bid'];
      $detail = $row['details'];
      $price = $row['price'];
      $filename = $row['file_name'];
      $date = $row['created_date'];
      

      echo "
        <tr>
          <td>$fname $lname</td>
          <td>$product</td>
          <td>$detail</td>
          <td>".number_format($price, 2, '.', ',')."</td>
          <td>$filename</td>
          <td>$date</td>
        </tr>

      ";


     }
  }

   ?>

      </table>
    </div>

    </div>
    </body>
    </html>
