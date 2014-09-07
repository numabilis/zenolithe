<?php
  use org\zenolithe\kernel\http\UrlProvider;
?>
<?php header('Content-type: text/html; charset=utf-8'); ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml"
	lang="<?php echo substr($model->getLocale(), 0, 2); ?>">
<head>
	<meta charset="utf-8" />
	<title>Administration Zenolithe CMS</title>
	<link rel="stylesheet" type="text/css" href="<?php echo static_url('css/smoothness/jquery-ui-1.8.23.custom.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo static_url('js/cleditor/jquery.cleditor.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo static_url('js/cleditor/jquery.cleditor.mediasbrowser.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo static_url('css/cms/styles.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Allan:bold" />
	<link rel="stylesheet" type="text/css" href="<?php echo static_url('css/elfinder/css/elfinder.min.css'); ?>" />
  <link rel="stylesheet" type="text/css" href="<?php echo static_url('css/elfinder/css/theme.css'); ?>" />
  
  <script type="text/javascript">var cleditorUrl = '<?php echo UrlProvider::getBaseUrl(); ?>elfinder/connector.minimal.php'</script>
  <script type="text/javascript" src="<?php echo static_url('js/jquery/jquery-1.8.3.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo static_url('js/jquery/jquery-ui-1.8.23.custom.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo static_url('js/jquery/jquery-ui-timepicker-addon.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo static_url('js/cleditor/jquery.cleditor.min.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo static_url('js/cleditor/jquery.cleditor.mediasbrowser.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo static_url('js/jstree/jquery.jstree.js'); ?>"></script>
  <script type="text/javascript" src="<?php echo static_url('js/elfinder/elfinder.min.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo static_url('js/md5.js'); ?>"></script>
	<script type="text/javascript" src="<?php echo static_url('js/zenolithe.js'); ?>"></script>
</head>
<body>
<div id="elfinder"></div>

<div id="banner">
	<div class="logo">
		ZenoCMS
	</div>
    <div id="banner-center">
    	<h1>Administration</h1>
    </div>
</div>

<?php if($model->get('edited_domain')) { $domain = $model->get('edited_domain'); ?>
<div id="edited-domain">
	Site en cours d'édition :
	<a href="<?php echo $domain['dom_base']; ?>" target="_blank"><?php echo $domain['dom_base']; ?></a>
	&nbsp;&nbsp;&nbsp;<a href="<?php echo UrlProvider::getUrl('admin/domains/switch.php'); ?>">Changer...</a>
</div>
<?php } ?>

<div id="left-column"><?php require view_file('admin/menu'); ?></div>
