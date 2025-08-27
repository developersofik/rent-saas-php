<?php require_auth(); ?>
<h4>মাসিক সংগ্রহ শীট</h4>
<form class="row g-2 mb-3" method="get" action="">
  <input type="hidden" name="r" value="reports/monthly">
  <div class="col-md-3">
    <select class="form-select" name="building_id">
      <option value="">বিল্ডিং</option>
      <?php foreach($buildings as $b): ?>
        <option value="<?= e($b['id']) ?>" <?= $building_id==$b['id']?'selected':'' ?>><?= e($b['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3">
    <input type="month" class="form-control" name="month" value="<?= e($month) ?>">
  </div>
  <div class="col-md-3">
    <select class="form-select" name="status">
      <option value="">স্ট্যাটাস</option>
      <?php foreach(['unpaid','part-paid','paid'] as $s): ?>
        <option value="<?= $s ?>" <?= $status==$s?'selected':'' ?>><?= $s ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="col-md-3">
    <button class="btn btn-primary">ফিল্টার</button>
    <button type="button" class="btn btn-secondary no-print" onclick="window.print()">প্রিন্ট</button>
  </div>
</form>
<table class="table table-sm table-bordered">
  <thead><tr><th>ক্রম</th><th>ভাড়াটিয়া/ইউনিট</th><th>মোট</th><th>পরিশোধ</th><th>বকেয়া</th></tr></thead>
  <tbody>
    <?php foreach ($items as $idx=>$it): $paid=$it['status']=='paid'?$it['totals_json']['grand_total']??0:0; ?>
    <tr>
      <td><?= $idx+1 ?></td>
      <td><?= e($it['tenant'].' / '.$it['unit_no']) ?></td>
      <td><?= e($it['totals_json']['grand_total'] ?? 0) ?></td>
      <td><?= e($paid) ?></td>
      <td><?= e(($it['totals_json']['grand_total'] ?? 0) - $paid) ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
