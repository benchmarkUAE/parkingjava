<?php
header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Methods: GET, POST');
	header('content-type: application/json; charset=utf-8');
	header('Access-Control-Allow-Headers: content-type');

$con = mysqli_connect("fdb16.awardspace.net", "3225733_db1", "12345678w", "3225733_db1");
 $con ->set_charset("utf8");
if(!$con)
{
 die("Error ".mysqli_connect_error());
 
}
else
{
 
 
}
$name=$_POST['name'];
$sql = "SELECT `student_id`, `student_password`, `student_name`, `student_email`, `student_phone`, `points`, `student_book_time`, `student_book_duration`,
 `student_book_code`, `student_car_plate`, `parking_lot_id` FROM `student` WHERE  `student_name` = '$name' ;";

$res = mysqli_query($con,$sql);
$response = array();
if($res)
{
	
    while($row=mysqli_fetch_array($res))
  {
    array_push($response,array('student_id'=>$row['student_id'],'student_password'=>$row['student_password'],'student_email'=>$row['student_email'],
	'student_phone'=>$row['student_phone'],'points'=>$row['points'],'student_book_time'=>$row['student_book_time'],'student_book_duration'=>$row['student_book_duration'],
	'student_book_code'=>$row['student_book_code'],'student_car_plate'=>$row['student_car_plate'],'parking_lot_id'=>$row['parking_lot_id']));
  }
 echo json_encode($response);
}else
{
  echo('Not Found');
}
mysqli_close($con);

/*while($row=mysqli_fetch_array($res))
{
 
 array_push($response,array($row[0],$row[1]));
}

echo json_encode(array($response));
mysqli_close($con);
//echo "Hello world...";*/


