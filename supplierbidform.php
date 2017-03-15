<?php
		include 'include/check_login.php';
	  	include 'include/connectdb.php';
		$userid="";
			if (loggedin())
			{
				$query = mysql_query("SELECT * FROM users WHERE usn='$_SESSION[username]' ");
					while ($row = mysql_fetch_assoc($query))
					{
						$userid = $row ['id'];
						$usn = $row ['usn'];
						$fname = $row ['fname'];
					
					}
				
				}
			else
			{	
			//header("Location:login.php");
		//	exit();
			}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">

	<title>Bid Portal</title>


</head>
<body>

	<?php include 'template/top.php'; ?>

    <?php include 'template/header.php'; ?>
	
		<form action="supplierbid.php" method="post" enctype="multipart/form-data" style="margin-top: 69px;">
		<fieldset>
			 <div class="row cells2">
			 	<div class="cell">
		
					<h4>Supplier Bid Portal</h4>
					 <hr class="bg-magenta">
					 		 <br/>
					
					<div class="form-group">
						<div class="input-control">
							<label for="product-name">Product Name:</label>
							<input type="text" id="product-name" required="required" class="input-control" name="name">
						</div>
					</div>
					<br/>
					<div class="form-group">
						<div class="input-control">
							<label for="details">Details:</label>
							<input type="text" id="details" required="required" class="input-control" name="details">
						</div>
					</div>
					<br/>
					<div class="form-group">
						<div class="input-control">
							<label for="price">Price:</label>
							<input type="text" id="price" required="required" class="input-control" name="price">
						</div>
					</div>
					<br/>
					<div class="form-group">
						<div class="input-control">
							<label for="product-name">Attachment (.PDF, .DOC):</label>
							<input type="file" id="file" name="file" class="input-control" required="required" multiple />
						</div>
					</div>
					<br/>
					<div class="form-group">
						<input type="submit" name="submit" class="button" value="Submit">
					</div>

					
				</div>
			</div>
		</fieldset>
		</form>

		<script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>

	
</body>
</html>