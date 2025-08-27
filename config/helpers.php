<?php
function base_url($path = '') {
  $config = require __DIR__ . '/config.php';
  $base = rtrim($config['base_url'], '/');
  return $base . '/' . ltrim($path, '/');
}
function redirect($path) {
  header('Location: ' . base_url($path));
  exit;
}
function view($file, $vars = []) {
  extract($vars);
  require __DIR__ . '/../views/partials/header.php';
  require __DIR__ . '/../views/' . $file . '.php';
  require __DIR__ . '/../views/partials/footer.php';
}
function csrf_token() {
  if (empty($_SESSION['_csrf'])) {
    $_SESSION['_csrf'] = bin2hex(random_bytes(16));
  }
  return $_SESSION['_csrf'];
}
function csrf_field() {
  echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(csrf_token()) . '">';
}
function verify_csrf() {
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['_csrf']) || $_POST['_csrf'] !== ($_SESSION['_csrf'] ?? '')) {
      http_response_code(419);
      die('CSRF token mismatch');
    }
  }
}
function flash($key, $message = null) {
  if ($message !== null) {
    $_SESSION['flash'][$key] = $message;
    return;
  }
  $msg = $_SESSION['flash'][$key] ?? null;
  unset($_SESSION['flash'][$key]);
  return $msg;
}
function e($v) { return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
