<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$config = require __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../config/helpers.php';
require_once __DIR__ . '/../../config/auth.php';
?>
<!DOCTYPE html>
<html lang="bn">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= e($config['app_name']) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
  <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<div class="d-flex">
  <aside class="sidebar p-3">
    <div class="brand mb-4"><?= e($config['app_name']) ?></div>
    <div class="list-group list-unstyled">
      <a class="nav-link d-block py-2 px-3 <?= (($_GET['r'] ?? '') == '' || strpos($_GET['r'],'dashboard')===0) ? 'active':'' ?>" href="<?= base_url('index.php') ?>">Dashboard</a>
      <?php if (has_role(['ADMIN','MANAGER'])): ?>
      <small class="text-muted d-block mt-3 mb-1">Management</small>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','buildings')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=buildings/index') ?>">Buildings</a>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','units')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=units/index') ?>">Units</a>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','tenants')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=tenants/index') ?>">Tenants</a>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','leases')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=leases/index') ?>">Leases</a>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','invoices')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=invoices/index') ?>">Invoices</a>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','payments')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=payments/index') ?>">Payments</a>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','expense_heads')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=expense_heads/index') ?>">Expense Heads</a>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','expenses')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=expenses/index') ?>">Expenses</a>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','reports')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=reports/monthly') ?>">Reports</a>
      <?php endif; ?>
      <small class="text-muted d-block mt-3 mb-1">System</small>
      <?php if (has_role(['ADMIN'])): ?>
      <a class="nav-link d-block py-2 px-3 <?= (strpos($_GET['r'] ?? '','users')===0) ? 'active':'' ?>" href="<?= base_url('index.php?r=users/index') ?>">Users</a>
      <?php endif; ?>
      <?php if (current_user()): ?>
        <a class="nav-link d-block py-2 px-3" href="<?= base_url('index.php?r=auth/logout') ?>">Logout (<?= e(current_user()['name'] ?? '') ?>)</a>
      <?php else: ?>
        <a class="nav-link d-block py-2 px-3" href="<?= base_url('index.php?r=auth/login') ?>">Login</a>
      <?php endif; ?>
    </div>
  </aside>
  <main class="content w-100">
