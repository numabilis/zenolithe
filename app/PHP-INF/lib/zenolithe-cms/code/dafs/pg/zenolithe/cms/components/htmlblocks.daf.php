<?php
function select_htmlblock($cpt_id, $lang) {
// 	$key = 'select_htmlblock/'.$cpt_id.'/'.$lang;
// 	if(!($htmlblock = apc_fetch($key))) {
		$sql = 'SELECT * from cms_htmlblocks WHERE hbk_cpt_id = '.quote_smart($cpt_id).' AND hbk_lang='.quote_smart($lang);
	  $result = null;
		$htmlblock = null;
		
		$pqConn = db_connect();
		$result = pg_query($pqConn, $sql);
		if (!$result) {
			error("pg : ".$sql);
		} else {
			$htmlblock = pg_fetch_row($result, NULL, PGSQL_ASSOC);
			pg_freeresult($result);
		}
// 		apc_store($key, $htmlblock, 600);
// 	}
	
	return $htmlblock;
}
?>
