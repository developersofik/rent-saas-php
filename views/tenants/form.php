<?php require_auth(); ?>
<h4><?= isset($item) ? 'Edit' : 'Create' ?> Tenant</h4>
<form method="post" action="<?= base_url('index.php?r=tenants/' . (isset($item)?'update&id='.$item['id']:'store')) ?>">
  <?php csrf_field() ?>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input class="form-control" name="name" value="<?= e($item['name'] ?? '') ?>" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Phone</label>
      <input class="form-control" name="phone" value="<?= e($item['phone'] ?? '') ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Email</label>
      <input type="email" class="form-control" name="email" value="<?= e($item['email'] ?? '') ?>">
    </div>
    <div class="col-12">
      <label class="form-label">Address</label>
      <textarea class="form-control" name="address"><?= e($item['address'] ?? '') ?></textarea>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-light" href="<?= base_url('index.php?r=tenants/index') ?>">Cancel</a>
  </div>
</form>
