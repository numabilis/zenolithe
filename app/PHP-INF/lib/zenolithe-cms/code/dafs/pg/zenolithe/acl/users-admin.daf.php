<?php
function select_all_users() {
    $sql = 'SELECT * FROM cms_users order by usr_last_name';
    $users = array();
    $result = null;

    $pqConn = db_connect();
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        while ($row = pg_fetch_array($result, NULL, PGSQL_ASSOC)) {
            $users[] = $row;
        }
        pg_freeresult($result);
    }

    return $users;
}

function select_user_by_id($id) {
	$sql = 'SELECT * FROM cms_users where usr_id = '.quote_smart($id);
    $user = null;
	$result = null;
	
	$pqConn = db_connect();
	$result = pg_query($pqConn, $sql);
	if(!$result) {
		error("pg : ".$sql);
	} else {
		$user = pg_fetch_array($result, NULL, PGSQL_ASSOC);
		pg_freeresult($result);
	}
	
	return $user;
}

function users_select_by_email($email) {
    $user = null;
    $pqConn = db_connect();
    $sql  = 'SELECT * FROM cms_users '
          . 'WHERE usr_email = '.quote_smart($email);

    $result = pg_query($pqConn, $sql);
    if($result) {
        $user = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    } else {
        throw new Exception('Error while querying database for section: '.$sql);
    }

    return $user;
}

function insert_user($first_name, $last_name, $login, $email, $password, $profile) {
	$result = null;
	$id = 0;
    $sql = 'INSERT INTO cms_users (usr_first_name, usr_last_name, usr_login, usr_email, usr_password, usr_profile) '
         . 'VALUES ('.quote_smart($first_name).', '.quote_smart($last_name).', '.quote_smart($login)
         . ', '.quote_smart($email).', '.quote_smart($password).', '.quote_smart($profile).') returning usr_id';
	
	$pqConn = db_connect();

	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
	    $tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
        $id = $tmp['usr_id'];
		pg_freeresult($result);
	}
	
	return $id;
}

function delete_user($id) {
	$resultat = null;
	
	$sql = 'DELETE FROM cms_users where user_id='.$id.'';
	$pqConn = db_connect();
	$resultat = pg_query($pqConn, $sql);
	if (!$resultat) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($resultat);
	}
}

function update_user($id, $first_name, $last_name, $login, $email, $profile) {
	$result = null;
	$sql = 'UPDATE cms_users SET
			usr_last_name='.quote_smart($last_name).',
			usr_first_name='.quote_smart($first_name).',
			usr_login='.quote_smart($login).',
			usr_email='.quote_smart($email).',
			usr_profile='.quote_smart($profile).'
			WHERE usr_id='.quote_smart($id);
	$pqConn = db_connect();

	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
	
	return $result;
}

function update_user_preferences($id, $first_name, $last_name, $login, $email) {
	$result = null;
	$sql = 'UPDATE cms_users SET
			usr_last_name = '.quote_smart($last_name).',
			usr_first_name = '.quote_smart($first_name).',
			usr_login = '.quote_smart($login).',
			usr_email = '.quote_smart($email).'
			WHERE usr_id = '.quote_smart($id);
	$pqConn = db_connect();

	$result = pg_query($pqConn, $sql);
	if (!$result) {
		error("pg : ".$sql);
	} else {
		pg_freeresult($result);
	}
	
	return $result;
}

function update_user_password($paswword, $email) {
    $result = null;
    $sql = 'UPDATE cms_users SET
    			usr_password = '.quote_smart($paswword).'
    		WHERE usr_email = '.quote_smart($email);
    $pqConn = db_connect();
    
    $result = pg_query($pqConn, $sql);
    if (!$result) {
        error("pg : ".$sql);
    } else {
        pg_freeresult($result);
    }
    
    return $result;
}
?>
