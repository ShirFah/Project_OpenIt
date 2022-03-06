<?php
	
	//unset($_SESSION['openit_userid']);
	include("classes/autoload.php");

	//for posting
	
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
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$post = new Post();
		$id = $_SESSION['openit_userid'];
		$result = $post->create_post($id,$_POST,$_FILES);
		
		if($result == "")
		{
			header("Location: profile.php");
			die;
		}else
		{
			echo "<div id = 'error'>";
			echo "<br>The following erros occurde:<br><br>";
			echo $result;
			echo "</div>";			
		}
	}
	
	//collect posts
	$post = new Post();
	$id = $user_data['userid'];
    $posts = $post->get_post($id);	
	
	//collect friends/like
	$user = new User();
	
    $friends = $user->get_following($user_data['userid'],"user");	
	
	$img_class = new Image();

?>


<html>
	<head>
		<title>Open-IT|My Closet</title>
		<link href="css/style.css" rel="stylesheet" >
		<meta name="viewport" content="width=device-width, initial-scale=0.5">

	</head>
	
	<body class="profile">
		<!-- TOP BAR	-->	
		
		<?php include("header.php") ?>
		<!--cover area-->	
		<br>
		
		<div id="cover">
			<div class ="only-mobile" id="incover">
					<?php
						$image = "Img/empty_cover.jpg";
						if(file_exists($user_data['cover_image']))
						{
							$image = $img_class->get_thumb_cover($user_data['cover_image']);
						}
					?>
				<img  src="<?php echo $image ?>">
			
				<span>
					<?php
						$image = "Img/Male.jfif";
						if($user_data['gender'] == "Female")
						{
							$image = "Img/female.jfif";
						}
						if(file_exists($user_data['profile_image']))
						{
							$image = $img_class->get_thumb_profile($user_data['profile_image']);
						}
					
					?>
					<img id="profilepic" src="<?php echo $image ?>" ></br>
					<a href="change_profile_img.php?change=profile" id="img_in_cover">Change profile image </a>-
					<a href="change_profile_img.php?change=cover" id="img_in_cover">Change cover </a>
				</span>
				
				<?php ?>
				<br>
				<div id="name_inprofile">
					<a style="color:black" href="profile.php?id=<?php echo $user_data['userid'] ?>">
						<?php echo $user_data['first_name'] . " " . $user_data['last_name']   ?>
					</a>
				</div>
				<br>
				<?php
				
					if($user_data['likes'] == 0)
					{
						$my_likes = "";
					}else
		            {
						$like = $user_data['likes'] ;
						$my_likes = "(" . $like . " Followers)";
					}
					
				?>
				<a href="like.php?type=user&id=<?php echo $user_data['userid'] ?>">
					<input id="post_button" type="button" value="Follow <?php echo $my_likes ?>" style="margin-right:10px;width:15%; margin-top:0.5%">
				</a>				
				<a id="menu_buttons" href="index.php"><div id="menu_buttons_style">Timeline</div></a>
				<a id="menu_buttons" href="profile.php?section=following&id=<?php echo $user_data['userid']?>"><div id="menu_buttons_style">Following</div></a> 
				<a id="menu_buttons" href="profile.php?section=followers&id=<?php echo $user_data['userid']?>"><div id="menu_buttons_style">Followers</div></a> 
				<a id="menu_buttons" href="profile.php?section=photos&id=<?php echo $user_data['userid']?>"><div id="menu_buttons_style">Photos</div></a>
				
				<br>				
			</div>
				<!--below cover area-->
				<?php
					
					$section = "default";
					if(isset($_GET['section']))
					{
						$section = $_GET['section'];
					}
					
					if($section == "default")
					{
						include("profile_content_defult.php");
					}elseif($section == "following")
					{
						include("profile_content_following.php");

					}elseif($section == "followers")
					{
						include("profile_content_followers.php");
					
					}elseif($section == "photos")
					{
						include("profile_content_photos.php");
					}
				?>

		</div>
	</body>
</html>