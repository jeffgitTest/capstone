<?php 

	include 'include/check_login.php';
	include 'include/connectdb.php';
	include 'include/bid.php';

	$authorid =  $_SESSION['author_id'];

	$title = $_POST['name'];
	$details = $_POST['details'];
	$author = $_POST['author'];
	$genre = $_POST['genre'];
	$price = $_POST['price'];

	$file_name = $_FILES['file']['name'];
	$file_size = $_FILES['file']['size'];
	$file_temp = $_FILES['file']['tmp_name'];

	$allowed_ext = array ('pdf', 'doc');
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $file_id = 0;

	$bidid = 0;

	$sql = mysql_query("INSERT INTO author_bid (title, details, co_author, author_id, genre, projected_price) VALUES ('$title', '$details', '', '$authorid', '$genre', '$price')") or die('Error author_bid');

	$file_id = mysql_insert_id();
	$file = $file_name . '.' . $file_ext;
	move_uploaded_file($file_temp, 'bids/' . $file);

	$sql = mysql_query("INSERT INTO uploaded_bid_file (author_id, file_name, ext) VALUES ('$authorid', '$file_name', '$file_ext')");

	$sql = mysql_query("SELECT * FROM author_bid ORDER BY id DESC LIMIT 1") or die('Error author_bid');
	$requestCount = mysql_num_rows($sql);

	if ($requestCount > 0) {
		while ($row = mysql_fetch_array($sql)) {
			
			$bidid = $row['id'];

		}
	}

	insert_bid($bidid, 'author');


 ?>