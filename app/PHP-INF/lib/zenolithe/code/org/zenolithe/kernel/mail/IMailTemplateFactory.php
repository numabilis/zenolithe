<?php
namespace org\zenolithe\kernel\mail;

interface IMailTemplateFactory {
	public function getTemplate($name);
}