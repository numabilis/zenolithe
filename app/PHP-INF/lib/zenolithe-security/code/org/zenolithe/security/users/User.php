<?php
namespace org\zenolithe\security\users;

define('USER_STATUS_INACTIVE', 0);
define('USER_STATUS_ACTIVE', 1);

class User {
	protected $id;
	protected $login;
	protected $password;
	protected $email;
	protected $firstname;
	protected $lastname;
	protected $profiles = array();
	protected $status;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getLogin() {
		return $this->login;
	}
	
	public function setLogin($login) {
		$this->login = $login;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function setPassword($password) {
		$this->password = $password;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function setEmail($email) {
		$this->email = $email;
	}
	
	public function getFirstname() {
		return $this->firstname;
	}
	
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}
	
	public function getLastname() {
		return $this->lastname;
	}
	
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}
	
	public function getProfiles() {
		return $this->profiles;
	}
	
	public function setProfiles(array $profiles) {
		$this->profiles = $profiles;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	public function setStatus($status) {
		$this->status = $status;
	}
}