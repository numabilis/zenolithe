<?php
namespace org\zenolithe\kernel\mail;

use PHPMailer;

class PHPMailerTemplate extends PHPMailer implements IMailTemplate {
	protected $templatePath;
	protected $parameters;
	
	public function setTemplatePath($templatePath) {
		$this->templatePath = $templatePath;
	}
	
	public function setParameters($parameters) {
		$this->parameters = $parameters;
	}
	
	public function send() {
		if($this->parameters) {
			foreach($this->parameters as $parameter => $value) {
				$$parameter = $value;
			}
		}
		$template = require($this->templatePath);
//		file_put_contents('/tmp/test.html', $template['html-body']);
		if(isset($template['subject'])) $this->Subject = $template['subject'];
		if(isset($template['html-body'])) $this->Body = $template['html-body'];
		if(isset($template['alt-body'])) $this->AltBody = $template['alt-body'];
		
		return parent::send();
	}
}