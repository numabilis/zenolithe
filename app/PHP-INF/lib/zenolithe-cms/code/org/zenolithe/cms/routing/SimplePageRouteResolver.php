<?php
namespace org\zenolithe\cms\routing;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\routing\Route;
use org\zenolithe\kernel\routing\IRouteResolver;
use org\zenolithe\kernel\bootstrap\Context;
use org\zenolithe\cms\business\Domain;
use org\zenolithe\cms\page\PageModel;

require daf_file('zenolithe/common.daf');
require daf_file('zenolithe/cms/webpage-serving.daf');

class SimplePageRouteResolver extends AbstractPageRouteResolver {
	public function buildPreviewPage($previewData) {
		return $this->pagesDao->build($previewData['page']);
	}
	
	public function retrievePage(Request $request) {
		return $this->pagesDao->getPageByUriAndLang($this->urlBuilder->getbaseUrl(), $request->url, $request->getLocale());
	}
}
?>
