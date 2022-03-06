<?php
	
	include("classes/autoload.php");
	
	//for posting
	
	$login = new Login();
	$user_data = $login->check_login($_SESSION['openit_userid']);

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
	
		if((isset($_FILES['file']['name']) && $_FILES['file']['name']) != "")
		{
			if($_FILES['file']['type'] == "image/jpeg")
			{
				$alloewd_size = (1024 * 1024) * 7 ;
				if($_FILES['file']['size'] <$alloewd_size)
				{
					//the size ok
					$folder = "uploads/" . $user_data['userid'] . "/";
					//create folder
					if(!file_exists($folder))
					{
						mkdir($folder,0777,true);
					}
					$image = new Image();
					$file_name = $folder . $image->generate_filename(15) . ".jpg";
					
					move_uploaded_file($_FILES['file']['tmp_name'], $file_name);
					
					$change = "profile";
					//check for mode
					if(isset($_GET['change']))
					{
						$change = $_GET['change'];
					}					
		
					if($change == "cover")
					{
						if(file_exists($user_data['cover_image']))
						{
							unlink($user_data['cover_image']);
						}
						$image->resize_image($file_name,$file_name,1500,1500);
					}else
					{
						if(file_exists($user_data['profile_image']))
						{
							unlink($user_data['profile_image']);
						}
						$image->resize_image($file_name,$file_name,1500,1500);
					}
					if(file_exists($file_name))
					{
						$userid = $user_data['userid'];
						
						$change = "profile";
						//check for mode
						if(isset($_GET['change']))
						{
							$change = $_GET['change'];
						}
						if($change == 'cover')
						{
							$query = "update users set cover_image = '$file_name' where userid = '$userid' limit 1";
							$_POST['is_cover_image'] = 1;
						}else
						{
							$query = "update users set profile_image = '$file_name' where userid = '$userid' limit 1";	
							$_POST['is_profile_image'] = 1;
						}
						
						
						$DB = new Database();
						$DB->save($query);
						
						//create a post
						
						$post = new Post();
						
						$post->create_post($userid,$_POST,$file_name);
						
						
						header("Location: profile.php");
						die;
					}
				}else
				{
					echo "<div id = 'error'>";
					echo "<br>The following erros occurde:<br><br>";
					echo "Only image of size 3MB or lower alloewd";
					echo "</div>";
				}
			}else
			{
				echo "<div id = 'error'>";
				echo "<br>The following erros occurde:<br><br>";
				echo "Please add valid image!";
				echo "</div>";
			}
		}else
		{
			echo "<div id = 'error'>";
			echo "<br>The following erros occurde:<br><br>";
			echo "Please add valid image!";
			echo "</div>";
		}

	}
	
	
	$USER = $user_data;

?>


<html>
	<head>
		<title>Change profile image | TimeLine</title>
		<link href="css/style.css" rel="stylesheet" >
		<meta name="viewport" content="width=device-width, initial-scale=0.5">
	</head>
	
	
	<body>
		<!-- TOP BAR	-->	
		<?php include("header.php") ?>
		<!--cover area-->	
		<div id="cover_area">
				<!--below cover area-->
			
				<form class="only-mobile" id="change_pro_pic" method="post" enctype="multipart/form-data">
					
					<div class="only-mobile" id="postbox2">
						<input id="change_pic" type="file" name="file">
						<input id="change_button" type="submit" value="Change">
						<br>
						<div id="the_old_img">
						<br><br>
						
						<?php
							$change = "profile";
							//check for mode
							
							if(isset($_GET['change']) && $_GET['change'] == "cover")
							{
								if($user_data['cover_image']== "" ){
									print_r("Update cover image");
									return;
								}
								$change = $_GET['change'];
								echo "<img src='$user_data[cover_image]' style='max-width:150%' >";
							}else
							{
								if($user_data['profile_image']== "" ){
									print_r("Update profile image");
									return;
								}
								echo "<img src='$user_data[profile_image]' style='max-width:150%' >";
							}
							
							
						?>
						</div>
					</div>
				</form>
			
		</div>
	</body>
</html>