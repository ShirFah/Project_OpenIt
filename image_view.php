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
	$ROW = false;
	
	if(isset($_GET['id']))
	{
		$ROW = $post->get_one_post($_GET['id']);
	
	}
	else
	{
		$ERROR = "No image was found!";
	}
	

?>


<html>
	<head>
		<title>Open-IT | Single post</title>
		<link href="css/style.css" rel="stylesheet" >
	</head>
	
	
	<body class="index_class">
		<!-- TOP BAR	-->	
		<?php include("header.php") ?>
		<!--cover area-->	
		<div id="cover_area">

			<div id="posts_area" >
						
				<div id="postbox">
				
				<?php
					$User = new User();
					$img_class = new Image();
					if(is_array($ROW))
					{
						echo "<img src='$ROW[image]' style='width:50%';>";						
					}
				?>
				<br style="clear:both">
				</div>
			</div>
			
		</div>
	</body>
</html>