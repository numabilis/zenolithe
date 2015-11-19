<?php
namespace org\zenolithe\kernel\mail {
	class PHPMailerTemplateFactory implements IMailTemplateFactory {
		protected $senderEmail;
		protected $senderName;
		protected $templatesPath;
		
		public function __construct() {
			if(version_compare(PHP_VERSION, '5.1.2', '>=')) {
				// SPL autoloading was introduced in PHP 5.1.2
				if(version_compare(PHP_VERSION, '5.3.0', '>=')) {
					spl_autoload_register('PHPMailerAutoload', true, false);
				} else {
					spl_autoload_register('PHPMailerAutoload');
				}
			} else {
				/**
				 * Fall back to traditional autoload for old PHP versions
				 * @param string $classname The name of the class to load
				 */
				function __autoload($classname) {
					PHPMailerAutoload($classname);
				}
			}
		}
		
		public function setSenderEmail($senderEmail) {
			$this->senderEmail = $senderEmail;
		}
		
		public function setSenderName($senderName) {
			$this->senderName = $senderName;
		}
		
		public function setTemplatesPath($templatesPath) {
			$this->templatesPath = $templatesPath;
		}
		
		public function getTemplate($name) {
			$mail = new PHPMailerTemplate();
			$mail->CharSet = 'UTF-8';
			$mail->isHTML(true);
			$mail->isSendmail();
			$mail->setFrom($this->senderEmail, $this->senderName);
			$mail->setTemplatePath($this->templatesPath.$name.'.php');
			
			return $mail;
		}
	}
}

namespace {
	function PHPMailerAutoload($className) {
		$class_file_path = 'class.'.strtolower($className).'.php';
		if((@include 'code/'.$class_file_path) !== 1) {
			$class_file_path = str_replace('\\', '/', $className) . '.php';
			@include 'code/'.$class_file_path;
		}
	}
}