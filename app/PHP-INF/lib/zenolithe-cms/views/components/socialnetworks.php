<?php
	use org\zenolithe\kernel\bootstrap\Configuration;

	if(Configuration::$debug) {
		echo '<!--';
	}
	$socialModel = $model->get('social-networks');
	if(isset($socialModel['og:site_name'])) {
		echo '<meta property="og:site_name" content="'.$socialModel['og:site_name'].'" />';
	}
  if($_SERVER['SCRIPT_URL'] =='/') {
  	echo '<meta property="og:region" content="x-default"/>';
  } else {
  	echo '<meta property="og:region" content="'.com_lodgicms_helpers_LangHelper::langCode($model->getLocale()).'"/>';
  }
	echo '<meta property="og:type" content="website"/>';
	if(isset($socialModel['fb:admins'])) {
		echo '<meta property="fb:admins" content="'.$socialModel['fb:admins'].'" />';
	}
	if($model->isHome()){
		if(isset($socialModel['fb:app_id'])) {
			echo '<meta property="fb:app_id" content="'.$socialModel['fb:app_id'].'" />';
	 	}
	 	if(isset($socialModel['fb:page_id'])) {
	 		echo '<meta property="fb:page_id" content="'.$socialModel['fb:page_id'].'" />';
	 	}
	}
	if(isset($socialModel['og:url'])) {
		echo '<meta property="og:url" content="'.$socialModel['og:url'].'" />';
	}
	if(isset($socialModel['verify-v1'])) {
		echo '<meta name="verify-v1" content="'.$socialModel['verify-v1'].'" />';
	}
	if(isset($socialModel['msvalidate.01'])) {
		echo '<meta name="msvalidate.01" content="'.$socialModel['msvalidate.01'].'" />';
	}
	if(isset($socialModel['og:title'])) {
		echo '<meta property="og:title" content="'.$socialModel['og:title'].'" />';
	}
	if(isset($socialModel['og:description'])) {
		echo '<meta property="og:description" content="'.$socialModel['og:description'].'" />';
	}
	if(isset($socialModel['og:image'])) {
		echo '<meta property="og:image" content="'.$socialModel['og:image'].'" />';
	}
	// uniquement sur les pages de contenus
	if(isset($socialModel['plus-author'])) {
		echo '<link href="https://plus.google.com/u/0/'.$socialModel['plus-author'].'/posts" rel="author" />';
	}
	// uniquement sur le HP
	if(($_SERVER['SCRIPT_URL'] =='/') && isset($socialModel['plus-publisher'])) {
		echo '<link href="https://plus.google.com/'.$socialModel['plus-publisher'].'/about" rel="publisher" />';
	}
  if(Configuration::$debug) {
    echo '-->';
  }
?>