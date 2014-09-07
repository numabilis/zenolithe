<?php
namespace org\zenolithe\kernel\db;

interface IDao {
	public function setDatabase(IDatabase $database);
	public function quoteSmart($value);
	public function quote($value);
}
?>