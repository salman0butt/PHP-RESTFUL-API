<?php
//include headers
header("Access-Control-Allow-Origin: *"); //Allow All Domains ,Subdomains to access
header("Content-type: application/json; charset=UTF-8"); //data type
header("Access-Control-Allow-Methods: POST"); //Data Methods

include_once "../config/database.php";
include_once "../classes/student.php";

$db = new Database();

$connection = $db->connect();
$student = new Student($connection);

if ($_SERVER['REQUEST_METHOD'] === "POST") {

	$param = json_decode(file_get_contents("php://input"));
	$student->id = $param->id;
	$student_data = $student->get_single_data();
	if (!empty($student_data)) {

		http_response_code(200);
		echo json_encode(array(
			"status" => 1,
			"data" => $student_data,
		));
	} else {
		http_response_code(404);
		echo json_encode(array(
			"status" => 0,
			"data" => "student not found",
		));
	}

} else {
	http_response_code(503);
	echo json_encode(array(
		"status" => 0,
		"message" => "Access denied",
	));
}

?>