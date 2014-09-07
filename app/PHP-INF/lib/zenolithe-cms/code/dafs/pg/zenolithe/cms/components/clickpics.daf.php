<?php
function select_clickpic($cpt_id, $lang) {
    $sql = 'SELECT * from cms_clickpics WHERE ckp_cpt_id = '.quote_smart($cpt_id).' AND ckp_lang='.quote_smart($lang);
    $result = null;
    $clickpic = null;

    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        $clickpic = pg_fetch_row($result, NULL, PGSQL_ASSOC);
        pg_freeresult($result);
    }

    return $clickpic;
}
?>
