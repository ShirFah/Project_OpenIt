<?php

	include("classes/conect.php");
    include("classes/signup.php");
	
	$first_name = "";
	$last_name = "";
	$gender = "";
	$email = "";

	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$signup = new Signup();
		$result = $signup->evaluate($_POST);
		if($result != "")
		{
			echo "<div id = 'error'>";
			echo "<br>The following erros occurde:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{
			header("Location: log_in.php");
			die;
		}
		
		
		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$gender = $_POST['gender'];
		$email = $_POST['email'];
	
	}

?>
<html>
	<head>
		<title> Open-IT | SignUp</title>
		<link href="css/style.css" rel="stylesheet" >	
	</head>

	<body>
		<div id="bar">
			<div id="titleinebar">Open-IT</div>
			
		</div>
		<div class="only-mobile" id= "bar_sign">
		
			 Sign up to Open-IT<br><br>
		    <form method="post" action="">
			
				<input value="<?php echo $first_name ?>" name="first_name" type="text" id="text" placeholder="First name"><br><br>
				<input value="<?php echo $last_name ?>" name="last_name" type="text" id="text" placeholder="Last name"><br><br>
				
				<span style="font-weight:normal">Gender:</span><br>
				<select id="text" name="gender">
				
					<option><?php echo $gender ?> </option>
					<option>Female</option>
					<option>Male</option>
					
				</select><br><br>
				<input name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="E-mail"><br><br>
				<input name="password" type="password" id="text" placeholder="Password"><br><br>
				<input name="password2" type="password" id="text" placeholder="Retype Password"><br><br>
				<input type="submit" id= "button" value="SignUp">
			</form>
		</div>
	</body>
</html>