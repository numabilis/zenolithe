<?php
/**
 * 22-mai-06 - david : Creation
 *
 */
namespace org\zenolithe\kernel\mvc\forms;

define("NAME", 0);
define("ALPHANUM", 1);
define("MAIL", 2);
define("HEX_STRING", 3);
define("B64_STRING", 4);
define("CUSTOM", 5);
define("URL", 6);
define("BASICTEXT", 7);

class Validator {
	static public function isEmptyString($field) {
		$empty = true;

		if(isset($field)) {
			if(strlen(trim($field)) != 0) {
				$empty = false;
			}
		}

		return $empty;
	}

	static public function isValidEmail($field) {
		$value = 1;

		if(isset($field)) {
			$value = preg_match("/^[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]@[a-zA-Z0-9][\w\.-]*[a-zA-Z0-9]\.[a-zA-Z][a-zA-Z\.]*[a-zA-Z]$/i", $field);
		}

		return $value;
	}

	static public function isValidName($field) {
		$value = 1;

		if(isset($field)) {
			$value = preg_match("/^[a-zàáâãäåæçèéêëìíîïðñòóôõöøœšùúûüýþÿžA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠÙÚÛÜÝÞŸŽß\-\ ]+$/", $field);
		}

		return $value;
	}

	static public function isValidInteger($value) {
		$valid = false;

		if(isset($value)) {
			$valid = preg_match("/^\-?[0-9]+$/", $value);
		}

		return $valid;
	}

	static public function isValidFloat($value) {
		$valid = false;

		if(isset($value)) {
			$valid = preg_match("/^\-?[0-9]+\.?[0-9]+$/", $value);
			$valid |= self::isValidInteger($value);
		}

		return $valid;
	}

	static public function isValidDate($date, $format='d/m/Y') {
		$valid = true;

		if($date !=  '') {
			$d = date_create_from_format($format, $date);
			if(!$d || ($date != date_format($d, $format))) {
				$valid = false;
			}
		} else {
			$valid = false;
		}

		return $valid;
	}

	static public function isValid($value, $type, $max=0, $min=0, $custom=null) {
		$valid = true;

		if ($value != null) {
			switch($type) {
				case NAME:
					if($max == 0) {
						$valid = is_string($value) && (strlen($value) >= $min)
						&& (preg_match("/^[a-zàáâãäåæçèéêëìíîïðñòóôõöøœšùúûüýþÿžA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠÙÚÛÜÝÞŸŽß\-\\\' ]+$/", $value) == 1);
					} else {
						$valid = is_string($value) && (strlen($value) <= $max) && (strlen($value) >= $min)
						&& (preg_match("/^[a-zàáâãäåæçèéêëìíîïðñòóôõöøœšùúûüýþÿžA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠÙÚÛÜÝÞŸŽß\-\\\' ]+$/", $value) == 1);
					}
					break;
				case ALPHANUM:
					if($max == 0) {
						$valid = is_string($value) && (strlen($value) >= $min)
						&& (preg_match("/^[0-9a-zàáâãäåæçèéêëìíîïðñòóôõöøœšùúûüýþÿžA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠÙÚÛÜÝÞŸŽß\-\\\' ]+$/", $value) == 1);
					} else {
						$valid = is_string($value) && (strlen($value) <= $max) && (strlen($value) >= $min)
						&& (preg_match("/^[0-9a-zàáâãäåæçèéêëìíîïðñòóôõöøœšùúûüýþÿžA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠÙÚÛÜÝÞŸŽß\-\\\' ]+$/", $value) == 1);
					}
					break;
				case BASICTEXT:
					if($max == 0) {
						$valid = is_string($value) && (strlen($value) >= $min)
						&& (preg_match("/^[0-9a-zàáâãäåæçèéêëìíîïðñòóôõöøœšùúûüýþÿžA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠÙÚÛÜÝÞŸŽß&\-\\\'\"{([|_\\@)\]}+=€u%*<>?,.;\/:!\n\r ]+$/", $value) == 1);
					} else {
						$valid = is_string($value) && (strlen($value) <= $max) && (strlen($value) >= $min)
						&& (preg_match("/^[0-9a-zàáâãäåæçèéêëìíîïðñòóôõöøœšùúûüýþÿžA-ZÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØŒŠÙÚÛÜÝÞŸŽß&\-\\\'\"{([|_\\@)\]}+=€u%*<>?,.;\/:!\n\r ]+$/", $value) == 1);
					}
					break;
				case MAIL:
					if($max == 0) {
						$valid = is_string($value) && (strlen($value) >= $min)
						&& (preg_match("/^[\d\w\/+!=#|$?%{^&}*`'~-][\d\w\/\.+!=#|$?%{^&}*`'~-]*@[A-Z0-9][A-Z0-9.-]{1,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $value) == 1);
					} else {
						$valid = is_string($value) && (strlen($value) <= $max) && (strlen($value) >= $min)
						&& (preg_match("/^[\d\w\/+!=#|$?%{^&}*`'~-][\d\w\/\.+!=#|$?%{^&}*`'~-]*@[A-Z0-9][A-Z0-9.-]{1,61}[A-Z0-9]\.[A-Z]{2,6}$/i", $value) == 1);
					}
					break;
				case HEX_STRING:
					if($max == 0) {
						$valid = is_string($value) && (strlen($value) >= $min)
						&& (preg_match("/^[0-9a-fA-F]+$/", $value) == 1);
					} else {
						$valid = is_string($value) && (strlen($value) <= $max) && (strlen($value) >= $min)
						&& (preg_match("/^[0-9a-fA-F]+$/", $value) == 1);
					}
					break;
				case B64_STRING:
					if($max == 0) {
						$valid = is_string($value) && (strlen($value) >= $min)
						&& (preg_match("/^[0-9a-zA-Z\+\/=]+$/", $value) == 1);
					} else {
						$valid = is_string($value) && (strlen($value) <= $max) && (strlen($value) >= $min)
						&& (preg_match("/^[0-9a-zA-Z\+\/=]+$/", $value) == 1);
					}
					break;
				case CUSTOM:
					if($max == 0) {
						$valid = (strlen($value) >= $min) && (preg_match($custom, $value) == 1);
					} else {
						$valid = (strlen($value) <= $max) && (strlen($value) >= $min)
						&& (preg_match($custom, $value) == 1);
					}
					break;
				case URL:
					if($max == 0) {
						$valid = (strlen($value) >= $min) && (preg_match("|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", $value) == 1);
					} else {
						$valid = (strlen($value) <= $max) && (strlen($value) >= $min)
						&& (preg_match("|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i", $value) == 1);
					}
					break;
				default:
					$valid = false;
				break;
			}
		} else {
			$valid = false;
		}

		return $valid;
	}
}
?>
