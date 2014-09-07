<?php
namespace org\zenolithe\kernel\mvc\forms;

use org\zenolithe\kernel\mvc\IModel;

interface IFormModel extends IModel {
	public function setField($name, $value);
	public function getField($name);
	public function getFields();
	public function getAttribute($name);
	public function setAttribute($name, $value);
	public function hasError($field=null);
	public function reject($errorCode);
	public function rejectValue($field, $errorCode);
	public function getErrorCode($field=null);
	public function getErrorCodes();
}
?>