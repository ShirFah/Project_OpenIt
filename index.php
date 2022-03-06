<?php
	
	include("classes/autoload.php");
	
	//for posting
	
	$login = new Login();
	$user_data = $login->check_login($_SESSION['openit_userid']);
	$USER = $user_data;
?>


<html>
	<head>
		<title>Open-IT | TimeLine</title>
		<link href="css/style.css" rel="stylesheet" >
		<meta name="viewport" content="width=device-width, initial-scale=0.5">
	</head>
	
	
	<body class="index_class">
		<!-- TOP BAR	-->	
		<?php include("header.php") ?>
		<!--cover area-->	
		<div class="row only-mobile" id="cover_area_index">
				<!--below cover area-->
				<div class="row only-mobile" id ="index"">
					<!--friends area-->
					<div class="col-3 only-mobile" id="friends_area2">
						<div id="likes_bar_index">
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
					<img id="pic_inindex" src="<?php echo $image ?>" ></br>
							<a id="name_in_tit" href ="profile.php"> 
								<?php  echo $user_data['first_name'] . " " . $user_data['last_name'] ?>
							</a>
						</div>
					</div>

					<!--posts area-->
					<div  class="col-9 only-mobile" id="posts_area_index" >
						
						<!--posts-->
						<div class="only-mobile" id="posts_bar_index">
						
							<?php
							
								$DB = new Database();
								$user_class = new User();
								//$image_class = new Image();
								$followers = $user_class->get_following($_SESSION['openit_userid'],"userid");
								$follower_ids = "";
								$post = new Post();
								$img_class = new Image();
								
								
								if(is_array($followers))
								{
									//foreach($followers as $follow)
									//{
									//	$follower_ids = $follower_ids . "," . $follow;
									//}
									//$follower_ids = array_column($followers,"userid");
									//print_r($follower_ids);
									$follower_ids = implode(",",$followers);
										
								}
								
								if($follower_ids)
								{
									$sql = "select * from posts where userid in('" .$follower_ids. "') limit 30 ";
									$posts = $DB->read($sql);
									
								}
									
								$id = $user_data['userid'];
								//$posts = $post->get_post($id);	
								$follower_ids = explode(",",$follower_ids);
								//if(isset($posts) && $posts)
								//{
									foreach($follower_ids as $temp_id)
									{
										$user = new User();
										$ROW_USER = $user->get_user($temp_id);
										$r = $post->get_post($temp_id);
											if($r !== false){
												
												foreach($r as $ROW)
												{					
													include("post.php");
												}
											
											}
										
										
									}
								//}
								
								

							?>
						
						</div>
					</div>
		</div>
		
	</body>
</html>