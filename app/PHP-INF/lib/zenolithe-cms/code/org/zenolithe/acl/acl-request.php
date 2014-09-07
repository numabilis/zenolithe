<?php
/*
 *
 * Created on 21 mai 07 by David Jourand
 *
 */

require_once daf_file('zenolithe/acl/acl-serving.daf');

function is_allowed($aro_id, $aro_type, $aco_id, $aco_type, $action) {
  $allowed = false;
  
  $acls = acls_select_hierarchical($aro_id, $aro_type, $aco_id, $aco_type, $action);
  
  if($acls) {
    $allowed = $acls[0]->acl_allowed;
    if($allowed == 'f') {
        $allowed = false;
    }
  }
  
  return $allowed;
}
?>
