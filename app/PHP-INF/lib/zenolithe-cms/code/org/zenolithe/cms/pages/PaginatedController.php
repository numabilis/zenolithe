<?php
/*
 *
* Created on 21 juin 07 by David Jourand
*
*/
namespace org\zenolithe\cms\pages;

use org\zenolithe\kernel\http\RequestHelper;
use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\http\UrlProvider;
use org\zenolithe\kernel\mvc\controllers\IController;
use org\zenolithe\cms\page\PaginatedPageModel;

abstract class PaginatedController implements IController {
	public $view;
	public $pageItemsCount = 50;
	protected $page;
	
	public final function handleRequest(Request $request) {
		$pageModel = new PaginatedPageModel();
		
		if($request->getParameter('pageItemsCount')) {
			$request->getSession()->setAttribute('page-items-count', $request->getParameter('pageItemsCount'));
			$this->pageItemsCount = $request->getParameter('pageItemsCount');
		} else if($request->getSession()->getAttribute('page-items-count')) {
			$this->pageItemsCount = $request->getSession()->getAttribute('page-items-count');
		}
		if($this->pageItemsCount) {
			if($request->getParameter('p')) {
				$this->page = $request->getParameter('p');
			} else {
				$pos = strpos($request->url, '.mod.');
				if($pos) {
					$slashPos = strrpos(substr($request->url, 0, $pos), '/');
					$url = substr($request->url, 0, $slashPos+1);
					$p = substr($request->url, $slashPos+1);
					$p = substr($p, 0, strrpos($p, '.mod.'));
					if(is_numeric($p)) {
						$request->redirect(UrlProvider::getBaseUrl().$url.'?p='.$p);
					}
				}
				$this->page = 1;
			}
			$offset = ($this->page - 1) * $this->pageItemsCount;
			$this->retrieve($request, $pageModel, $offset, $this->pageItemsCount);
		} else {
			$this->retrieve($request, $pageModel);
		}
		$pageModel->setCurrent($this->page);
		$pagesCount = $this->getAllItemsCount();
		if($pagesCount) {
			$pageCount = ceil($pagesCount / $this->pageItemsCount);
		} else {
			$pageCount = 0;
		}
		$pageModel->setPagesCount($pageCount);
		$pageModel->setItemsCount($this->pageItemsCount);
		$reqHelper = RequestHelper::getInstance();
		if($this->page != 1) {
			$prev = $this->page - 1;
			if($prev > 1) {
				$pageModel->setPreviousPage($reqHelper->urlWithModifiedParameter('p', $prev));
			} else {
				$pageModel->setPreviousPage($reqHelper->urlWithRemovedParameter('p'));
			}
		}
		if($this->page != $pageCount) {
			$next = $this->page + 1;
			$pageModel->setNextPage($reqHelper->urlWithModifiedParameter('p', $next));
		}
		$pageModel->setCanonical($reqHelper->canonical());
		if($pageCount && ($this->page > $pageCount)) {
			$request->redirect($reqHelper->urlWithRemovedParameter('p'));
		}
		if($this->page > 1) {
			$request->getAttribute('page')->robots = 'noindex, follow';
		}
		$pageModel->setViewName($this->view);

		return $pageModel;
	}

	public function getTranslatedIndiceUrlPart($lang) {
		return '';
	}

	protected abstract function retrieve(Request $request, Page $pageModel, $offset=0, $itemsCount=0);

	protected abstract function getAllItemsCount();
}
?>
