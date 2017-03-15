<?php
include '../include/connectdb.php';





?>


<table>
  <thead>
    <th>Author</th>
    <th>Co-author</th>
    <th>Title</th>
    <th>Details</th>
    <th>Genre</th>
    <th>Price</th>
    <th>Proposal file name</th>
    <th>Date</th>
  </thead>

  <?php

  $sql = mysql_query("SELECT author_bid.*, author.*, uploaded_bid_file.* from author_bid inner join author on author_bid.author_id=author.id inner join 
uploaded_bid_file on author.id=uploaded_bid_file.author_id");
  $requestCount = mysql_num_rows($sql);

  if ($requestCount > 0) {
     while ($row = mysql_fetch_array($sql)) {

      $id = $row['id']; 
      $author = $row['name'];
      $coauthor = $row['co_author'];
      $title = $row['title'];
      $details = $row['details'];
      $genre = $row['genre'];
      $price = $row['projected_price'];
      $filename = $row['file_name'];
      $date = $row['created_date'];
      

      echo "
        <tr>
          <td>$author</td>
          <td>$coauthor</td>
          <td>$title</td>
          <td>$details</td>
          <td>$genre</td>
          <td>$price</td>
          <td>$filename</td>
          <td>$date</td>
        </tr>

      ";


     }
  }

   ?>


</table>