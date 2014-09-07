<?php
/*
 *
 * Created on 16 mai 07 by David Jourand
 *
 */

require daf_file('zenolithe/acl/acl-admin.daf');

function allow($aro_id, $aro_type, $aco_id, $aco_type, $action) {
  $acl = acls_select($aro_id, $aro_type, $aco_id, $aco_type, $action);
  if($acl) {
    acls_update($acl['acl_id'], true);
  } else {
    acls_create($aro_id, $aro_type, $aco_id, $aco_type, $action, true);
  }
}

function deny($aro_id, $aro_type, $aco_id, $aco_type, $action) {
  $acl = acls_select($aro_id, $aro_type, $aco_id, $aco_type, $action);
  if($acl) {
    acls_update($acl['acl_id'], 'false');
  } else {
    acls_create($aro_id, $aro_type, $aco_id, $aco_type, $action, 'false');
  }
}
?>
