<template>
  <div class="fee-dashboard">
    <div class="row mb-4">
      <div class="col-md-3">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>{{ stats.total_invoices || 0 }}</h3>
            <p>Total Invoices</p>
          </div>
          <div class="icon">
            <i class="fas fa-file-invoice"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>{{ stats.unpaid_invoices || 0 }}</h3>
            <p>Unpaid Invoices</p>
          </div>
          <div class="icon">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>{{ stats.total_payments || 0 }}</h3>
            <p>Total Payments</p>
          </div>
          <div class="icon">
            <i class="fas fa-money-bill-wave"></i>
          </div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="small-box bg-primary">
          <div class="inner">
            <h3>{{ stats.total_amount || 0 }}</h3>
            <p>Total Amount</p>
          </div>
          <div class="icon">
            <i class="fas fa-dollar-sign"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'FeeDashboard',
  props: {
    stats: { type: Object, default: () => ({}) },
  },
};
</script>
