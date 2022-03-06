<div class="only-mobile" id = "content_photos">
	<div style="padding:5%;">	
		<?php
	
			$DB = new Database();
			$sql = "select image,postid from posts where has_image = 1 && userid = $user_data[userid] order by id desc limit 30";
			$images = $DB->read($sql);
			
			$image_class = new Image();
			if(is_array($images))
			{
				foreach($images as $image_row)
				{
					echo "<img src='" . $image_class->get_thumb_post($image_row['image']) . "' style='width:20%; margin:5%; '>";
				}
			}else
			{
				echo "No image was found";
			}
			
		?>

	</div>
</div>