@extends('admin.layouts.master_layout')

@section('pageTitle', 'Record Payment - Student Profile Management')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Record Payment</h3>
        </div>
        <div class="card-body" id="app">
          <form action="{{ route('fees.payments.store') }}" method="POST">
            @csrf
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Student <span class="text-danger">*</span></label>
                  <select name="student_id" class="form-control tom-select" required>
                    <option value="">Select Student</option>
                    @foreach($students as $student)
                      <option value="{{ $student->id }}" {{ old('student_id') == $student->id ? 'selected' : '' }}>{{ $student->student_code }} - {{ $student->khmer_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label>Invoice (optional)</label>
                  <select name="invoice_id" class="form-control tom-select">
                    <option value="">Select Invoice</option>
                    @foreach($invoices as $invoice)
                      <option value="{{ $invoice->id }}" {{ old('invoice_id') == $invoice->id ? 'selected' : '' }}>{{ $invoice->invoice_no }} - {{ $invoice->student->khmer_name ?? '' }} (Balance: {{ number_format($invoice->balance, 2) }})</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Payment Date <span class="text-danger">*</span></label>
                  <input type="text" name="payment_date" class="form-control flatpickr" value="{{ old('payment_date', now()->format('Y-m-d')) }}" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Amount <span class="text-danger">*</span></label>
                  <input type="number" name="amount" class="form-control" step="0.01" min="0.01" value="{{ old('amount') }}" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Payment Method <span class="text-danger">*</span></label>
                  <select name="payment_method" class="form-control" required>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                    <option value="bank" {{ old('payment_method') == 'bank' ? 'selected' : '' }}>Bank</option>
                    <option value="aba" {{ old('payment_method') == 'aba' ? 'selected' : '' }}>ABA</option>
                    <option value="wing" {{ old('payment_method') == 'wing' ? 'selected' : '' }}>Wing</option>
                    <option value="other" {{ old('payment_method') == 'other' ? 'selected' : '' }}>Other</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label>Note</label>
              <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Record Payment</button>
              <a href="{{ route('fees.payments') }}" class="btn btn-secondary">Cancel</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.flatpickr').forEach(function(el) {
    window.flatpickr(el, { dateFormat: 'Y-m-d' });
  });
  document.querySelectorAll('.tom-select').forEach(function(el) {
    new window.TomSelect(el, { create: false });
  });
});
</script>
@endpush
