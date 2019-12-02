<?php
	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header('content-type: application/json; charset=utf-8');
	header('Access-Control-Allow-Headers: content-type');

	//Database connection
	$mysqli = new mysqli("fdb16.awardspace.net", "3225733_db1", "12345678w", "3225733_db1");
	
	if ($mysqli->connect_errno)
	{
		echo "Failed to connect to MySQL: (" . 
		$mysqli->connect_errno . ") " . 
		$mysqli->connect_error;
	}

	//--- Enable arabic content ---
	//$resultarabicCharset = $mysqli->query('SET CHARACTER SET utf8');
	//
	//if (!$resultarabicCharset)
	//{
	//	echo "Can't charset in Database";
	//}

	//get input variables
	$user_email = "";
	$user_password = "";
	
	if (isset($_GET['user_email']))
	{
		$user_email = $_GET['user_email'];
	}
	
	if (isset($_GET['user_password']))
	{
		$user_password = $_GET['user_password'];
	}
	
	//------------------------
	$data = array();
	$SQLQuery = "";

	if (!empty($user_email) && !empty($user_password))
	{
		$query = "SELECT * FROM user WHERE " . 
		"user_email='" . $user_email . "' ".
		"AND user_password='" . $user_password . "';";
		
		$res = $mysqli->query($query);
		if ($res)
		{
			if ($res->num_rows>0)
			{
				// a user is foundz
				$res->data_seek(0);
				$row = $res->fetch_assoc();
				
				$data=array("RESULT" => "SUCCESS");
				echo json_encode($data);
			}
			else
			{
				// no user is found
				$data=array("RESULT" => "ERROR");
				echo json_encode($data);
			}
		}
		else
		{
			// no user is found
			$data=array("RESULT" => "ERROR");
			echo json_encode($data);
		}		
	}
	else
	{
		// no user is found
		$data=array("RESULT" => "ERROR");
		echo json_encode($data);
	}
?>


