<?php
namespace org\zenolithe\kernel\db;

class PostgreSQLDatabase implements IDatabase {
	private $host = '';
	private $user = '';
	private $password = '';
	private $name = '';
	private $connection;
	
	public function getType() {
		return 'Pg';
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
	
// 	public function initialize($host, $user, $password, $name) {
// 		$this->host = $host;
// 		$this->user = $user;
// 		$this->password = $password;
// 		$this->name = $name;
// 	}

	public function connect() {
		if(!$this->connection) {
			$str = '';
			if($this->host) {
				$str .= ' host='.$this->host;
			}
			if($this->user) {
				$str .= ' user='.$this->user;
			}
			if($this->password) {
				$str .= ' password='.$this->password;
			}
			if($this->name) {
				$str .= ' dbname='.$this->name;
			}
			$this->connection = pg_pconnect($str);
		}

		return $this->connection;
	}

	public function queryToArray($sql) {
		$rows = array();

		$pqConn = $this->connect();
		$result = pg_query($pqConn, $sql);
		if(!$result) {
			error('PostgreSQL : '.$sql.' in '.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']);
		} else {
			$rows = pg_fetch_all($result);
			pg_freeresult($result);
		}

		return $rows;
	}
}
?>