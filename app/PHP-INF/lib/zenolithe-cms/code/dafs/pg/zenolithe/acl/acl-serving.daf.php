<?php
/*
 *
 * Created on 21 mai 07 by David Jourand
 *
 */

function acls_select_hierarchical ($aro_id, $aro_type, $aco_id, $aco_type, $action) {
  $pqConn = db_connect();
  $sql  = 'select distinct cms_acls.* from cms_acls, cms_groups A, cms_groups B, cms_aro_groups '
        . 'where '
          .'('
            .'cms_aro_groups.acl_aro_id = '.quote_smart($aro_id).' '
            .'and cms_aro_groups.acl_aro_type = '.quote_smart($aro_type).' '
            .'and A.grp_id = cms_aro_groups.grp_id '
            .'and B.grp_bound_left <= A.grp_bound_left '
            .'and B.grp_bound_right >= A.grp_bound_right '
            .'and cms_acls.acl_aro_id = B.grp_id '
            .'and cms_acls.acl_aro_type = '.ARO_TYPE_GROUP
          .') '
          .'and '
          .'('
             .'cms_acls.acl_aco_id = 0 '
             .'or '
             .'cms_acls.acl_aco_id = '.quote_smart($aco_id)
          .') '
          .'and cms_acls.acl_aco_type = '.quote_smart($aco_type).' '
          .'and cms_acls.acl_action = '.quote_smart($action).' '
        . 'union '
        . 'select distinct cms_acls.* from cms_acls '
        . 'where '
          .'('
            .'cms_acls.acl_aro_id = '.quote_smart($aro_id).' '
            .'and cms_acls.acl_aro_type = '.quote_smart($aro_type)
          .') '
          .'and '
          .'('
             .'cms_acls.acl_aco_id = 0 '
             .'or '
             .'cms_acls.acl_aco_id = '.quote_smart($aco_id)
          .') '
          .'and cms_acls.acl_aco_type = '.quote_smart($aco_type).' '
          .'and cms_acls.acl_action = '.quote_smart($action).' '
          .'order by acl_aco_id desc, acl_aro_type desc';
  $acls = array();
  
  $result = pg_query($pqConn, $sql);
  if ($result) {
    while ($row = pg_fetch_object($result)) {
      $acls[] = $row;
    }
    pg_freeresult($result);
  } else {
    throw new Exception('Can not execute SQL query : '.$sql);
  }
	
  return $acls;
}
?>
