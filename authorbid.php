<?php 

	include 'include/check_login.php';
	include 'include/connectdb.php';
	include 'include/bid.php';

	$authorid =  $_SESSION['author_id'];

	$title = $_POST['name'];
	$details = $_POST['details'];
	$author = $_POST['author'];
	$genre = $_POST['genre'];

	$bidid = 0;

	$sql = mysql_query("INSERT INTO author_bid (title, details, co_author, author_id, genre) VALUES ('$title', '$details', '', '$authorid', '$genre')") or die('Error author_bid');

	$sql = mysql_query("SELECT * FROM author_bid ORDER BY id DESC LIMIT 1") or die('Error author_bid');
	$requestCount = mysql_num_rows($sql);

	if ($requestCount > 0) {
		while ($row = mysql_fetch_array($sql)) {
			
			$bidid = $row['id'];

		}
	}

	insert_bid($bidid, 'author');


 ?>