<?php require_auth(); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="mb-0">Dashboard</h4>
</div>

<div class="row g-3">
  <div class="col-6 col-md-3">
    <div class="card card-kpi p-3 h-100">
      <div class="small text-muted">Total tenants</div>
      <div class="h4 mb-0"><?= e($kpis['tenants'] ?? 0) ?></div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card card-kpi p-3 h-100">
      <div class="small text-muted">Total units</div>
      <div class="h4 mb-0"><?= e($kpis['units'] ?? 0) ?></div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card card-kpi p-3 h-100">
      <div class="small text-muted">Outstanding</div>
      <div class="h4 mb-0">৳ <?= e(number_format($kpis['outstanding'] ?? 0, 0)) ?></div>
    </div>
  </div>
  <div class="col-6 col-md-3">
    <div class="card card-kpi p-3 h-100">
      <div class="small text-muted">Collection (MTD)</div>
      <div class="h4 mb-0">৳ <?= e(number_format($kpis['collection_mtd'] ?? 0, 0)) ?></div>
    </div>
  </div>
</div>

<div class="row g-3 mt-1">
  <div class="col-12 col-lg-8">
    <div class="card p-3 h-100">
      <h6>Product sales</h6>
      <canvas id="salesChart" height="120"></canvas>
    </div>
  </div>
  <div class="col-12 col-lg-4">
    <div class="card p-3 h-100">
      <h6>Sales by product category</h6>
      <canvas id="categoryChart" data-labels='<?= json_encode($categoryData['labels']) ?>' data-values='<?= json_encode($categoryData['values']) ?>' height="180"></canvas>
    </div>
  </div>
</div>

<div class="row g-3 mt-1">
  <div class="col-12 col-lg-6">
    <div class="card p-3 h-100">
      <h6>Latest invoices</h6>
      <ul class="dashboard-list list-unstyled mb-0">
        <?php foreach ($latestInvoices as $inv): ?>
          <li class="d-flex justify-content-between">
            <span><?= e($inv['tenant'] ?? 'Unknown') ?></span>
            <span>৳ <?= e(number_format($inv['amount'] ?? 0, 0)) ?></span>
          </li>
        <?php endforeach; ?>
        <?php if (empty($latestInvoices)): ?>
          <li class="text-muted">No invoices yet</li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
  <div class="col-12 col-lg-6">
    <div class="card p-3 h-100">
      <h6>Sales by countries</h6>
      <div class="ratio ratio-4x3 bg-light d-flex align-items-center justify-content-center text-muted">
        Map placeholder
      </div>
    </div>
  </div>
</div>
