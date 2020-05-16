<?php
class Student {

	//declare variables
	public $name;
	public $email;
	public $mobile;

	private $conn;
	private $table_name;
	public $id;

	//Constructor
	public function __construct($db) {
		$this->conn = $db;

		$this->table_name = "tbl_students";
	}

	public function create_data() {
		//sql query to insert data
		$query = "INSERT INTO " . $this->table_name . "(`name`, `email`, `mobile`) VALUES (?,?,?)";
		// var_dump($query);
		$stmt = $this->conn->prepare($query);

		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->mobile = htmlspecialchars(strip_tags($this->mobile));

		$stmt->bind_param('sss', $this->name, $this->email, $this->mobile);

		if ($stmt->execute()) {
			return true;
		}
		return false;

	}
	public function get_all_data() {
		$sql_query = "SELECT * FROM " . $this->table_name;
		$std_obj = $this->conn->prepare($sql_query);

		$std_obj->execute();

		return $std_obj->get_result();
	}

	public function get_single_data() {
		$sql_query = "SELECT * FROM " . $this->table_name . " WHERE `id`=?";
		$obj = $this->conn->prepare($sql_query);
		$obj->bind_param("i", $this->id);
		$obj->execute();

		$data = $obj->get_result();

		return $data->fetch_assoc();
	}

	public function update_student() {
		$update_query = "UPDATE `tbl_students` SET name=?, email=?, mobile=? WHERE id=?";

		//prepare statement
		$query_object = $this->conn->prepare($update_query);
		//sanitizing inputs

		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->mobile = htmlspecialchars(strip_tags($this->mobile));
		$this->id = htmlspecialchars(strip_tags($this->id));

		//binding parameters with the query
		$query_object->bind_param("sssi", $this->name, $this->email, $this->mobile, $this->id);

		if ($query_object->execute()) {
			return true;
		}
		return false;

	}
	public function delete_student() {
		$del_query = "DELETE FROM `tbl_students` WHERE id=?";

		//prepare statement
		// var_dump($this->id);
		$delete_obj = $this->conn->prepare($del_query);
		//sanitizing inputs

		$this->id = htmlspecialchars(strip_tags($this->id));

		//binding parameters with the query
		$delete_obj->bind_param('i', $this->id);

		if ($delete_obj->execute()) {
			return true;
		}
		return false;
	}

}

?>