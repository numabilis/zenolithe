<?php
namespace org\zenolithe\kernel\mail;

interface IMailTemplate {
	public function setTemplatePath($templatePath);
	public function setParameters($parameters);
	public function send();
}