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

	$data = json_decode(file_get_contents("php://input"));
	if (!empty($data->name) && !empty($data->email) && !empty($data->mobile)) {
		$student->name = $data->name;
		$student->email = $data->email;
		$student->mobile = $data->mobile;
		if ($student->create_data()) {
			http_response_code(200);
			echo json_encode(array(
				"status" => 1,
				"message" => "Student Created Successfully",

			));
		} else {
			http_response_code(500);
			echo json_encode(array(
				"status" => 0,
				"message" => "Failed to create Student",
			));
		}

	} else {
		http_response_code(404);
		echo json_encode(array(
			"status" => 0,
			"message" => "All Values needed",
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