<form action="authorbid.php" method="post" enctype="multipart/form-data">
	
	Title: <input type="text" name="name"> <br>
	Details: <input type="text" name="details"> <br>

	Attachment: <input type="file" name="file" required="required" multiple /> <br>

	Author: <input type="text" name="author"> <br>
	Genre: <input type="text" name="genre"> <br>
	Projected Price: <input type="text" name="price"> <br>

	<input type="submit" name="submit" value="Submit">
	<input type="submit" name="cancel" value="Cancel">

</form>

<script type="text/javascript" src="js/jquery-2.1.3.min.js"></script>