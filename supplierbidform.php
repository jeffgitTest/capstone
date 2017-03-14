<form action="supplierbid.php" method="post" enctype="multipart/form-data">
	
	Product Name: <input type="text" name="name"> <br>
	Details: <input type="text" name="details"> <br>
	Price: <input type="text" name="price"> <br>

	Attachment: <input type="file" name="file" required="required" multiple /> <br>

	<input type="submit" name="submit" value="Submit">
	<input type="submit" name="cancel" value="Cancel">

</form>

<script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>