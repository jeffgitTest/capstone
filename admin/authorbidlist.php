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
    <th>Author</th>
    <th>Co-author</th>
    <th>Title</th>
    <th>Details</th>
    <th>Genre</th>
    <th>Price</th>
    <th>Proposal file name</th>
    <th>Date</th>
    <th>Action</th>
    <th>Status</th>
  </thead>

  <?php

  $sql = mysql_query("SELECT author_bid . * , users . * , uploaded_bid_file . * 
FROM author_bid
INNER JOIN users ON author_bid.author_id = users.id
INNER JOIN uploaded_bid_file ON users.id = uploaded_bid_file.author_id
WHERE users.user_type =2");
  $requestCount = mysql_num_rows($sql);

  if ($requestCount > 0) {
     while ($row = mysql_fetch_array($sql)) {

      $id = $row['id']; 
      $fname = $row['fname'];
      $lname = $row['lname'];
      $coauthor = $row['co_author'];
      $title = $row['title'];
      $details = $row['details'];
      $genre = $row['genre'];
      $price = $row['projected_price'];
      $filename = $row['file_name'];
      $date = $row['created_date'];
      $status = ($row['status'] == '0' ? 'Pending' : 'Completed');
      

      echo "
        <tr>
          <td>$fname $lname</td>
          <td>$coauthor</td>
          <td>$title</td>
          <td>$details</td>
          <td>$genre</td>
          <td>$price</td>
          <td><a href='viewuploadedbid.php?filename=$filename'>$filename</a></td>
          <td>$date</td>
          <td>$status</td>
          <td><a href=''>Accept</a> | <a href=''>Decline</a></td>
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


