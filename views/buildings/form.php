<?php require_auth(); ?>
<h4><?= isset($item) ? 'Edit' : 'Create' ?> Building</h4>
<form method="post" action="<?= base_url('index.php?r=buildings/' . (isset($item)?'update&id='.$item['id']:'store')) ?>">
  <?php csrf_field() ?>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input class="form-control" name="name" value="<?= e($item['name'] ?? '') ?>" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Short code</label>
      <input class="form-control" name="short_code" value="<?= e($item['short_code'] ?? '') ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Currency</label>
      <input class="form-control" name="currency" value="<?= e($item['currency'] ?? 'BDT') ?>">
    </div>
    <div class="col-12">
      <label class="form-label">Address</label>
      <textarea class="form-control" name="address"><?= e($item['address'] ?? '') ?></textarea>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-light" href="<?= base_url('index.php?r=buildings/index') ?>">Cancel</a>
  </div>
</form>
