<div id="post">
	<div id="name_inpost">
		<?php
			$image = "Img/female.jfif";
			if($ROW_USER['gender'] == "Male")
			{
				$image = "Img/male.jfif";
			}			
			if(file_exists($ROW_USER['profile_image']))
			{
				$image = $img_class->get_thumb_profile($ROW_USER['profile_image']);
			}
		?>
	
		<img id = "img_inpost2" src="<?php echo $image?>">
	</div>
	<div style = "width:100%">
		<div id="name_inpost">
			<?php 
				echo "<a style='color:black;font-weight:bold;font-family:Segoe Script' href='profile.php?id=ROW[userid]'>";
				echo htmlspecialchars($ROW_USER['first_name']) . " " . htmlspecialchars($ROW_USER['last_name']) ;
				echo "</a>";
				
				if($ROW['is_profile_image'] == 1)
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
				echo "<img src='$post_img' />";
			}
		?>
		<br/><br/>
		<?php
			$likes = "";
			$likes = ($ROW['likes'] > 0) ? "(" .$ROW['likes']. ")" : "" ; //check if we have likes
		?>
		<a id="like" href="like.php?type=post&id=<?php echo $ROW['postid'] ?>">Like<?php echo $likes?></a> 
		
		<?php
			$i_liked = false;
			if(isset($_SESSION['openit_userid']))
			{
				$DB = new Database();
				$sql = "select likes from likes where type = 'post' && contentid = '$ROW[postid]' limit 1 ";
				$res = $DB->read($sql);
				
				if(is_array($res))
				{
					$likes = json_decode($res[0]['likes'],true);
					
					$user_ids = array_column($likes,"userid");
					
					if(in_array($_SESSION['openit_userid'],$user_ids))
					{
						
						$i_liked = true;
					}
				}
			
				if($ROW['likes'] > 0)
				{
					echo "<br>";
					echo "<a href='likes.php?type=post&id=$ROW[postid]'>";
					if($ROW['likes'] == 1)
					{
						if($i_liked)
						{	
							echo "<div style='text-align:left; color:#aaa'>  You liked this post </div>";
						}else
						{
							echo "<div style='text-align:left; color:#aaa'>  1 Person liked this post </div>";
						}
					}else{
						if($i_liked)
						{
							$text = "others";
							if($ROW['likes']-1 == 1)
							{	
								$text = "other";
							}
							echo "<div style='text-align:left; color:#aaa'> You and " . ($ROW['likes']-1). " " .  $text . " liked this post </div>";
						}else
						{
							echo "<div style='text-align:left; color:#aaa'>" . $ROW['likes'] . " People liked this post </div>";
						}
					}
					
					echo "</a>";

				}
			}
			
		
		?>
		
		
		<br/><br/>
		
		<span style="color:#aaa">  
			<?php echo $ROW['date'] ?>
		</span>
		
		<?php
			if($ROW['has_image'])
			{
				echo "<a style='color:#aaa;' href='image_view.php?id=$ROW[postid]' >";
				echo "View full image";
				echo "</a>";
			}
		?>
		<span style="color:#aaa; float:right;">
			<?php 
				
				$post = new Post();
				
				if($post->i_own_post($ROW['postid'],$_SESSION['openit_userid']))
				{
					echo "
					<a style='color:#aaa;' href='edit.php?id=$ROW[postid]'>
						Edit
					</a> .
					
					<a style='color:#aaa;' href='delete.php?id=$ROW[postid]' >
						Delete
					</a> . ";
				}
			?>
		</span>
		
		
		</div>
</div>