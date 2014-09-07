<?php
use org\zenolithe\kernel\http\UrlProvider;
use org\zenolithe\cms\admin\MenuInterceptor;

if($model->get('menu')) {
	$menu = $model->get('menu');
	$menuItem = $menu['selectedItem'];
	if($menuItem == 'pages') {
		echo '<div class="menu-item menu-item-selected"><a href="'.UrlProvider::getUrl('admin/pages/list.php').'">Pages</a></div>';
	} else {
		echo '<div class="menu-item"><a href="'.UrlProvider::getUrl('admin/pages/list.php').'">Pages</a></div>';
	}
	if($menuItem == 'layouts') {
		echo '<div class="menu-item menu-item-selected"><a href="'.UrlProvider::getUrl('admin/layouts/list.php').'">Mises en page</a></div>';
	} else {
		echo '<div class="menu-item"><a href="'.UrlProvider::getUrl('admin/layouts/list.php').'">Mises en page</a></div>';
	}
	if($menuItem == 'components') {
		echo '<div class="menu-item menu-item-selected"><a href="'.UrlProvider::getUrl('admin/components/list.php').'">Composants</a></div>';
	} else {
		echo '<div class="menu-item"><a href="'.UrlProvider::getUrl('admin/components/list.php').'">Composants</a></div>';
	}
	if($menuItem == 'plugins') {
		echo '<div class="menu-item menu-item-selected"><a href="'.UrlProvider::getUrl('admin/plugins/list.php').'">Plugins</a></div>';
	} else {
		echo '<div class="menu-item"><a href="'.UrlProvider::getUrl('admin/plugins/list.php').'">Plugins</a></div>';
	}
	foreach($menu['modules'] as $module) {
		if($menuItem == $module['name']) {
			echo '<div class="menu-item menu-item-selected"><a href="'.UrlProvider::getUrl($module['uri']).'">'.$this->getString('module_'.$module['name'].'_name').'</a></div>';
		} else {
			echo '<div class="menu-item"><a href="'.UrlProvider::getUrl($module['uri']).'">'.$this->getString('module_'.$module['name'].'_name').'</a></div>';
		}
	}
	if($menuItem == 'users') {
		echo '<div class="menu-item menu-item-selected"><a href="'.UrlProvider::getUrl('admin/users/list.php').'">Utilisateurs</a></div>';
	} else {
		echo '<div class="menu-item"><a href="'.UrlProvider::getUrl('admin/users/list.php').'">Utilisateurs</a></div>';
	}
	/*
	if($menuItem == 'sites') {
		echo '<div class="menu-item menu-item-selected"><a href="'.UrlProvider::getUrl('admin/sites/configure.php').'">Configuration</a></div>';
	} else {
		echo '<div class="menu-item"><a href="'.UrlProvider::getUrl('admin/sites/configure.php').'">Configuration</a></div>';
	}
	*/
} else {
	echo '&nbsp;';
}
