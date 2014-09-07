<!DOCTYPE html>
<html
	xmlns="http://www.w3.org/1999/xhtml"
	lang="en">
<head>
	<meta charset="utf-8" />
	<title>Zenolithe</title>
</head>
<body>
<?php
	foreach($model->getContent('body-begin') as $cpt) {
		render_view($cpt->getViewName(), $cpt);
	}
?>
	<header>
	</header>