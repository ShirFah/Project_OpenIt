<?php

session_start();
class Login
{
	private $error = "";
	public function evaluate($data)
	{

		$email = addslashes($data['email']);
		$password = addslashes($data['password']);
	
		$query = "select * from users where email = '$email' limit 1";
		
		//echo $query;
		$DB = new Database();
		$res = $DB->read($query);
		if($res)
		{
			$row = $res[0];
			if($this->hash_text($password) == $row['password'])
			{
				//create session data
				$_SESSION['openit_userid'] = $row['userid'];
			}else
			{
				$this->error .= "Wrong email or password <br>";
			}
			
		}else
		{
			$this->error .= "Wrong email or password <br>";
		}
		return $this->error;
	}
	
	private function hash_text($text)
	{
		$text = hash("sha1",$text);
		return $text;
	}
	
	public function check_login($id)
	{
	    if(is_numeric($id))
		{
			$query = "select * from users where userid = '$id' limit 1";

			$DB = new Database();
			$res = $DB->read($query);
			if($res)
			{
				$user_data = $res[0];
				return $user_data;
			}else
			{
				header("Location: log_in.php");
				die;
			}
			
		//check if the user logged in
			
		}else
		{
			header("Location: log_in.php");
			die;
		}		
	}
}