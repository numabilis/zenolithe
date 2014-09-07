<?php
namespace org\zenolithe\kernel\mvc\forms;

use org\zenolithe\kernel\mvc\SimpleModel;

class SimpleFormModel extends SimpleModel implements IFormModel {
	private $fields = array();
	private $attributes = array();
	private $hasError = false;
	private $errorCode;
	private $errorCodes = array();
	
	public function setField($name, $value) {
		$this->fields[$name] = $value;
	}
	
	public function getField($name) {
		$value = null;
		
		if(isset($this->fields[$name])) {
			$value = $this->fields[$name];
		}
		
		return $value;
	}
	
	public function getFields() {
		return $this->fields;
	}
	
	public function setAttribute($name, $value) {
		$this->attributes[$name] = $value;
	}
	
	public function getAttribute($name) {
		$value = null;
		
		if(isset($this->attributes[$name])) {
			$value = $this->attributes[$name];
		}
		
		return $value;
	}
	
  public function hasError($field=null) {
    $error = $this->hasError;
    
    if($field != null) {
      $error = isset($this->errorCodes[$field]);
    }
    
    return $error;
  }
  
  public function reject($errorCode) {
    $this->hasError = true;
    $this->errorCode = $errorCode;
  }
  
  public function rejectValue($field, $errorCode) {
    $this->hasError = true;
    $this->errorCodes[$field] = $errorCode;
  }
  
  public function getErrorCode($field=null) {
    $code = $this->errorCode;
    
    if($field != null) {
      $code = $this->errorCodes[$field];
    }
    
    return $code;
  }
  
  public function getErrorCodes() {
    return $this->errorCodes;
  }
}
?>