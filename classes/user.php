<?php

class User
{
	public function get_data($id)
	{
		$query = "select * from users where userid = '$id' limit 1 ";
		$DB = new Database();
		$res = $DB->read($query);
		
		if($res)
		{
			$row = $res[0];
			return $row;
		}else
		{
			return false;
		}
	}
	
	public function get_user($id)
	{
		$query = "select * from users where userid = '$id' limit 1 ";
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
	
		public function get_friends($id)
	{
		$query = "select * from users where userid != '$id'";
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
	
		public function get_following($id,$type)
	{
		$DB = new Database();
		if(is_numeric($id))
		{
						
			//get following detail
			$type = 'user';
			$sql = "select following from likes where type = '$type' && contentid = '$id' limit 10 ";
			
			$res = $DB->read($sql);
			
			if(is_array($res))
			{
				$following = json_decode($res[0]['following'],true);
				
				return $following;
			}
			
			
		}
		
		return false;
		
	}
	
	public function follow_user($id,$type,$openit_userid)
	{
		
		$DB = new Database();
	    $sql2 = "select following from likes where type = '$type' AND contentid = '$openit_userid' limit 1 ";

		$res2 = $DB->read($sql2);
			
			$likes = json_decode($res2[0]['following'],true);
			$user_ids = array($likes);
			
			if($likes&& !in_array($id,$likes) ) // If user is not in the array and the array is not empty
			{
				
				array_push($likes,$id);
				$likes_string = json_encode($likes); //convert arr to string
				
				$sql = "update likes set following = '$likes_string' where type = '$type' && contentid = '$openit_userid' limit 1 ";
				$DB->save($sql);
				
		
			}else if($likes)
			{
				
		
				$index = array_search($id,$likes);
				if($index!==FALSE){
					unset($likes[$index]);
					$likes = array_values($likes);
				}
				
				$likes_string = json_encode($likes);
				
			
				
				$sql = "update likes set following = '$likes_string' where type = '$type' && contentid = '$openit_userid' limit 1 ";
			
				$DB->save($sql);
				
					
			}
			else{ // user does not follow any users yet
				
				$likes = array($id);
				$likes_string = json_encode($likes); //convert arr to string
		
				$sql = "update likes set following = '$likes_string' where type = '$type' && contentid = '$openit_userid' limit 1 ";
				$DB->save($sql);
				
			}
					
		//}
		/*
		else
		{
			$arr["userid"] = $id;
			$arr["date"] = date("Y-m-d H:i:s");
				
			$arr2[] = $arr;
				
			$following = json_encode($arr2); //convert arr to string
			
			
			$sql = "insert into likes (type,contentid,following) values ('$type','$openit_userid','$following') ";
				
			$DB->save($sql);
				
		}
		*/	
		
	}
	
}
