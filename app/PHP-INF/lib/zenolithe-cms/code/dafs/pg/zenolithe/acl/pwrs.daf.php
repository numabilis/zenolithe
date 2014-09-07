<?php
function select_pwr_by_code($code) {
	$sql = 'SELECT * FROM pwrs WHERE pwr_code = '.quote_smart($code);
    $pwr = null;
	$result = null;
	
	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if(!$result) {
		error("pg : ".$sql);
	} else {
		$pwr = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		pg_freeresult($result);
	}
	
	return $pwr;
}

function insert_pwr($email, $code) {
    $result = null;
    $id = 0;
    $sql = 'INSERT INTO pwrs (pwr_email, pwr_code) 
    		VALUES ('.quote_smart($email).', '.quote_smart($code).')';

    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
}

function delete_pwrs($email) {
	$result = null;
	$sql = 'DELETE FROM pwrs WHERE pwr_email = '.quote_smart($email);
	
	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
}
?>
