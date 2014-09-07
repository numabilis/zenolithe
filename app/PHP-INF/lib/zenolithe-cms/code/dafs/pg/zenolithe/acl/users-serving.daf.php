<?php
function users_select_by_login_and_password($login, $password) {
    $user = null;
    $pqConn = db_connect();
    $sql  = 'SELECT * FROM cms_users '
          . 'WHERE usr_login = '.quote_smart($login)
          . ' AND usr_password = '.quote_smart($password);

    $result = pg_query($pqConn, $sql);
    if($result) {
        $user = pg_fetch_array($result, NULL, PGSQL_ASSOC);
    } else {
        throw new Exception('Error while querying database for section: '.$sql);
    }

    return $user;
}
?>
