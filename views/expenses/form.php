<?php require_auth(); ?>
<h4><?= isset($item)?'Edit':'Create' ?> Expense</h4>
<form method="post" action="<?= base_url('index.php?r=expenses/' . (isset($item)?'update&id='.$item['id']:'store')) ?>">
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
    <div class="col-md-4">
      <label class="form-label">Expense Head</label>
      <select class="form-select" name="expense_head_id" required>
        <?php foreach($heads as $h): ?>
          <option value="<?= e($h['id']) ?>" <?= isset($item)&&$item['expense_head_id']==$h['id']?'selected':'' ?>><?= e($h['name']) ?></option>
        <?php endforeach; ?>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Amount</label>
      <input class="form-control" name="amount" value="<?= e($item['amount'] ?? '') ?>" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Date</label>
      <input type="date" class="form-control" name="date" value="<?= e($item['date'] ?? '') ?>" required>
    </div>
    <div class="col-12">
      <label class="form-label">Notes</label>
      <textarea class="form-control" name="notes"><?= e($item['notes'] ?? '') ?></textarea>
    </div>
  </div>
  <div class="mt-3">
    <button class="btn btn-primary">Save</button>
    <a class="btn btn-light" href="<?= base_url('index.php?r=expenses/index') ?>">Cancel</a>
  </div>
</form>
