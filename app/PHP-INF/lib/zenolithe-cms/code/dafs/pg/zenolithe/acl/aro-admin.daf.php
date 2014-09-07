<?php
/*
 *
 * Created on 18 mai 07 by David Jourand
 *
 */

function aro_groups_create($aro_id, $aro_type, $group_id) {
    $pqConn = db_connect();
    $sql = 'insert into cms_aro_groups ';
    $sql .= '(acl_aro_id, acl_aro_type, grp_id) ' ;
    $sql .= 'values ';
    $sql .= '('.quote_smart($aro_id).', '.quote_smart($aro_type).','.quote_smart($group_id).')';

    $result = pg_query($pqConn, $sql);
    if (! $result) {
        throw new Exception('Can not execute SQL insertion : '.$sql);
    }

    return $result;
}

function aro_groups_delete($aro_id, $aro_type, $group_id) {
    $pqConn = db_connect();
    $sql = 'delete from cms_aro_groups ';
    $sql .= 'where acl_aro_id = '.quote_smart($aro_id).' ';
    $sql .= 'and acl_aro_type = '.quote_smart($aro_type).' ';
    $sql .= 'and grp_id = '.quote_smart($group_id);

    $result = pg_query($pqConn, $sql);
    if (! $result) {
        throw new Exception('Can not execute SQL insertion : '.$sql);
    }

    return $result;
}
?>
