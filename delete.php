<?php
	
	include("classes/autoload.php");
	
	//for posting
	$login = new Login();
	$user_data = $login->check_login($_SESSION['openit_userid']);	
	
	$DB = new Database();
	$ERROR = "";
	if(isset($_GET['id']))
	{
		$post = new Post();
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
	
	//if somethinf was posted
	
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$post->delete_post($_POST['postid']);
		header("Location: profile.php");
		die;
	}
	
	$USER = $user_data;
?>


<html>
	<head>
		<title>Open-IT | Delete</title>
		<link href="css/style.css" rel="stylesheet" >
		<meta name="viewport" content="width=device-width, initial-scale=0.5">
	</head>
	
	
	<body>
		<!-- TOP BAR	-->	
		<?php include("header.php") ?>
		<!--cover area-->	
		<div id="del_area">

			<div class ="only-mobile" id="del_area" >
						
				<div  class ="only-mobile" id="postbox_del" style="margin-left:-10%;">
					<form method="post">
				
							<?php 
								if($ERROR != "")
								{
									echo $ERROR;
								}
								else
								{
									echo "<div id='edit_text'>" . "Are you sure you want to delete this post?<br><br><br><br>" .  "</div>";
									$user = new User();
									$ROW_USER = $user->get_user($ROW['userid']);
									
									include("post_delete.php");
									
									echo "<input type='hidden' name='postid' value='$ROW[postid]'>";
									echo "<input id='del_button' type='submit' value='Delete'>";
								}
							?>
						
						
					</form>
				</div>
			</div>
			
		</div>
	</body>
</html>