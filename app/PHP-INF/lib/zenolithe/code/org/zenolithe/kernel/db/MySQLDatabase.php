<?php
namespace org\zenolithe\kernel\db;

class MySQLDatabase implements IDatabase {
	private $host = '';
	private $user = '';
	private $password = '';
	private $name = '';
	private $connection;

	public function getType() {
		return 'My';
	}

	public function getHost() {
		return $this->host;
	}

	public function setHost($host) {
		$this->host = $host;
	}

	public function getUser() {
		return $this->user;
	}

	public function setUser($user) {
		$this->user = $user;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function getName() {
		return $this->name;
	}

	public function setName($name) {
		$this->name = $name;
	}

	public function connect() {
		if(!$this->connection) {
			$this->connection = mysqli_connect($this->host, $this->user, $this->password, $this->name);
		}
		
		return $this->connection;
	}

	public function queryToArray($sql) {
		$rows = array ();
	
		$cnx = $this->connect();
		$result = mysqli_query($cnx, $sql);
		if(!$result) {
			error('MySQL : ' . $sql . ' in ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
		} else {
			while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
				$rows[] = $row;
			}
			mysqli_free_result($result);
		}
	
		return $rows;
	}

	public function queryScalar($sql) {
		$scalar = null;
		
		$cnx = $this->connect();
		$result = mysqli_query($cnx, $sql);
		if(!$result) {
			error('MySQL : ' . $sql . ' in ' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
		} else {
			$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
			debug($row);
			$scalar = $row[0];
			mysqli_free_result($result);
		}
		
		return $scalar;
	}
}
?>