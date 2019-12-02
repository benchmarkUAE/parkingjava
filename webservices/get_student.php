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
	$student_id = "";
	$student_password = "";
	
	if (isset($_GET['student_id']))
	{
		$student_id = $_GET['student_id'];
	}
	
	if (isset($_GET['student_password']))
	{
		$student_password = $_GET['student_password'];
	}
	
	//------------------------
	$data = array();
	$SQLQuery = "";

	if (!empty($student_id) && !empty($student_password))
	{
		$query = "SELECT * FROM student WHERE " . 
		"student_id='" . $student_id . "' ".
		"AND student_password='" . $student_password . "';";
		
		$res = $mysqli->query($query);
		if ($res)
		{
			if ($res->num_rows>0)
			{
				// a user is foundz
				$res->data_seek(0);
				$row = $res->fetch_assoc();
				
				$data=array(
					"RESULT" => "SUCCESS",
					"student_name"=>$row['student_name'],
					"student_password"=>$row['student_password'],
					"student_id"=>$row['student_id'],
					"student_email"=>$row['student_email'],
					"student_phone"=>$row['student_phone'],
					"points"=>$row['points']
				);
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


