<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Tenants</h4>
  <a class="btn btn-primary" href="<?= base_url('index.php?r=tenants/create') ?>">Add</a>
</div>
<table class="table table-sm table-striped">
  <thead><tr><th>#</th><th>Name</th><th>Phone</th><th>Email</th><th>Address</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $t): ?>
    <tr>
      <td><?= e($t['id']) ?></td>
      <td><?= e($t['name']) ?></td>
      <td><?= e($t['phone']) ?></td>
      <td><?= e($t['email']) ?></td>
      <td><?= e($t['address']) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('index.php?r=tenants/edit&id=' . $t['id']) ?>">Edit</a>
        <a class="btn btn-sm btn-outline-danger" href="<?= base_url('index.php?r=tenants/delete&id=' . $t['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
