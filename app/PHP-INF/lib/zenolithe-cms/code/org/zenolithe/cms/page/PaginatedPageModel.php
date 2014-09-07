<?php
namespace org\zenolithe\cms\page;

class PaginatedPageModel extends PageModel {
	private $pagesCount;
	private $itemsCount;
	private $currentPage;
	
	public function setPagesCount($pagesCount) {
		$this->pagesCount = $pagesCount;
	}
	
	public function setItemsCount($itemsCount) {
		$this->itemsCount = $itemsCount;
	}
	
	public function setCurrentPage($currentPage) {
		$this->currentPage = $currentPage;
	}
}
?>