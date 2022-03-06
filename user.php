
<div id="likes" style="display: inline-block;">
	<?php
		
		
		if($ROW_friends){
			$image = "Img/male.jfif";
			if($ROW_friends['gender'] == "Female")
			{
				$image = "Img/female.jfif";
			}
			
			if(file_exists($ROW_friends['profile_image']))
			{
				$image = $img_class->get_thumb_profile($ROW_friends['profile_image']);
			}
		}
		
	?>
	<a href="profile.php?id=<?php echo $ROW_friends['userid']; ?>">
	<img id="like_img"src="<?php echo $image ?>"><br>
		<?php echo  $ROW_friends['first_name'] . " " . $ROW_friends['last_name'] ?>
	</a>
</div>