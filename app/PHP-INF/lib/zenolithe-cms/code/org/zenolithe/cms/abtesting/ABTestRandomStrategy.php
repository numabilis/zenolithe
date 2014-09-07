<?php
namespace org\zenolithe\cms\abtesting;

class ABTestRandomStrategy {
	public function getGroup($abTest) {
		$group = IABTest::GROUP_CONTROL;
		
		$p = $abTest->getParameter();
		if((rand(0, 99) + 1) <= $p) {
			$group = $abTest::GROUP_TEST_A;
		}
		
		return $group;
	}
}
?>