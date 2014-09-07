<?php
/*
 *
* Created on 18 mai 07 by David Jourand
*
*/

function groups_create($name, $parent_id) {
    $pqConn = db_connect();
    $id = 0;
    $sql = 'start transaction';

    $result = pg_query($pqConn, $sql);
    if($result) {
        $group = groups_select_by_id($parent_id);
        if($group) {
            $bound = $group->grp_bound_right;
            $sql = 'update cms_groups '
                 . 'set grp_bound_left = grp_bound_left + 2 '
                 . 'where grp_bound_left >= '.$bound;
            $result = pg_query($pqConn, $sql);
            if($result) {
                $sql = 'update cms_groups '
                     . 'set grp_bound_right = grp_bound_right + 2 '
                     . 'where grp_bound_right >= '.$bound;
                $result = pg_query($pqConn, $sql);
                if($result) {
                    $sql = 'insert into cms_groups '
                         . '(grp_bound_left, grp_bound_right, grp_name) '
                         . 'values ('.$bound.', '.($bound + 1).', '.quote_smart($name).') '
                         . 'returning grp_id';
                    $result = pg_query($pqConn, $sql);
                    if($result) {
                        $tmp = pg_fetch_array($result, NULL, PGSQL_ASSOC);
                        $id = $tmp['grp_id'];
                        $sql = 'commit';
                        $result = pg_query($pqConn, $sql);
                    }
                }
            }
        }
    }

    if($id == 0) {
        $sql = 'rollback';
        $result = pg_query($pqConn, $sql);
    }
    pg_freeresult($result);

    return $id;
}

function groups_select_by_id ($id) {
    $pqConn = db_connect();
    $sql  = 'select * from cms_groups '
          . 'where grp_id = '.quote_smart($id);
    $group = null;

    $result = pg_query($pqConn, $sql);
    if ($result) {
        $group = pg_fetch_object($result);
        pg_freeresult($result);
    } else {
        throw new Exception('Can not execute SQL query : '.$sql);
    }

    return $group;
}
?>
