<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-3">
  <h4>Expense Heads</h4>
  <a class="btn btn-primary" href="<?= base_url('index.php?r=expense_heads/create') ?>">Add</a>
</div>
<table class="table table-sm table-striped">
  <thead><tr><th>#</th><th>Name</th><th>Description</th><th>Status</th><th></th></tr></thead>
  <tbody>
  <?php foreach ($items as $h): ?>
    <tr>
      <td><?= e($h['id']) ?></td>
      <td><?= e($h['name']) ?></td>
      <td><?= e($h['description']) ?></td>
      <td><?= e($h['status']) ?></td>
      <td class="text-end">
        <a class="btn btn-sm btn-outline-secondary" href="<?= base_url('index.php?r=expense_heads/edit&id=' . $h['id']) ?>">Edit</a>
        <a class="btn btn-sm btn-outline-danger" href="<?= base_url('index.php?r=expense_heads/delete&id=' . $h['id']) ?>" onclick="return confirm('Delete?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </tbody>
</table>
