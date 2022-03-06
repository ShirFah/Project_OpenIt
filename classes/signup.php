<?php

class Signup
{
	private $error ="";
	
	public function evaluate($data)
	{
		foreach ($data as $key => $value)
		{
			if(empty($value))
			{
				$this->error = $this->error . $key . " is empty!<br>";
			}
			
			if($key == "email")
			{
				if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$value))
				{
						$this->error =  $this->error . "Invalid email address!<br>";
				}
			}
			
			if($key == "first_name")
			{
				if(is_numeric($value))
				{
					$this->error =  $this->error . "First name cant be a number!<br>";
				}
				if(strstr($value, " "))
				{
					$this->error =  $this->error . "First name cant have spaces!<br>";
				}
				
			}
			
			if($key == "last_name")
			{
				if(is_numeric($value))
				{
						$this->error =  $this->error . "Last name cant be a number!<br>";
				}
				if(strstr($value, " "))
				{
					$this->error =  $this->error . "Last name cant have spaces!<br>";
				}
			}
		}
		if($this->error == "")
		{
			//no error
			$this->create_user($data);
		}
		else
		{
			return $this->error;
		}
	}
	
	public function create_user($data)
	{
		$first_name = ucfirst($data['first_name']);
		$last_name = ucfirst($data['last_name']);
		$gender = $data['gender'];
		$email = $data['email'];
		$password = $data['password'];
		
		$password = hash('sha1',$password);
		//create that
		$url_adress = strtolower($first_name) . "." . strtolower($last_name);
		$userid = $this->create_userid();
		$query = "insert into users 
		(userid,first_name,last_name,gender,email,password,url_adress) 
		values
		('$userid','$first_name','$last_name','$gender','$email','$password','$url_adress')";
		$query_Create_Likes =  "insert into likes (type,contentid,likes,following) values ('user','$userid','[]','[]') ";
		//echo $query;
		$DB = new Database();
		$DB->save($query);
		$DB->save($query_Create_Likes);
	}
	
	
	private function create_userid()
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
?>