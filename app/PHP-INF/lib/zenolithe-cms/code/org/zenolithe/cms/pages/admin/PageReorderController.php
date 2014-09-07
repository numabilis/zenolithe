<?php

namespace org\zenolithe\cms\pages\admin;

use org\zenolithe\kernel\http\Request;
use org\zenolithe\kernel\mvc\controllers\IController;

require daf_file ( 'zenolithe/cms/pages-admin.daf' );
class PageReorderController implements IController {
	public function handleRequest(Request $request) {
		$domain = $request->getSession()->getAttribute('edited-domain');
		$action = $request->getParameter('action');
		$group = $request->getParameter('group');
		$translations = select_all_pages_by_group($domain['dom_site_id'], $group);
		$order = $translations[0]['pge_order'];
		$parentGroup = $translations[0]['pge_parent_group'];
		if($action == 'up') {
			if($order != 0) {
				increase_children_order($domain['dom_site_id'], $parentGroup, $order - 1);
				decrease_order($domain ['dom_site_id'], $group);
			}
		} else {
			$maxOrder = select_max_page_order($domain['dom_site_id'], $parentGroup);
			if($order < $maxOrder) {
				decrease_children_order($domain['dom_site_id'], $parentGroup, $order + 1);
				increase_order($domain ['dom_site_id'], $group);
			}
		}
		
		$request->redirect('list.php');
		
		return null;
	}
}
?>
