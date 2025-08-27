<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Leases</h4>
  <a class="btn btn-primary" href="<?= base_url('index.php?r=leases/create') ?>">Add</a>
</div>
<table class="table table-sm table-striped">
  <thead><tr><th>#</th><th>Lease No</th><th>Tenant</th><th>Unit</th><th>Start</th><th>End</th><th>Status</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $l): ?>
    <tr>
      <td><?= e($l['id']) ?></td>
      <td><?= e($l['lease_no']) ?></td>
      <td><?= e($l['tenant_id']) ?></td>
      <td><?= e($l['unit_id']) ?></td>
      <td><?= e($l['start_date']) ?></td>
      <td><?= e($l['end_date']) ?></td>
      <td><?= e($l['status']) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('index.php?r=leases/edit&id=' . $l['id']) ?>">Edit</a>
        <a class="btn btn-sm btn-outline-danger" href="<?= base_url('index.php?r=leases/delete&id=' . $l['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
