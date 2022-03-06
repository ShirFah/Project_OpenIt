<?php
	
	include("classes/autoload.php");
	
	$email = "";
	$password = "";
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$login = new Login();
		$result = $login->evaluate($_POST);
		if($result != "")
		{
			echo "<div id='error'>";
			echo "<br>The following erros occurde:<br><br>";
			echo $result;
			echo "</div>";
		}else
		{
			header("Location: profile.php");
			die;
		}
		
		$email = $_POST['email'];
		$password = $_POST['password'];
		
	
	}

?>
<html>
	<head>
		<title> Open-IT | Log-in</title>
		<link href="css/style.css" rel="stylesheet" >
		<meta name="viewport" content="width=device-width, initial-scale=0.5">
	</head>
	
	<body>
		<div id="bar">
			<div id="titleinebar">Open-IT</div>
			<a href="sign_up.php">
			<div id="signup_button">signup</div>
			</a>
			
		</div>
		<div class="only-mobile" id= "bar_log">
			<form method="post">
				
				 Login to Open-IT<br><br>
				 
				<input name="email" value="<?php echo $email ?>" type="text" id="text" placeholder="E-mail"><br><br>
				<input name="password" value="<?php echo $password ?>" type="password" id="text" placeholder="Password"><br><br>
				<input type="submit" id= "button" value="Log-in">
				
			</form>
		</div>
	</body>
</html>