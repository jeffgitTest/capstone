<?php 
	//una
	include 'connectdb.php';
  if (
  		
		isset($_POST['register'])		
		)
{
	//Recaptcha Fields....
	require_once('recaptcha/recaptchalib.php');
	$privatekey = "6LdzmNkSAAAAAKPxU1H4IvJZBspyrQB4UyZ64sGS";
  	$resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);
	
	//Input Fields
	$usn = addslashes(strip_tags($_POST['usn']));
	$email = addslashes(strip_tags($_POST['email']));
	$password = strip_tags($_POST['password']);
	$repeat = strip_tags($_POST['repeat']);
	$fname = addslashes(strip_tags($_POST['fname']));
	$lname = addslashes(strip_tags($_POST['lname']));
	$day = $_POST['day'];
	$month = $_POST['month'];
	$year = $_POST['year'];
	$address1 = addslashes(strip_tags($_POST['address']));
	$contact = addslashes(strip_tags($_POST['contact']));
	$date = date ("Y-m-d");
	
	$errors = array();
	if($usn&&$email&&$password&&$repeat&&$fname&&$lname&&$month&&$day&&$year&&$address1&&$contact){
		//$birthday = date("Y-m-d", mktime(0,0,0,$year, $month, $day));
		$birthday = date($year.'-'.$month.'-'.$day);
		//check for existence
	    if ($password!=$repeat) ///check if pw match
		{
			$errors[] = '<div class="alert alert-error"><span class="icon-warning-sign"></span> Your passwords do not match!</div>';
		}
		//encrypt password
		$password = md5($password);
		//check if the email exists on database
		$check2 = mysql_query ("SELECT * FROM users WHERE email='$email'");
		if (mysql_num_rows($check2)>=1)
		{
			$errors[] = '<div class="alert alert-error"><span class="icon-warning-sign"></span> Email address already exists.</div>';
		}
		if(!preg_replace('#[^A-Za-z]#i', '',$fname))
		{
			$errors[] = '<div class="alert alert-error"><span class="icon-warning-sign"></span> The <strong>Firstname</strong> contains invalid characters</div>';
		}
		if(!preg_replace('#[^A-Za-z]#i', '',$lname))
		{
			$errors[] = '<div class="alert alert-error"><span class="icon-warning-sign"></span> The <strong>Lastname</strong> contains invalid characters</div>';
		}
		if(!preg_replace('#[^A-Za-z0-9]#i', '',$address1))
		{
			$errors[] = '<div class="alert alert-error"><span class="icon-warning-sign"> Invalid <strong>Address</strong></div>';
		}
		if($year >= 1995 && $year <= 2013)
		{
			$errors[] = '<div class="alert alert-error"><span class="icon-warning-sign">Below 18 years old are not allowed to register</strong></div>';
		}
	/*if (!$resp->is_valid){
   		$errors[] = "<div class='alert alert-error'>The reCAPTCHA wasn't entered correctly!!</div>";
 	 }*/
		if (!empty($errors)) 
			{
				foreach ($errors as $error2) 
					{
						echo $error2;
					}
			}
		else
			{
				// Your code here to handle a successful verification
				//generate random code
				$code = rand (11111111,99999999);
				//send activation email
				error_reporting(E_STRICT);
				date_default_timezone_set('America/Toronto');
				require_once('class.phpmailer.php');
				include("class.smtp.php");

				$queryprod=mysql_query("SELECT * FROM payment_option WHERE active='1' LIMIT 1");
							while($row=mysql_fetch_array($queryprod))
							{
								$id=$row['id'];
								$base_url=$row['base_url'];
							}
									
									$mail  = new PHPMailer();
									$body = 'Hello '.$username.', <br/> <br/> Thank you for your registration, Please Verify your account.Just Click the Link below <br/> <a href="'.$base_url.'include/activate.php?code='.$code.'">'.$base_url.'include/activate.php?code='.$code.'</a><br/><br/>Thank You <br/><br/>Mutya';

									$mail->IsSMTP(); // telling the class to use SMTP
									$mail->Host       = "smtp.gmail.com"; // SMTP server
									$mail->SMTPDebug  = 1;                     // enables SMTP debug information (for testing)
                                           
									// 1 = errors and messages
                                           
									// 2 = messages only


									$mail->SMTPAuth   = true;                  // enable SMTP authentication

									$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier

									$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server

									$mail->Port       = 465;                   // set the SMTP port for the GMAIL server

									$mail->Username   = "essentialitas@gmail.com";  // GMAIL username

									$mail->Password   = "slvmimtrvpnspeqm";            // GMAIL password


									$mail->SetFrom('essentialitas@gmail.com', 'Mutya');


									$mail->AddReplyTo("essentialitas@gmail.com","Mutya");


									$mail->Subject    = "Acount Activation";


									$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test

									$mail->MsgHTML($body);


									// $address = $email;
									$address = $email;
									$mail->AddAddress($address, "Mutya");

									// $mail->AddAddress($address, "M");


					
									if(!$mail->Send()) 
									{ 
										echo "Mailer Error: " . $mail->ErrorInfo;
									} 
									else 
									{
									//register into database

										$register = mysql_query("INSERT INTO users VALUES ('','$usn','$fname','$lname','$birthday', '$address1', '$contact', '$email','$password', '0','$code','$date','0','','','', '1')");
										if ($register) {
											echo '<div class="alert alert-success"><span class="icon-check"></span>You have been registered succesfully!Please check your email to verify your account </div>';
										} else {
											echo "Error!";
										}
											
									//} //email

			
									}
			}
		} else
			{
				echo '<div class="alert alert-error"><span class="icon-warning-sign">&nbsp;</span>Please fill all the fields</div>';
			}
	}	

