<?php
	
	include("classes/autoload.php");
	
	//for posting
	$login = new Login();
	$user_data = $login->check_login($_SESSION['openit_userid']);	
	
	$post = new Post();
	$DB = new Database();
	$ERROR = "";
	if(isset($_GET['id']))
	{
		
		$ROW = $post->get_one_post($_GET['id']);
		
		if(!$ROW)
		{
			$ERROR = "No such post was found!";
		}else
		{
			if($ROW['userid'] != $_SESSION['openit_userid'])
			{
				$ERROR = "Access denied you cant delete this file";
			}
		}
	}else
	{
		$ERROR = "No such post was found!";
	}
	
	//if something was posted
	if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'],"edit.php"))
	{
		$_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];
	}	
		
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$post->edit_post($_POST,$_FILES);
		header("Location: " . $_SESSION['return_to'] );
		die;
	}
	

	$USER = $user_data;
?>


<html>
	<head>
		<title>Open-IT | Edit</title>
		<link href="css/style.css" rel="stylesheet" >
		<meta name="viewport" content="width=device-width, initial-scale=0.5">
	</head>
	
	
	<body>
		<!-- TOP BAR	-->	
		<?php include("header.php") ?>
		<!--cover area-->	
		<div id="edit_area">

			<div id="posts_area" >
						
				<div class="only-mobile" id="postbox_edit">
					<form method="post" enctype="multipart/form-data">
				
							<?php 
								if($ERROR != "")
								{
									echo $ERROR;
								}
								else
								{
									echo "<div class='only-mobile' id='edit_text'>" . "Edit post<br><br>" .  "</div>";
									echo '<div class="only-mobile" id="edit_box"><textarea id = "box_inedit" name="post" placeholder="whats in your mind?">' . $ROW['post'] . '</textarea></div>
									<inputid="post_im" type="file" name="file">';
									
									echo "<input type='hidden' name='postid' value='$ROW[postid]'>";
									echo "<input id='edit_post_button' type='submit' value='Save'>";
									
									if(file_exists($ROW['image']))
									{
										$img_class = new Image();
										$post_img = $img_class->get_thumb_post($ROW['image']);
										echo "<br><br><div><img src='$post_img' id='edit_img'/></div>";
									}
								
								
								}
							?>
						
						
					</form>
				</div>
			</div>
			
		</div>
	</body>
</html>