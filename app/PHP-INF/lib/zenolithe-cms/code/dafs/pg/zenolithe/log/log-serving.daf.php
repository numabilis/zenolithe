<?php
function insert_log($aro_id, $aro_type, $aco_id, $aco_type, $action, $info) {
    $sql = 'INSERT INTO logs
    		(log_aro_id, log_aro_type, log_aco_id, log_aco_type, log_action, log_info)
    		VALUES
    		('.quote_smart($aro_id).','.quote_smart($aro_type).','.quote_smart($aco_id).','.quote_smart($aco_type).','
	          . quote_smart($action).','.quote_smart($info).')';

    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if ($result) {
        pg_freeresult($result);
    } else {
        throw new Exception('Can not execute SQL insertion : '.$sql);
    }

    return $result;
}
?>
