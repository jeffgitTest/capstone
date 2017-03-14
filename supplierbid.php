<?php 

	include 'include/check_login.php';
	include 'include/connectdb.php';
	include 'include/bid.php';

	$supplierid =  $_SESSION['supplier_id'];

	$name = $_POST['name'];
	$details = $_POST['details'];
	$price = $_POST['price'];

	$file_name = $_FILES['file']['name'];
	$file_size = $_FILES['file']['size'];
	$file_temp = $_FILES['file']['tmp_name'];

	$allowed_ext = array ('pdf', 'doc');
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $file_id = 0;

	$bidid = 0;

	$sql = mysql_query("INSERT INTO supplier_bid (supplier_id, product_bid, details, price) VALUES ('$supplierid', '$name', '$details', '$price')");

	$file_id = mysql_insert_id();
	$file = $file_name . '.' . $file_ext;
	move_uploaded_file($file_temp, 'bids/' . $file);

	$sql = mysql_query("INSERT INTO uploaded_supp_bid_file (supplier_id, file_name, ext) VALUES ('$supplierid', '$file_name', '$file_ext')");

	$sql = mysql_query("SELECT * FROM supplier_bid ORDER BY id DESC LIMIT 1") or die('Error supplier_bid');
	$requestCount = mysql_num_rows($sql);

	if ($requestCount > 0) {
		while ($row = mysql_fetch_array($sql)) {
			
			$bidid = $row['id'];

		}
	}

	insert_bid($bidid, 'supplier');


 ?>