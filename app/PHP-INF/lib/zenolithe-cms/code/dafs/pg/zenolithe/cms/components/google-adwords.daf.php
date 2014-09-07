<?php
function select_gaw($pageId) {
    $sql = 'SELECT * from cms_google_adwords WHERE gaw_page_id = '.quote_smart($pageId);
    $result = null;
    $gaw = null;

    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if(!$result) {
        error("pg : ".$sql);
    } else {
        $gaw = pg_fetch_row($result, NULL, PGSQL_ASSOC);
        pg_freeresult($result);
    }

    return $gaw;
}
?>
