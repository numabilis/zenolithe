<?php
namespace org\zenolithe\kernel\session;

class Session implements ISession {
	private static $_instance = null;

	public function __construct() {
		session_start();
		if(!isset($_SESSION['ZENOLITHE_NEW_SESSION'])) {
			$_SESSION['ZENOLITHE_NEW_SESSION'] = true;
		} else {
			$_SESSION['ZENOLITHE_NEW_SESSION'] = false;
		}
	}

	public static function getInstance() {
		if(is_null(self::$_instance)) {
			self::$_instance = new Session();
		}

		return self::$_instance;
	}

	public function getAttributeNames() {
		return array_keys($_SESSION);
	}

	public function getAttribute($name) {
		$value = null;

		if (isset($_SESSION[$name])) {
			$value = $_SESSION[$name];
		}

		return $value;
	}

	//     java.util.Enumeration	getAttributeNames()
	//     Returns an Enumeration of String objects containing the names of all the objects bound to this session.
	//     long	getCreationTime()
	//     Returns the time when this session was created, measured in milliseconds since midnight January 1, 1970 GMT.
	public function getId() {
		return session_id();
	}

	//     long	getLastAccessedTime()
	//     Returns the last time the client sent a request associated with this session, as the number of milliseconds since midnight January 1, 1970 GMT.
	//     int	getMaxInactiveInterval()
	//     Returns the maximum time interval, in seconds, that the servlet container will keep this session open between client accesses.
	//     void	invalidate()
	//     Invalidates this session and unbinds any objects bound to it.
	//     boolean	isNew()
	//     Returns true if the client does not yet know about the session or if the client chooses not to join the session.
	public function removeAttribute($name) {
		unset($_SESSION[$name]);
	}

	public function setAttribute($name, $value) {
		$_SESSION[$name] = $value;
	}
	//     void	setMaxInactiveInterval(int interval)
	
	public function isNew() {
		return $this->getAttribute('ZENOLITHE_NEW_SESSION');
	}
	
	function __destruct() {
		session_write_close();
	}
}
?>
