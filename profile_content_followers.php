<div class="only-mobile" id = "content_photos">
	<div style="padding:5%;">	
		<?php
	
			$image_class = new Image();
			$post_class = new Post();
			$user_class = new User();
			$followers = $post_class->get_likes($user_data['userid'],"user");
			
			if(is_array($followers))
			{
				foreach($followers as $follower)
				{
					
					$ROW_friends = $user_class->get_user($follower);
					include("user.php");
				}
			}else
			{
				echo "No followers was found";
			}
			
		?>

	</div>
</div>