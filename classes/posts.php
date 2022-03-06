<?php

class Post
{
	private $error = "";
	public function create_post($userid,$data,$files)
	{
		if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image']))
		{
			$myimage = "";
			$has_image = 0;
			$is_cover_image = 0;
			$is_profile_image = 0;
			if(isset($data['is_profile_image']) || isset($data['is_cover_image']))
			{
				$myimage = $files;
				$has_image = 1;
				
				if(isset($data['is_cover_image']))
				{
					$is_cover_image = 1;
				}
				
				if(isset($data['is_profile_image']))
				{
					$is_profile_image = 1;
				}
			}else{
					
				
				if(!empty($files['file']['name']))
				{
					$image_class = new Image();
					$folder = "uploads/" . $userid . "/";

					//create folder
					if(!file_exists($folder))
					{
						mkdir($folder,0777,true);
						file_put_contents($folder . "index.php", "");
					}
					
					$image_class = new Image();
					$myimage = $folder . $image_class->generate_filename(15) . ".jpg";
						
					move_uploaded_file($_FILES['file']['tmp_name'], $myimage);
					$image_class->resize_image($myimage,$myimage,1500,1500);

					$has_image = 1;
					
				}
			}
			$post = "";
			if(isset($data['post']))
			{
				$post = addslashes($data['post']);
			}
			$postid = $this->create_postid();
			
			$query = "insert into posts (userid,postid,post,image,has_image,is_profile_image,is_cover_image) values ('$userid','$postid','$post','$myimage','$has_image','$is_profile_image','$is_cover_image')";
			
			$DB = new Database();
			$DB->save($query);
			
		}else
		{
			$this->error .= "Say something!<br>";
		}
		return $this->error;
	}
	
	public function edit_post($data,$files)
	{
		if(!empty($data['post']) || !empty($files['file']['name']))
		{
			$myimage = "";
			$has_image = 0;

			if(!empty($files['file']['name']))
			{
				$image_class = new Image();
				$folder = "uploads/" . $userid . "/";

					//create folder
				if(!file_exists($folder))
				{
					mkdir($folder,0777,true);
					file_put_contents($folder . "index.php", "");
				}
					
				$image_class = new Image();
				$myimage = $folder . $image_class->generate_filename(15) . ".jpg";
						
				move_uploaded_file($_FILES['file']['tmp_name'], $myimage);
				$image_class->resize_image($myimage,$myimage,1500,1500);

				$has_image = 1;
					
			}
			
			$post = "";
			if(isset($data['post']))
			{
				$post = addslashes($data['post']);
			}
			$postid = addslashes($data['postid']);
			
			if($has_image)
			{
				$query = "update posts set post = '$post' . image = '$myimage' where postid = '$postid' limit 1";
			}else
			{
				$query = "update posts set post = '$post' where postid = '$postid' limit 1";
			}
			
			$DB = new Database();
			$DB->save($query);
			
		}else
		{
			$this->error .= "Say something!<br>";
		}
		return $this->error;
	}
	public function get_post($id)
	{
		$query = "select * from posts where userid = '$id' order by id desc limit 10";
			
		$DB = new Database();
		$res = $DB->read($query);
		
		if($res)
		{
			return $res;
		}else
		{
			return false;
		}
	}
	
	public function get_one_post($postid)
	{
		if(!is_numeric($postid))
		{
			return false;
		}
		$query = "select * from posts where postid = '$postid' order by id desc limit 1";
			
		$DB = new Database();
		$res = $DB->read($query);
		
		if($res)
		{
			return $res[0];
		}else
		{
			return false;
		}
	}
	
	public function delete_post($postid)
	{
		
		if(!is_numeric($postid))
		{
			return false;
		}
		$query = "delete from posts where postid = '$postid' limit 1";
			
		$DB = new Database();
	    $DB->save($query);
		
	}
	
	public function i_own_post($postid,$openit_userid = 0)
	{
		
		
		if(!is_numeric($postid))
		{
			return false;
		}
		$query = "select * from posts where postid = '$postid' limit 1";
			
		$DB = new Database();
	    $res = $DB->read($query);
		
		if(is_array($res))
		{
			if($res[0]['userid'] == $openit_userid)
			{
				return true;
			}
		}
		return false;
		
	}
	
