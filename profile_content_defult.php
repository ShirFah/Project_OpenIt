<div style="display:flex;">
	<!--friends area-->
	<div class="row">
	
					<!--posts area-->
	<!--<div> -->
	<div class="col-9 only-mobile" id="posts_area">
	
		<div id="postbox" class="col-3">
			<form method="post" enctype="multipart/form-data">
				<textarea id="box" name="post" placeholder="whats in your mind?"></textarea>
				<input id="post_im" type="file" name="file">
				<input id="post_button" type="submit" value="Post">
				<br>
			</form>
		</div>
						<!--posts-->
		<div id="posts_bar" class="col-6 only-mobile">
			<?php
				if($posts)
				{
					foreach($posts as $ROW)
					{
						$user = new User();
						$ROW_USER = $user->get_user($ROW['userid']);									
										
						include("post.php");
					}
				}

			?>

		</div>
	</div>
	<!--</div> -->
	
	<div class ="col-3 only-mobile" id="friends_area">
		<div id="likes_bar" class="col-3">
			Following<br>
			<?php
				if($friends)
				{
					if(is_array($friends))	
					{
						foreach($friends as $friend)
						{
							
							$ROW_friends = $user->get_user($friend);	
									
							include("user.php");
						}
					}
					else
					{
							$ROW_friends = $user->get_user($friends);			
							include("user.php");
					}
				}

			?>						
							
		</div>
	</div>
	</div>
</div>