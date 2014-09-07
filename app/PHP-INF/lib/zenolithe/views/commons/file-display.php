<?php
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $model->get('filename'));
if($mime == 'application/xml-sitemap') {
	$mime = 'application/xml';
}
header("Content-type: ".$mime."; charset=utf-8");
$file = fopen($model->get('filename'), 'r');
fpassthru($file);
fclose($file);
?>