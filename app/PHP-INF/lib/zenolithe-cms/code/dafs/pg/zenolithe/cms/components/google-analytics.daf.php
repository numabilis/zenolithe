<?php
function select_gaq($cpt_id, $lang) {
    $sql = 'SELECT * from cms_googleanalytics WHERE gaq_cpt_id = '.quote_smart($cpt_id).' AND gaq_lang='.quote_smart($lang);
    $result = null;
    $gaq = null;

    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        $gaq = pg_fetch_row($result, NULL, PGSQL_ASSOC);
        pg_freeresult($result);
    }

    return $gaq;
}
?>
