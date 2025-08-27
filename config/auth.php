<?php
require_once __DIR__ . '/database.php';

function current_user() {
  return $_SESSION['user'] ?? null;
}
function require_auth() {
  if (!current_user()) {
    redirect('index.php?r=auth/login');
  }
}
function attempt_login($email, $password) {
  $stmt = db()->prepare("SELECT * FROM users WHERE email=? AND status='active' LIMIT 1");
  $stmt->execute([$email]);
  $user = $stmt->fetch();
  if ($user && password_verify($password, $user['password_hash'])) {
    $_SESSION['user'] = [
      'id' => $user['id'],
      'name' => $user['name'],
      'email' => $user['email'],
      'role' => $user['role'],
    ];
    return true;
  }
  return false;
}
function logout() {
  unset($_SESSION['user']);
}
function is_admin() {
  return (current_user()['role'] ?? null) === 'ADMIN';
}
function has_role($roles){
  $user=current_user();
  if(!$user) return false;
  $roles=(array)$roles;
  return in_array($user['role'],$roles);
}
function require_role($roles){
  if(!has_role($roles)){
    http_response_code(403);
    die('Forbidden');
  }
}
