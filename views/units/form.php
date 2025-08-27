<?php require_auth(); ?>
<h4><?= isset($item)?'Edit':'Create' ?> Unit</h4>
<form method="post" action="<?= base_url('index.php?r=units/' . (isset($item)?'update&id='.$item['id']:'store')) ?>">
  <?php csrf_field() ?>
  <div class="row g-3">
    <div class="col-md-4">
      <label class="form-label">Building</label>
      <select class="form-select" name="building_id" required>
        <?php foreach($buildings as $b): ?>
          <option value="<?= e($b['id']) ?>" <?= isset($item)&&$item['building_id']==$b['id']?'selected':'' ?>><?= e($b['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-2">
      <label class="form-label">Unit No</label>
      <input class="form-control" name="unit_no" value="<?= e($item['unit_no'] ?? '') ?>" required>
    </div>
    <div class="col-md-2">
      <label class="form-label">Floor</label>
      <input class="form-control" name="floor" value="<?= e($item['floor'] ?? '') ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label">Base Rent</label>
      <input class="form-control" name="base_rent" value="<?= e($item['base_rent'] ?? '') ?>">
    </div>
    <div class="col-md-2">
      <label class="form-label">Status</label>
      <select class="form-select" name="status">
        <?php foreach(['vacant','occupied','maintenance'] as $s): ?>
          <option value="<?= $s ?>" <?= (isset($item)&&$item['status']==$s)?'selected':'' ?>><?= ucfirst($s) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
  </div>
  <div class="row g-3 mt-2">
    <div class="col-md-4">
      <label class="form-label">Electric Meter</label>
      <input class="form-control" name="meter_number_electric" value="<?= e($item['meter_number_electric'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Water Meter</label>
      <input class="form-control" name="meter_number_water" value="<?= e($item['meter_number_water'] ?? '') ?>">
    </div>
    <div class="col-md-4">
      <label class="form-label">Gas Meter</label>
      <input class="form-control" name="meter_number_gas" value="<?= e($item['meter_number_gas'] ?? '') ?>">
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-light" href="<?= base_url('index.php?r=units/index') ?>">Cancel</a>
  </div>
</form>
