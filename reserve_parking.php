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
	$total = "";
	$student_book_time = "";
	$student_book_duration = "";
	$parking_lot_id = "";
	$student_car_plate = "";
	
	if (isset($_GET['student_id']))
	{
		$student_id = $_GET['student_id'];
	}
	
	if (isset($_GET['total']))
	{
		$total = $_GET['total'];
	}
	
	if (isset($_GET['student_book_time']))
	{
		$student_book_time = $_GET['student_book_time'];
	}
	
	if (isset($_GET['student_book_duration']))
	{
		$student_book_duration = $_GET['student_book_duration'];
	}
	
	if (isset($_GET['parking_lot_id']))
	{
		$parking_lot_id = $_GET['parking_lot_id'];
	}
	
	if (isset($_GET['student_car_plate']))
	{
		$student_car_plate = $_GET['student_car_plate'];
	}
	
	//echo "student_id: " . $student_id . "<BR>";
	//echo "total: " . $total . "<BR>";
	//echo "student_book_time: " . $student_book_time . "<BR>";
	//echo "student_book_duration: " . $student_book_duration . "<BR>";
	//echo "parking_lot_id: " . $parking_lot_id . "<BR>";

	//------------------------
	$data = array();
	$SQLQuery = "";

	if (!empty($student_id) && !empty($total) && !empty($student_book_time)
	 && !empty($student_book_duration) && !empty($parking_lot_id)	
	)
	{
		//get current points of current user
		$query1 = "SELECT * from student WHERE student_id = '$student_id';";
		$res1 = $mysqli->query($query1);
		
		if ($res1)
		{
			if ($res1->num_rows>0)
			{
				// a user is found
				$res1->data_seek(0);
				$row = $res1->fetch_assoc();
				
				$points = $row['points'];
				$newPoints = $points - floatval($total);
				
				$student_book_code = round(microtime(true)) . "/" . date("Y-m-d/H:i:s");


				//--- Update points balance
				$query = "UPDATE student SET 
				points = '$newPoints', 
				student_book_time = '$student_book_time',
				student_book_duration = '$student_book_duration',
				student_book_code = '$student_book_code', 
				parking_lot_id = '$parking_lot_id',
				student_car_plate = '$student_car_plate'  
				WHERE student_id = '$student_id'";
				
				//echo $query . "<BR>";
				
				$res = $mysqli->query($query);
				$data=array(
					"RESULT" => "SUCCESS"
				);
				echo json_encode($data);
			}
			else
			{
				$data=array("RESULT" => "ERROR");
				echo json_encode($data);
			}
		}
		else
		{
			$data=array("RESULT" => "ERROR");
			echo json_encode($data);
		}
	}
	else
	{
		$data=array("RESULT" => "ERROR");
		echo json_encode($data);
	}
?>


