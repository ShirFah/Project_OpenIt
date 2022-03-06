<div id="post">
	<div id="name_inpost">
		<?php
			$image = "Img/female.jfif";
			if($ROW_USER['gender'] == "Male")
			{
				$image = "Img/male.jfif";
			}	
		    $img_class = new Image();
			if(file_exists($ROW_USER['profile_image']))
			{
				$image = $img_class->get_thumb_profile($ROW_USER['profile_image']);
			}
		?>
	
		
	</div>
	<div style = "width:100%">
		<div id="name_inpost">
			<?php 
				if($ROW['is_profile_image'])
				{
					$pronoun = "his";
					if($ROW_USER['gender'] == "Female")
					{
						$pronoun = "her";
					}
					echo "<span style='font-weight:normal; color: #aaa'> updated $pronoun profile image</span>";
				}
				if($ROW['is_cover_image'])
				{
					$pronoun = "his";
					if($ROW_USER['gender'] == "Female")
					{
						$pronoun = "her";
					}
					echo "<span style='font-weight:normal; color: #aaa'> updated $pronoun cover image</span>";
				}
			?>
			
		</div>
		<?php echo htmlspecialchars($ROW['post']) ?>
		
		<br><br>
		
		<?php 
			if(file_exists($ROW['image']))
			{
				$post_img = $img_class->get_thumb_post($ROW['image']);
				echo "<br><br><div><img src='$post_img' id='del_img'/></div>";
			}
		?>

		
	</div>
</div>