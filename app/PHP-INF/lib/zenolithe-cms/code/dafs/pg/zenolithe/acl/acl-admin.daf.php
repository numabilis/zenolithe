<?php
/*
 *
* Created on 16 mai 07 by David Jourand
*
*/
function acls_create($aro_id, $aro_type, $aco_id, $aco_type, $action, $allowed) {
    $id = 0;
    $pqConn = db_connect();

    $sql = 'insert into cms_acls '
         . '(acl_aro_id, acl_aro_type, acl_aco_id, acl_aco_type, acl_action, acl_allowed) '
         . 'values '
         . '('.quote_smart($aro_id).','
         . quote_smart($aro_type).','
         . quote_smart($aco_id).','
         . quote_smart($aco_type).','
         . quote_smart($action).','
         . quote_smart($allowed).') '
         . 'returning acl_id';

    $result = pg_query($pqConn, $sql);
    if ($result) {
        $tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
        $id = $tmp['acl_id'];
        pg_freeresult($result);
    } else {
        throw new Exception('Can not execute SQL insertion : '.$sql);
    }

    return $id;
}

function acls_select($aro_id, $aro_type, $aco_id, $aco_type, $action) {
    $pqConn = db_connect();
    $sql  = 'select * from cms_acls '
          . 'where acl_aro_id = '.quote_smart($aro_id).' '
          . 'and acl_aro_type = '.quote_smart($aro_type).' '
          . 'and acl_aco_id = '.quote_smart($aco_id).' '
          . 'and acl_aco_type = '.quote_smart($aco_type).' '
          . 'and acl_action = '.quote_smart($action);
    $acl = null;

    $result = pg_query($pqConn, $sql);
    if ($result) {
        $acl = pg_fetch_array($result, NULL, PGSQL_ASSOC);
        pg_freeresult($result);
    } else {
        throw new Exception('Can not execute SQL query : '.$sql);
    }

    return $acl;
}

function acls_update($id, $allowed) {
    $pqConn = db_connect();
    $sql  = 'update cms_acls set '
    . 'acl_allowed = '.quote_smart($allowed).' '
    . 'where acl_id = '.quote_smart($id);

    $result = pg_query($pqConn, $sql);
    pg_freeresult($result);
    if (! $result) {
        throw new Exception('Can not execute SQL query : '.$sql);
    }

    return $result;
}

function acls_delete($aro_id, $aro_type, $aco_id, $aco_type, $action) {
    $pqConn = db_connect();
    $sql  = 'delete from cms_acls '
          . 'where acl_aro_id = '.quote_smart($aro_id)
          . ' and acl_aro_type = '.quote_smart($aro_type)
          . ' and acl_aco_id = '.quote_smart($aco_id)
          . ' and acl_aco_type = '.quote_smart($aco_type)
          . ' and acl_action = '.quote_smart($action);

    $result = pg_query($pqConn, $sql);
    pg_freeresult($result);
    if (! $result) {
        throw new Exception('Can not execute SQL query : '.$sql);
    }

    return $result;
}
?>
