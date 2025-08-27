<?php
require_once __DIR__ . '/../models/AuditLog.php';
require_once __DIR__ . '/auth.php';
function audit_log($action,$entity,$entity_id,$diff){
  $log = new AuditLog();
  $log->insert([
    'user_id' => current_user()['id'] ?? null,
    'action' => $action,
    'entity' => $entity,
    'entity_id' => $entity_id,
    'diff_json' => json_encode($diff),
    'created_at' => date('Y-m-d H:i:s')
  ]);
}
