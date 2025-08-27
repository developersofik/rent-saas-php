<?php
require_once __DIR__ . '/../config/helpers.php';
require_once __DIR__ . '/../config/auth.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
  public function login() {
    view('auth/login');
  }
  public function doLogin() {
    verify_csrf();
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    if (attempt_login($email, $password)) {
      redirect('index.php');
    } else {
      flash('error','Invalid credentials');
      redirect('index.php?r=auth/login');
    }
  }
  public function logout() {
    logout();
    redirect('index.php?r=auth/login');
  }
}