?>
     	  
		  
<form action="" method="post">
         <div id="register"></div><!--for contact status output-->
		 <br/>
         <fieldset class="example" data-text="registration form">
		 <div class="row cells2">
		 <div class="cell">
		 <h4>Login Information</h4>
		 <hr class="bg-magenta">
		 		 <br/>
          <div class="form-group">
		  <div class="input-control text full-size" data-role="input">
      	  <label for="exampleInputEmail">Username</label>
     	  <input type="text" class="form-control"  name="usn" id="usn" placeholder="Enter Username" value="<?php if(!empty($_POST['usn'])){ echo $_POST['usn'];}?>" required >
		  <button class="button helper-button clear"><span class="mif-cross"></span></button>
   		 </div>
   		 </div>
		 <br/>
          <div class="form-group">
		  <div class="input-control text full-size" data-role="input">
      	  <label for="exampleInputEmail">Email address</label>
     	  <input type="email" class="form-control"  name="email" id="email" placeholder="Enter email" value="<?php if(!empty($_POST['email'])){ echo $_POST['email'];}?>" required >
		  <button class="button helper-button clear"><span class="mif-cross"></span></button>
   		 </div>
   		 </div>
		 <br/>
    <div class="form-group">
	<div class="input-control password full-size" data-role="input">
      <label for="exampleInputEmail">Password</label>
      <input type="password" name="password" class="form-control"  id="password" placeholder="Enter password">
	  <button class="button helper-button reveal"><span class="mif-looks"></span></button>
    </div>
    </div>
	<br/>
    <div class="form-group">
	<div class="input-control password full-size" data-role="input">
      <label for="exampleInputEmail">Repeat Password</label>
      <input type="password" name="repeat" class="form-control"  id="repeat" placeholder="Repeat password">
	  <button class="button helper-button reveal"><span class="mif-looks"></span></button>
    </div>
    </div>
	<!----------Recaptcha---------------------->
	    <div class="form-group col-lg-7">	
      <label for="exampleInputEmail">Enter Recaptcha</label>
  <?php
          require_once('recaptcha/recaptchalib.php');
          $publickey = "6LctstwSAAAAACGr1i8yfn94EENmuQjqrkL7gpxV"; // you got this from the signup page
          echo recaptcha_get_html($publickey);
        ?>
        <!--  <script type="text/javascript"
   src="http://www.google.com/recaptcha/api/challenge?k=6LctstwSAAAAACGr1i8yfn94EENmuQjqrkL7gpxV">
</script>
<noscript>
  <iframe src="http://www.google.com/recaptcha/api/noscript?k=6LctstwSAAAAACGr1i8yfn94EENmuQjqrkL7gpxV"
       height="300" width="500" frameborder="0"></iframe><br />
  <textarea name="recaptcha_challenge_field" rows="3" cols="40">
  </textarea>
  <input type="hidden" name="recaptcha_response_field"
       value="manual_challenge" />
