<?php require_auth(); ?>
<h4><?= isset($item)?'Edit':'Create' ?> Lease</h4>
<form method="post" action="<?= base_url('index.php?r=leases/' . (isset($item)?'update&id='.$item['id']:'store')) ?>">
  <?php csrf_field() ?>
  <div class="row g-3">
    <div class="col-md-3">
      <label class="form-label">Lease No</label>
      <input class="form-control" name="lease_no" value="<?= e($item['lease_no'] ?? '') ?>" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">Tenant</label>
      <select class="form-select" name="tenant_id" required>
        <?php foreach($tenants as $t): ?>
          <option value="<?= e($t['id']) ?>" <?= isset($item)&&$item['tenant_id']==$t['id']?'selected':'' ?>><?= e($t['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Unit</label>
      <select class="form-select" name="unit_id" required>
        <?php foreach($units as $u): ?>
          <option value="<?= e($u['id']) ?>" <?= isset($item)&&$item['unit_id']==$u['id']?'selected':'' ?>><?= e($u['unit_no']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-3">
      <label class="form-label">Deposit</label>
      <input class="form-control" name="deposit" value="<?= e($item['deposit'] ?? '') ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Start Date</label>
      <input type="date" class="form-control" name="start_date" value="<?= e($item['start_date'] ?? '') ?>" required>
    </div>
    <div class="col-md-3">
      <label class="form-label">End Date</label>
      <input type="date" class="form-control" name="end_date" value="<?= e($item['end_date'] ?? '') ?>">
    </div>
    <div class="col-md-3">
      <label class="form-label">Status</label>
      <select class="form-select" name="status">
        <?php foreach(['active','ended','paused'] as $s): ?>
          <option value="<?= $s ?>" <?= isset($item)&&$item['status']==$s?'selected':'' ?>><?= ucfirst($s) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-light" href="<?= base_url('index.php?r=leases/index') ?>">Cancel</a>
  </div>
</form>