	public function get_likes($id,$type)
	{
		
		$DB = new Database();
		if($type == "post" && is_numeric($id))
		{			
			
				//get likes detail
			$sql = "select likes from likes where type = 'post' && contentid = '$id' limit 1 ";
			$res = $DB->read($sql);
				
			if(is_array($res))
			{
				$likes = json_decode($res[0]['likes'],true);
				return $likes;
			}
		}		
		if($type == "user" && is_numeric($id))
		{			
			
				//get likes detail
			$sql = "select likes from likes where type = 'user' && contentid = '$id' limit 1 ";
			$res = $DB->read($sql);
				
			if(is_array($res))
			{
				$likes = json_decode($res[0]['likes'],true);
				return $likes;
			}
		}
		return false;
	}	
	
	
	public function like_post($id,$type,$openit_userid)
	{
		$DB = new Database();
			//save likes detail
		$sql = "select likes from likes where type = '$type' && contentid = '$id' limit 1 ";
		$sql2 = "select following from likes where type = 'user' && contentid = '$openit_userid' limit 1 ";
		
		$res = $DB->read($sql);
		$res2 = $DB->read($sql2);
		
		if(is_array($res2))	
		{
			$following = json_decode($res2[0]['following'],true);	
			//$user_ids = array_column($following,"userid");
			
			if($following == null)
			{
				$following = array();
				
		
			}
			
			if(in_array($id,$following))
			{
				$sql3 = "update users set likes = likes - 1 where userid = '$id' limit 1 ";
				$likes = json_decode($res[0]['likes']);
				if($likes == null)
				{
					$likes = array();

				}
				
				$key = array_search($openit_userid,$likes);
				unset($likes[$key]);
				$likes = array_values($likes);
				$likes1 = json_encode($likes);
				$sql_3 = "update likes set likes = '$likes1' where contentid = '$id' limit 1";
				//print_r($openit_userid);
				//	die;
				$DB->save($sql_3);
				$DB->save($sql3);
			}
			else
			{

				$sql4 = "update users set likes = likes + 1 where userid = '$id' limit 1 ";
				$likes = json_decode($res[0]['likes']);
				if(gettype($likes)=="object"){
					$likes = array($like);
				}
				
				if($likes!==null)
				{
				array_push($likes,$openit_userid);
				
				$likes1 = json_encode($likes);
				$sql_4 = "update likes set likes = '$likes1' where contentid = '$id' limit 1";
				
				$DB->save($sql4);
				$DB->save($sql_4);
				}
			}
		}
		else
		{
			/*
			if($res2==null)//the new part (if!!)
			{
				$arr = array($openit_userid);
				
				$likes = json_encode($arr); //convert arr to string
				$sql = "insert into likes (type,contentid,likes) values ('user','$openit_userid','$likes') ";
					
				$DB->save($sql);
					//increment the right table
				$sql = "update users set likes = likes + 1 where userid = '$openit_userid' limit 1 ";
				$DB->save($sql);
			}
			*/
			//else
			//{
				
				$arr = array($openit_userid);
					
				$likes = json_encode($arr); //convert arr to string
				$sql = "insert into likes (type,contentid,likes) values ('user','$id','$likes') ";
					
				$DB->save($sql);
					//increment the right table
				$sql = "update users set likes = likes + 1 where userid = '$id' limit 1 ";
				$DB->save($sql);
			//}
		}
		if(is_array($res) && $type == 'post' )
		{
			$likes = json_decode($res[0]['likes'],true);
				
			$user_ids = array_column($likes,"userid");
			
			
				if(!in_array($openit_userid,$user_ids))
				{
					
					$arr["userid"] = $openit_userid;
					$arr["date"] = date("Y-m-d H:i:s");
						
					$likes[] = $arr;
					$likes_string = json_encode($likes); //convert arr to string
						
					$sql = "update likes set likes = '$likes_string' where type = '$type' && contentid = '$id' limit 1 ";
					$DB->save($sql);
						
					//increment the right table
					
					$sql = "update {$type}s set likes = likes + 1 where {$type}id = '$id' limit 1 ";
					$DB->save($sql);
					
				}else
				{
					
					$key = array_search($openit_userid,$user_ids);
					unset($likes[$key]);
					$likes_string = json_encode($likes);
					$sql = "update likes set likes = '$likes_string' where type = '$type' && contentid = '$id' limit 1 ";
					$DB->save($sql);
						
						//increment the right table
					$sql = "update {$type}s set likes = likes - 1 where {$type}id = '$id' limit 1 ";
					$DB->save($sql);
					
				}
				
			
		}else if ($type == 'post')
		{
			$arr["userid"] = $openit_userid;
			$arr["date"] = date("Y-m-d H:i:s");
				
			$arr2[] = $arr;
				
			$likes = json_encode($arr2); //convert arr to string
			$sql = "insert into likes (type,contentid,likes) values ('$type','$id','$likes') ";
				
			$DB->save($sql);
				
				//increment the right table
			$sql = "update {$type}s set likes = likes + 1 where {$type}id = '$id' limit 1 ";
			$DB->save($sql);
				
		}
			
		
	}
	
	private function create_postid()
	{
		$length = rand(4,19);
		$number = "";
		for($i=0; $i < $length; $i++)
		{
			$new_rand = rand(0,9);
			$number = $number . $new_rand;
		}
		return $number;
	}
}

