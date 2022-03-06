<?php

session_start();
if(isset($_SESSION['openit_userid']))
{
	$_SESSION['openit_userid']= NULL;
	unset($_SESSION['openit_userid']);
}
header("Location: log_in.php");
die;
