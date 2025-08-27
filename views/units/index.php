<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Units</h4>
  <a class="btn btn-primary" href="<?= base_url('index.php?r=units/create') ?>">Add</a>
</div>
<table class="table table-sm table-striped">
  <thead><tr><th>#</th><th>Building</th><th>Unit</th><th>Floor</th><th>Rent</th><th>Status</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $u): ?>
    <tr>
      <td><?= e($u['id']) ?></td>
      <td><?= e($u['building_id']) ?></td>
      <td><?= e($u['unit_no']) ?></td>
      <td><?= e($u['floor']) ?></td>
      <td><?= e($u['base_rent']) ?></td>
      <td><?= e($u['status']) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('index.php?r=units/edit&id=' . $u['id']) ?>">Edit</a>
        <a class="btn btn-sm btn-outline-danger" href="<?= base_url('index.php?r=units/delete&id=' . $u['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
