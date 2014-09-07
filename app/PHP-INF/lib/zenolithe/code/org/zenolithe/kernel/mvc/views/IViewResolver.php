<?php
namespace org\zenolithe\kernel\mvc\views {
	interface IViewResolver {
		public function resolve($name, $locale);
		public function filepath($name, $locale);
	}
}

namespace {
	use org\zenolithe\kernel\ioc\IocContainer;
	use org\zenolithe\kernel\mvc\IModel;
	
	function view_file($name, $locale=null) {
		return IocContainer::getInstance()->get('viewResolver')->filepath($name, $locale);
	}
	
	function render_view($name, IModel $model) {
		$view = IocContainer::getInstance()->get('viewResolver')->resolve($name, $model->getLocale());
		$view->render($model);
	}
}
?>
