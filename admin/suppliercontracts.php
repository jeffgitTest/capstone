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

      // from uploadcontract
      if (isset($_POST['submit'])) {
        
        $supplier_bid_id = $_POST['id'];
        $bids_id = $_POST['id2'];
        $uploaded_supp_bid_file_id = $_POST['id3'];
        $users_id = $_POST['id4'];

        $expiry = $_POST['expiry'];

        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $file_temp = $_FILES['file']['tmp_name'];

        $productname = "";
        $details = "";
        $price = "";

        $allowed_ext = array ('pdf', 'doc');
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        mysql_query("INSERT INTO contract (bid, user_id, type, validity) VALUES ('$bids_id', '$users_id', 'supplier', '$expiry')");

        mysql_query("UPDATE bids SET active=0 WHERE id=$bids_id");
        mysql_query("UPDATE uploaded_supp_bid_file SET active=0 WHERE bid_id=$bids_id");
        mysql_query("UPDATE supplier_bid SET status=1 WHERE bid_id=$bids_id");
        mysql_query("INSERT INTO uploaded_contract_file (contract_id, file_name, ext) VALUES ('$bids_id', ' $file_name', '$file_ext')");

        $sql = mysql_query("SELECT * FROM supplier_bid WHERE bid_id=$bids_id");
        $requestCount = mysql_num_rows($sql);

        if ($requestCount > 0) {
           while ($row = mysql_fetch_array($sql)) {

            $productname = $row['product_bid'];
            $details = $row['details'];
            $price = $row['price'];

           }
         }

         mysql_query("INSERT INTO supplies (bid_id, supplier_id, product_name, details, price, active) VALUES ('$bids_id', '$supplier_bid_id', '$productname', '$details' '$price', 1)");

        move_uploaded_file($file_temp, 'contracts/' . $file_name);

      }

      // decline bid
      $action = @$_GET['action'];

      if ($action == 'decline') {
        
        $supplier_bid_id = $_GET['id'];
        $bids_id = $_GET['id2'];
        $uploaded_supp_bid_file_id = $_GET['id3'];
        $users_id = $_GET['id4'];

        mysql_query("UPDATE bids SET active=0 WHERE id=$bids_id");
        mysql_query("UPDATE uploaded_supp_bid_file SET active=0 WHERE bid_id=$bids_id");
        mysql_query("UPDATE asupplier_bid SET status=-1 WHERE bid_id=$bids_id");

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
    <th>Supplier Name</th>
    <th>Product</th>
    <th>Validity</th>
    <th>Date</th>
    <th>Status</th>
    <th>Contract</th>
    <th>Action</th>
  </thead>

  <?php

  $sql = mysql_query("SELECT contract.id AS contract_id, contract.created_date AS contract_date, contract . * , users.id AS users_id, users . * , supplier_bid.id AS supplier_bid_id, supplier_bid . * 
FROM contract
INNER JOIN users ON contract.user_id = users.id
INNER JOIN supplier_bid ON contract.bid = supplier_bid.bid_id WHERE users.user_type=3");
  $requestCount = mysql_num_rows($sql);

  if ($requestCount > 0) {
     while ($row = mysql_fetch_array($sql)) {

      $contract_id = $row['contract_id'];
      $supplier_bid_id = $row['supplier_bid_id'];
      $users_id = $row['users_id'];

      $fname = $row['fname'];
      $lname = $row['lname'];
      $product = $row['product_bid'];
      $validity = $row['validity'];
      $date = $row['contract_date'];
      $status = ($row['active'] == '0' ? 'Inactive' : 'Active');
      

      echo "
        <tr>
          <td>$fname $lname</td>
          <td>$product</td>
          <td>$validity</td>
          <td>$date</td>
          <td>$status</td>
          
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
