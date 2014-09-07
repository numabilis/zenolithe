<?php
namespace org\zenolithe\kernel\db;

class MySQLDao implements IDao {
	protected $database;
	
	public function setDatabase(IDatabase $database) {
		$this->database = $database;
	}
	
	public function quoteSmart($value) {
		if(get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		if(!is_numeric($value)) {
			$value = "'" . mysqli_real_escape_string($this->database->connect(), $value) . "'";
		}
	
		return $value;
	}
	
	public function quote($value) {
		if(get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		$value = "'" . mysqli_real_escape_string($this->database->connect(), $value) . "'";
	
		return $value;
	}
}
?>