<?php
	
	include("classes/autoload.php");
	
	//for posting
	$login = new Login();
	$user_data = $login->check_login($_SESSION['openit_userid']);	
	
	if(isset($_GET['find']))
	{
		$find = addslashes($_GET['find']);
		$sql = "select * from users where first_name like '%$find%' || last_name like '%$find%' limit 30";
		
		$DB = new Database();
		$results = $DB->read($sql);
		
	}
	$USER = $user_data;

?>


<html>
	<head>
		<title>Open-IT | Search</title>
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
					if(is_array($results))
					{
						foreach($results as $row)
						{
						
							
							$ROW_friends = $User->get_user($row['userid']);
							
							include("user.php");
						}
					}else
					{
						echo "No results were found";
					}
				?>
				<br style="clear:both">
				</div>
			</div>
			
		</div>
	</body>
</html>