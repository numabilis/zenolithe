<?php
namespace org\zenolithe\kernel\db;

use PDO;

class PDOFactory {
	private $engine;
	private $host;
	private $user;
	private $password;
	private $name;
	private $pdo;

	public function setEngine($engine) {
		$this->engine = $engine;
	}

	public function setHost($host) {
		$this->host = $host;
	}

	public function setUser($user) {
		$this->user = $user;
	}

	public function setPassword($password) {
		$this->password = $password;
	}

	public function setName($name) {
		$this->name = $name;
	}
	
	public function getPdo($new=false) {
		$pdo = null;
		
		if(!$this->pdo || $new) {
			$pdo = new PDO($this->engine.':dbname='.$this->name.";host=".$this->host.';charset=utf8', $this->user, $this->password);
			if(!$this->pdo && !$new) {
				$this->pdo = $pdo;
			}
		} else {
			$pdo = $this->pdo;
		}
		
		return $pdo;
	}
}