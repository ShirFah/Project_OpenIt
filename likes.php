<?php
	
	include("classes/autoload.php");

	
	$login = new Login();
	$user_data = $login->check_login($_SESSION['openit_userid']);
	
	$USER = $user_data;
	if(isset($_GET['id']) && is_numeric($_GET['id']))
	{
		$profile = new Profile();
		$profile_data = $profile->get_profile($_GET['id']);
	     
		if(is_array($profile_data))
		{
			$user_data = $profile_data[0];
		}
	}
	
	
	$ERROR = "";
	$post = new Post();
	$likes = false;
	if(isset($_GET['id']) && isset($_GET['type']))
	{
		$likes = $post->get_likes($_GET['id'],$_GET['type']);
	}
	else
	{
		$ERROR = "No information was found!";
	}
	
	$USER = $user_data;

?>


<html>
	<head>
		<title>Open-IT | People who like</title>
		<link href="css/style.css" rel="stylesheet" >
		<meta name="viewport" content="width=device-width, initial-scale=0.5">
	</head>
	
	
	<body class="index_class">
		<!-- TOP BAR	-->	
		<?php include("header.php") ?>
		<!--cover area-->	
		<div id="cover_area">

			<div id="posts_area" >
						
				<div class="only-mobile" id="postbox_like">
				
				<?php
					$User = new User();
					$img_class = new Image();
					if(is_array($likes))
					{
						
						foreach($likes as $row)
						{
							
							$ROW_friends = $User->get_user($row['userid']);
							include("user.php");
						}
					}
				?>
				<br style="clear:both">
				</div>
			</div>
			
		</div>
	</body>
</html>