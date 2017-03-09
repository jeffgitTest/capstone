<?php 

	include "../include/connectdb.php";

	if (isset($_POST['submit'])) {
		
		$name = $_POST['name'];
		$amount = $_POST['amount'];

		$query = mysql_query("INSERT INTO expenses (name, amount) VALUES ('$name', '$amount')");

		if ($query) {
			echo "Successfully added!";
		} else {
			echo "Error!";
		}

	}

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

 <br>

 Add expense <br>
 <form action="expenses.php" method="post">
 	
	Name: <input type="text" name="name" > <br>
 	Amount <input type="text" name="amount"> <br>
	<input type="submit" name="submit">

 </form>