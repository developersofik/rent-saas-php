<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Buildings</h4>
  <a class="btn btn-primary" href="<?= base_url('index.php?r=buildings/create') ?>">Add</a>
</div>
<table class="table table-sm table-striped">
  <thead><tr><th>#</th><th>Name</th><th>Short</th><th>Address</th><th>Currency</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $b): ?>
    <tr>
      <td><?= e($b['id']) ?></td>
      <td><?= e($b['name']) ?></td>
      <td><?= e($b['short_code']) ?></td>
      <td><?= e($b['address']) ?></td>
      <td><?= e($b['currency']) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('index.php?r=buildings/edit&id=' . $b['id']) ?>">Edit</a>
        <a class="btn btn-sm btn-outline-danger" href="<?= base_url('index.php?r=buildings/delete&id=' . $b['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
