<?php
function select_multiclickpics($cpt_id, $lang) {
    $sql = 'SELECT * from cms_multiclickpics '
         . 'WHERE mcp_cpt_id = '.quote_smart($cpt_id)
         . ' AND mcp_lang='.quote_smart($lang).' '
         . 'ORDER BY mcp_id';
    $result = null;
    $multiclickpic = array();

    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)) {
            $multiclickpic[] = $row;
        }
        pg_freeresult($result);
    }

    return $multiclickpic;
}
?>
