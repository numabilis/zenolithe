<?php
return array(
	'name' => 'mail/mailTemplateFactory',
	'class' => 'org\zenolithe\kernel\mail\PHPMailerTemplateFactory',
	'scope' => 'application',
	'injected' => array(
		'senderEmail' => 'mail.sender.email',
		'senderName' => 'mail.sender.name',
		'templatesPath' => '{zenolithe.root}templates/mails/'
	)
);
?>