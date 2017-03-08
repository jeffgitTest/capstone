<?php 

	include "../include/connectdb.php";

 ?>
List of expenses
 <table>
 	
	<thead>
		<th>Name</th>
		<th>Amount</th>
		<th>Date</th>
	</thead>

	<tbody>
		
		<?php 

		$sql = mysql_query("SELECT * FROM expenses");
		$requestCount = mysql_num_rows($sql);

		if ($requestCount > 0) {
		     while ($row = mysql_fetch_array($sql)) {

		     $id = $row['id'];

		     $name = $row['name'];
		     $amount = $row['amount'];
		     $date = $row['created_date'];

		      echo "
		        <tr>
		          <td>$name</td>
		          <td>$amount</td>
		          <td>$date </td>
		        </tr>

		      ";


		     }
		  }

	 ?>

	 <?php 

	 	$sql = mysql_query("SELECT sum(amount) FROM expenses");
		$requestCount = mysql_num_rows($sql);

		if ($requestCount > 0) {
		     while ($row = mysql_fetch_array($sql)) {

		     $totalamount = $row['sum(amount)'];

		      echo "
		        <tr>
		          <td><b>Total:</b></td>
		          <td>$totalamount</td>
		        </tr>

		      ";
		  }
		}

	  ?>

	</tbody>


 </table>