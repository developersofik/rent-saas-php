<?php require_auth(); ?>
<h4><?= isset($item)?'Edit':'Create' ?> Income Head</h4>
<form method="post" action="<?= base_url('index.php?r=income_heads/' . (isset($item)?'update&id='.$item['id']:'store')) ?>">
  <?php csrf_field() ?>
  <div class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Name</label>
      <input class="form-control" name="name" value="<?= e($item['name'] ?? '') ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Status</label>
      <select class="form-select" name="status">
        <?php foreach(['active','inactive'] as $s): ?>
          <option value="<?= $s ?>" <?= isset($item)&&$item['status']==$s?'selected':'' ?>><?= ucfirst($s) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-12">
      <label class="form-label">Description</label>
      <textarea class="form-control" name="description"><?= e($item['description'] ?? '') ?></textarea>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-light" href="<?= base_url('index.php?r=income_heads/index') ?>">Cancel</a>
  </div>
</form>
