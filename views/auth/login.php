<div class="container" style="max-width:480px;">
  <div class="card shadow-sm mt-5">
    <div class="card-body">
      <h5 class="mb-3">Login</h5>
      <?php if ($m = flash('error')): ?>
        <div class="alert alert-danger"><?= e($m) ?></div>
      <?php endif; ?>
      <form method="post" action="<?= base_url('index.php?r=auth/doLogin') ?>">
        <?php csrf_field() ?>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" required>
        </div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" required>
        </div>
        <button class="btn btn-primary w-100">Login</button>
      </form>
    </div>
  </div>
</div>
