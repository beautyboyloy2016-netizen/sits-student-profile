@extends('admin.layouts.master_layout')

@section('pageTitle', 'Edit Invoice - Student Profile Management')

@section('content')
  <div class="row">
    <div class="col-md-12">
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Edit Invoice <small class="text-muted">{{ $invoice->invoice_no }}</small></h3>
        </div>
        <div class="card-body" id="app">
          <form action="{{ route('fees.invoices.update', $invoice->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label>Student <span class="text-danger">*</span></label>
                  <select name="student_id" class="form-control tom-select" required>
                    <option value="">Select Student</option>
                    @foreach ($students as $student)
                      <option value="{{ $student->id }}"
                        {{ old('student_id', $invoice->student_id) == $student->id ? 'selected' : '' }}>
                        {{ $student->student_code }} - {{ $student->khmer_name }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Invoice Date <span class="text-danger">*</span></label>
                  <input type="text" name="invoice_date" class="form-control flatpickr"
                    value="{{ old('invoice_date', $invoice->invoice_date?->format('Y-m-d')) }}" required>
                </div>
              </div>
              <div class="col-md-3">
                <div class="form-group">
                  <label>Due Date</label>
                  <input type="text" name="due_date" class="form-control flatpickr"
                    value="{{ old('due_date', $invoice->due_date?->format('Y-m-d')) }}">
                </div>
              </div>
            </div>

            <h5>Invoice Items</h5>
            <table class="table table-bordered" id="invoiceItemsTable">
              <thead>
                <tr>
                  <th>Fee Type</th>
                  <th>Description</th>
                  <th>Qty</th>
                  <th>Unit Price</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                @forelse($invoice->items as $idx => $item)
                  <tr class="item-row">
                    <td>
                      <select name="items[{{ $idx }}][fee_type_id]" class="form-control fee-type-select">
                        <option value="">Select</option>
                        @foreach ($feeTypes as $feeType)
                          <option value="{{ $feeType->id }}" data-amount="{{ $feeType->amount }}"
                            {{ $item->fee_type_id == $feeType->id ? 'selected' : '' }}>{{ $feeType->name }}</option>
                        @endforeach
                      </select>
                    </td>
                    <td><input type="text" name="items[{{ $idx }}][description]" class="form-control"
                        value="{{ $item->description }}"></td>
                    <td><input type="number" name="items[{{ $idx }}][qty]" class="form-control qty"
                        value="{{ $item->qty }}" min="1"></td>
                    <td><input type="number" name="items[{{ $idx }}][unit_price]"
                        class="form-control unit-price" step="0.01" value="{{ $item->unit_price }}"></td>
                    <td class="row-total">{{ number_format($item->qty * $item->unit_price, 2) }}</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i
                          class="fas fa-trash"></i></button></td>
                  </tr>
                @empty
                  <tr class="item-row">
                    <td>
                      <select name="items[0][fee_type_id]" class="form-control fee-type-select">
                        <option value="">Select</option>
                        @foreach ($feeTypes as $feeType)
                          <option value="{{ $feeType->id }}" data-amount="{{ $feeType->amount }}">{{ $feeType->name }}
                          </option>
                        @endforeach
                      </select>
                    </td>
                    <td><input type="text" name="items[0][description]" class="form-control"></td>
                    <td><input type="number" name="items[0][qty]" class="form-control qty" value="1" min="1">
                    </td>
                    <td><input type="number" name="items[0][unit_price]" class="form-control unit-price" step="0.01"
                        value="0"></td>
                    <td class="row-total">0.00</td>
                    <td><button type="button" class="btn btn-danger btn-sm remove-row"><i
                          class="fas fa-trash"></i></button></td>
                  </tr>
                @endforelse
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6">
                    <button type="button" class="btn btn-success btn-sm" id="addItemRow"><i class="fas fa-plus"></i> Add
                      Item</button>
                  </td>
                </tr>
              </tfoot>
            </table>

            <div class="row">
              <div class="col-md-6 offset-md-6">
                <table class="table table-bordered">
                  <tr>
                    <th>Grand Total</th>
                    <td id="grandTotal">{{ number_format($invoice->total_amount, 2) }}</td>
                  </tr>
                </table>
              </div>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Invoice</button>
              <a href="{{ route('fees.invoices') }}" class="btn btn-secondary">Cancel</a>
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
        window.flatpickr(el, {
          dateFormat: 'Y-m-d'
        });
      });
      document.querySelectorAll('.tom-select').forEach(function(el) {
        new window.TomSelect(el, {
          create: false
        });
      });

      let rowIndex = {{ $invoice->items->count() ?: 1 }};

      function updateTotals() {
        let grand = 0;
        document.querySelectorAll('.item-row').forEach(function(row) {
          const qty = parseFloat(row.querySelector('.qty').value) || 0;
          const price = parseFloat(row.querySelector('.unit-price').value) || 0;
          const total = qty * price;
          row.querySelector('.row-total').textContent = total.toFixed(2);
          grand += total;
        });
        document.getElementById('grandTotal').textContent = grand.toFixed(2);
      }

      document.getElementById('addItemRow').addEventListener('click', function() {
        const tbody = document.querySelector('#invoiceItemsTable tbody');
        const row = tbody.querySelector('.item-row').cloneNode(true);
        row.querySelectorAll('input, select').forEach(function(el) {
          el.name = el.name.replace(/\[\d+\]/, '[' + rowIndex + ']');
          if (el.tagName === 'INPUT') el.value = '';
          if (el.classList.contains('qty')) el.value = '1';
          if (el.classList.contains('unit-price')) el.value = '0';
        });
        row.querySelector('.row-total').textContent = '0.00';
        tbody.appendChild(row);
        rowIndex++;
        bindRowEvents(row);
        updateTotals();
      });

      function bindRowEvents(row) {
        row.querySelector('.remove-row').addEventListener('click', function() {
          if (document.querySelectorAll('.item-row').length > 1) {
            row.remove();
            updateTotals();
          }
        });
        row.querySelectorAll('.qty, .unit-price').forEach(function(el) {
          el.addEventListener('input', updateTotals);
        });
        const feeSelect = row.querySelector('.fee-type-select');
        if (feeSelect) {
          feeSelect.addEventListener('change', function() {
            const opt = this.options[this.selectedIndex];
            if (opt && opt.dataset.amount) {
              row.querySelector('.unit-price').value = opt.dataset.amount;
              updateTotals();
            }
          });
        }
      }

      document.querySelectorAll('.item-row').forEach(bindRowEvents);
    });
  </script>
@endpush
