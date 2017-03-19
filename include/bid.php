<?php 

	include "connectdb.php";

	function insert_bid($id, $type) {

		$sql = mysql_query("INSERT INTO bids (bid_id, type) VALUES ('$id', '$type')");

		if (!$sql) {
			echo "Error bids table!";
		}

		return mysql_insert_id();

	}

 ?>