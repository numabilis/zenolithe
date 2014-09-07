<?php
/**
 * 11-aout-06 - david : Creation
 *
 */
namespace org\zenolithe\kernel\http;

use org\zenolithe\kernel\ioc\IocContainer;

class Request {
	public static $httpRedirectCodes = array(
      '300' => 'Multiple Choices', // L’URI demandée se rapporte à plusieurs ressources
      '301' => 'Moved Permanently', // Document déplacé de façon permanente
      '302' => 'Found', // Document déplacé de façon temporaire
      '303' => 'See Other', //La réponse à cette requête est ailleurs
      '304' => 'Not Modified', // Document non modifié depuis la dernière requête
      '305' => 'Use Proxy', // La requête doit être ré-adressée au proxy
      '307' => 'Temporary Redirect', // La requête doit être redirigée temporairement vers l’URI spécifiée
      '310' => 'Too many Redirect'
	);
	private $method;
	private $attributes = array();
	private $redirectUrl;
	private $redirectCode;
	private $forwardUrl;
	private $session;
	private $locale;
	public $url;

	public function isPostMethod() {
		return (strcmp('POST', $_SERVER['REQUEST_METHOD']) == 0);
	}

	public function setAttribute($name, $value) {
		$this->attributes["$name"] = $value;
	}

	public function getAttribute($name) {
		$attribute = null;

		if(isset($this->attributes["$name"])) {
			$attribute = $this->attributes["$name"];
		}

		return $attribute;
	}

	public function removeAttribute($name) {
		if(isset($this->attributes["$name"])) {
			unset($this->attributes["$name"]);
		}
	}

	public function getParameter($name) {
		$value = null;

		if(isset($_POST[$name])) {
			$value = $_POST[$name];
		} else if(isset($_GET[$name])) {
			$value = $_GET[$name];
		}

		return $value;
	}

	public function getParameters() {
		$parameters = null;

		if($this->isPostMethod()) {
			$parameters = $_POST;
		} else {
			$parameters = $_GET;
		}

		$filtered_parameters = array();
		foreach($parameters as $name => $value) {
			if($name != "u") {
				$filtered_parameters[$name] = $value;
			}
		}

		return $filtered_parameters;
	}

	public function setParameter($name, $value) {
		if($this->isPostMethod()) {
			$_POST[$name] = $value;
		} else {
			$_GET[$name] = $value;
		}
	}

	public function getCookie($cookie_name) {
		$value = null;

		if(isset($_COOKIE[$cookie_name])) {
			$value = $_COOKIE[$cookie_name];
		}

		return $value;
	}

	public function redirect($url, $code=303) {
		$this->redirectUrl = $url;
		$this->redirectCode = $code;
	}

	public function isRedirected() {
		return ($this->redirectUrl != null);
	}

	public function getRedirectURL() {
		return $this->redirectUrl;
	}

	public function getRedirectCode() {
		return $this->redirectCode;
	}

	public function getRedirectMessage() {
		return self::$httpRedirectCodes[$this->redirectCode];
	}

	public function forward($url) {
		$this->forwardUrl = $url;
	}

	public function isForwarded() {
		return ($this->forwardUrl != null);
	}

	public function getForwardURL() {
		return $this->forwardUrl;
	}

	public function getSession($create = true) {
		if(($this->session == null) && $create) {
			$this->session = IocContainer::getInstance()->get('session');
		}

		return $this->session;
	}
	
	public function getLocale() {
		return $this->locale;
	}
	
	public function setLocale($locale) {
		$this->locale = $locale;
	}
}
?>
