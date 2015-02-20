<?php
namespace org\zenolithe\security\users;

define('USER_STATUS_INACTIVE', 0);
define('USER_STATUS_ACTIVE', 1);

class User {
	const USER_CIVILITY_UNKNOWN = 0;
	const USER_CIVILITY_MR = 1;
	const USER_CIVILITY_MRS = 2;
	const USER_CIVILITY_MISS = 3;
	
	protected $id;
	protected $login;
	protected $password;
	protected $email;
	protected $civility;
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
	
	public function getCivility() {
		return $this->civility;
	}
	
	public function setCivility($civility) {
		$this->civility = $civility;
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
	
	public function hasProfile($profile) {
		return in_array($profile, $this->profiles);
	}
}