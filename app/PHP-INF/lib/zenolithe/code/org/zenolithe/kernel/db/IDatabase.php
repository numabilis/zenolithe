<?php
namespace org\zenolithe\kernel\db;

interface IDatabase {
	public function getType();
	public function getHost();
	public function setHost($host);
	public function getUser();
	public function setUser($user);
	public function getPassword();
	public function setPassword($password);
	public function getName();
	public function setName($name);
// 	public function initialize($host, $user, $password, $name);
	public function connect();
	public function queryToArray($sql);
	public function queryScalar($sql);
}
?>