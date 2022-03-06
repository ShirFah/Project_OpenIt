<div class="only-mobile" id = "content_photos">
	<div style="padding:5%;">	
		<?php
	
			$image_class = new Image();
			$post_class = new Post();
			$user_class = new User();
			$following = $user_class->get_following($user_data['userid'],"user");
			
			if(is_array($following))
			{
				
				foreach($following as $follower)
				{
					
					$ROW_friends = $user_class->get_user($follower);
					include("user.php");
				}
			}else
			{
				echo "This user isnt following anyone";
			}
			
		?>

	</div>
</div>