</noscript> -->	
    </div>


    </div>
	<div class="cell">
        <h4>Personal Information</h4>
    <hr class="bg-emerald">   
    <br/>   
   <div class="form-group">
   <div class="input-control text full-size" data-role="input">
      <label for="exampleInputPassword">Firstname</label>
      <input type="text" class="form-control"  name="fname" id="fname" placeholder="Firstname" value="<?php if(!empty($_POST['fname'])){ echo $_POST['fname'];}?>">
	  <button class="button helper-button clear"><span class="mif-cross"></span></button>
    </div>
    </div>
	<br/>
    <div class="form-group">
	<div class="input-control text full-size" data-role="input">
      <label for="exampleInputPassword">Lastname</label>
      <input type="text" class="form-control"  name="lname" id="lname" placeholder="Lastname" value="<?php if(!empty($_POST['lname'])){ echo $_POST['lname'];}?>">
	  <button class="button helper-button clear"><span class="mif-cross"></span></button>
    </div>
    </div>
    <br/>
    <div class="form-group">
      <label for="exampleInputPassword">Birthday</label>
      <select class="span2" name="month" id="month">
       	<option>- Month -</option>
  		<option value="1" <?php if(!empty($_POST['month']) && $_POST['month'] == 1){ echo "selected";}?>>Jan</option> 
		<option value="2" <?php if(!empty($_POST['month']) && $_POST['month']  == 2){ echo "selected";}?>>Feb</option> 
		<option value="3" <?php if(!empty($_POST['month']) && $_POST['month']  == 3){ echo "selected";}?>>Mar</option> 
		<option value="4" <?php if(!empty($_POST['month']) && $_POST['month']  == 4){ echo "selected";}?>>Apr</option> 
		<option value="5" <?php if(!empty($_POST['month']) && $_POST['month']  == 5){ echo "selected";}?>>May</option> 
		<option value="6" <?php if(!empty($_POST['month']) && $_POST['month']  == 6){ echo "selected";}?>>Jun</option> 
		<option value="7" <?php if(!empty($_POST['month']) && $_POST['month']  == 7){ echo "selected";}?>>Jul</option> 
		<option value="8" <?php if(!empty($_POST['month']) && $_POST['month']  == 8){ echo "selected";}?>>Aug</option> 
		<option value="9" <?php if(!empty($_POST['month']) && $_POST['month']  == 9){ echo "selected";}?>>Sep</option> 
		<option value="10" <?php if(!empty($_POST['month']) && $_POST['month']  == 10){ echo "selected";}?>>Oct</option> 
		<option value="11" <?php if(!empty($_POST['month']) && $_POST['month']  == 11){ echo "selected";}?>>Nov</option> 
		<option value="12" <?php if(!empty($_POST['month']) && $_POST['month']  == 12){ echo "selected";}?>>Dec</option>
</select>
<select class="span2" name="day" id="day">
		<option>- Day -</option>
   <?php 
   //day 
   		for($x=1;$x<=31;$x++){
	   		$selected_var = '';
	   		if($_POST['day'] == $x){ $selected_var = "selected";}
		   	echo "<option value='".$x."'".$selected_var.">".$x."</option>";
		}   
   ?>	
   	</select>
      	<select class="span2" name="year" id="year">
       		<option>- Year -</option>
			   <?php 
			   	$year_to_select = date("Y") - 18;
				for($i=$year_to_select;$i>=1940;$i--)
				{
					$selected_var = '';
					if($_POST['year'] == $i){ $selected_var = "selected";}
					echo "<option value='".$i."'".$selected_var.">".$i."</option>";
				}
				?>
		</select>
    </div>
     <br/>
     <br/>
	  <div class="form-group">
	  <div class="input-control text full-size" data-role="input">
      <label for="exampleInputEmail">Address</label>
      <input type="text" class="form-control"  name="address" id="address" placeholder="Enter your address">
	  <button class="button helper-button clear"><span class="mif-cross"></span></button>
    </div>
    </div>
    <br/>
	 <div class="form-group">
	 <div class="input-control number full-size" data-role="input">
      <label for="exampleInputEmail">Contact Number</label>
      <input type="number" class="form-control"  name="contact" id="contact" placeholder="Enter contact">
    </div>
    </div>
    </div>
    </div>
	<br/>
	
	<center>
	<label class="input-control checkbox small-check">
    <input type="checkbox" required>
    <span class="check"></span>
    <span class="caption"></span>
</label>
<a href="terms.php"target="_blank">Terms and Condition</a>
</center>

    <div class="form-group align-center">
    	<input type="submit" name="register" class="button success" value="Register">
 </div>
  </fieldset>  
 </form>
