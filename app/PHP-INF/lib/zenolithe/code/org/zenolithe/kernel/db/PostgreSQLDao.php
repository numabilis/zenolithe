<?php
namespace org\zenolithe\kernel\db;

class PostgreSQLDao implements IDao {
	protected $database;
	
	public function setDatabase(IDatabase $database) {
		$this->database = $database;
	}
	
	public function quoteSmart($value) {
		if(get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		if(!is_numeric($value)) {
			$value = "'" . pg_escape_string($value) . "'";
		}
	
		return $value;
	}
	
	public function quote($value) {
		if(get_magic_quotes_gpc()) {
			$value = stripslashes($value);
		}
		$value = "'" . pg_escape_string($value) . "'";
	
		return $value;
	}
}
?>