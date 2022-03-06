<?php
	$corner_image = "Img/male.jfif";

	if(isset($USER))
	{
		if(file_exists($USER['profile_image']))
		{
			$img_class = new Image();
			$corner_image = $img_class->get_thumb_profile($USER['profile_image']);
			//$corner_image = $user_data['profile_image'];
		}else
		{
			if($USER['gender'] == "Female")
			{
				$corner_image = "Img/female.jfif";
			}
		}
	}
?>

<div id="bar">
	<form method="get" action="search.php">
		<a id="mycloset_tit" href="index.php"> My Closet</a>
		
			<input type="text" id="search_box" name='find' placeholder="Search..">
		
		<a href="logout.php">
			<span id="click_logout">Logout</span>
		</a>
			
		<a href="profile.php">
			<img src="<?php echo $corner_image ?>" id="pic_inbar">
		</a>
	</form>			
</div>