@extends('layouts.customer.app')
@section('title', 'Interested Vendors')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css"/>

<style>
  body {
    font-family: 'Inter', sans-serif;
    background-color: #f8f9fb;
  }
  .heading-bar {
    border-left: 6px solid #f25c05;
    background-color: #fff;
    padding: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    margin-bottom: 20px;
  }
  .heading-bar h3 {
    color: #1c2c3e;
    font-weight: 600;
  }
  .btn-primary, .btn-outline-primary:hover {
    background-color: #f25c05 !important;
    border-color: #f25c05 !important;
  }
  .btn-outline-primary {
    color: #f25c05 !important;
    border-color: #f25c05 !important;
  }
  .btn-outline-primary:hover {
    color: #fff !important;
  }
  .table thead {
    background-color: #f2f4f7;
  }
  .table th {
    color: #1c2c3e;
    font-weight: 600;
  }
</style>

<div class="heading-bar">
  <div class="d-flex justify-content-between align-items-center">
    <h3>🔍 Interested Vendors</h3>
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary"><i class="bi bi-arrow-left"></i> Back</a>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <form id="filterForm" class="row g-3 mb-4">
      <div class="col-md-4">
        <label class="form-label fw-semibold">Project Name</label>
        <input type="text" name="project_name" class="form-control" placeholder="e.g. Residential">
      </div>
      <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-50 me-2">🔎 Filter</button>
        <button type="button" id="resetBtn" class="btn btn-outline-secondary w-50">♻️ Reset</button>
      </div>
    </form>

    <div class="table-responsive">
      <table id="projectsTable" class="table table-hover table-bordered align-middle">
        <thead>
          <tr>
            <th>📌 Project Name (ID)</th>
            <th>💰 Customer Budget</th>
            <th>⏱️ Location</th>
            <th>👁️ Actions</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>
</div>

<!-- Tender Modal -->
<div class="modal fade" id="tenderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title text-[#1c2c3e]">Tender Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="tenderModalBody">
        <div class="text-center text-muted">Loading...</div>
      </div>
    </div>
  </div>
</div>

<!-- Vendor Select Modal -->
<div class="modal fade" id="vendorSelectModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-light">
        <h5 class="modal-title text-[#1c2c3e]">Tender Documents</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="vendorSelectModalBody">
        <div class="text-center text-muted">Loading...</div>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function () {
    const table = $('#projectsTable').DataTable({
      processing: true,
      serverSide: true,
      ajax: {
        url: "{{ route('vendor.details.data') }}",
        data: d => {
          d.project_name = $('input[name=project_name]').val();
        }
      },
      columns: [
        {
          data: null, name: 'project_name',
          render: data => `${data.project_name} (${data.submission_id})`
        },
        { data: 'budget_range', name: 'budget_range' },
        { data: 'project_location', name: 'project_location' },
        {
          data: 'view', name: 'view',
          render: (data, type, row) => `
            <button class="btn btn-sm btn-outline-primary view-tender-btn" data-project-id="${row.id}">👁️</button>
            <button class="btn btn-sm btn-outline-success vendor-select-btn" data-project-id="${row.id}">✅ Select</button>`
        }
      ]
    });

    $('#filterForm').submit(function (e) {
      e.preventDefault();
      table.draw();
    });

    $('#resetBtn').click(function () {
      $('#filterForm')[0].reset();
      table.draw();
    });

    // View Tender
    $(document).on('click', '.view-tender-btn', function () {
      const id = $(this).data('project-id');
      $('#tenderModal').modal('show');
      $('#tenderModalBody').html('Loading...');
      $.get("{{ route('vendor.tender.details') }}", { project_id: id }, res => {
        if (res.status === 'success') {
          let html = `<table class="table table-bordered"><thead><tr>
            <th>ID</th><th>Value</th><th>Category</th><th>Sub</th><th>Type</th><th>Location</th><th>Dates</th>
          </tr></thead><tbody>`;
          res.data.forEach(t => {
            html += `<tr>
              <td>${t.id}</td>
              <td>₹${parseFloat(t.tender_value).toLocaleString()}</td>
              <td>${t.product_category}</td>
              <td>${t.sub_category}</td>
              <td>${t.contract_type}</td>
              <td>${t.location} - ${t.pincode}</td>
              <td>Start: ${t.bid_submission_start}<br>End: ${t.bid_submission_end}</td>
            </tr>`;
          });
          html += '</tbody></table>';
          $('#tenderModalBody').html(html);
        } else {
          $('#tenderModalBody').html('<div class="text-danger">' + res.message + '</div>');
        }
      });
    });

    // Vendor Select
    $(document).on('click', '.vendor-select-btn', function () {
      const id = $(this).data('project-id');
      $('#vendorSelectModal').modal('show');
      $('#vendorSelectModalBody').html('Loading...');
      $.get("{{ route('vendor.tender.documents') }}", { project_id: id }, res => {
        if (res.status === 'success') {
          let html = `<table class="table table-bordered"><thead>
            <tr><th>ID</th><th>File</th><th>Vendor</th><th>Cost</th><th>Action</th></tr>
          </thead><tbody>`;
          res.data.forEach(doc => {
            html += `<tr>
              <td>${doc.id}</td>
              <td>${doc.file_name}</td>
              <td>${doc.vendor_id}</td>
              <td>₹${parseFloat(doc.vendor_cost).toLocaleString()}</td>
              <td>
                <a href="${doc.document_url}" target="_blank" class="btn btn-sm btn-outline-secondary">📥</a>
                <input type="checkbox" class="form-check-input select-vendor-checkbox"
                       data-doc-id="${doc.id}" data-project-id="${id}" data-vendor-id="${doc.vendor_id}">
              </td>
            </tr>`;
          });
          html += '</tbody></table>';
          $('#vendorSelectModalBody').html(html);
        } else {
          $('#vendorSelectModalBody').html('<div class="text-danger">' + res.message + '</div>');
        }
      });
    });

    // Select Vendor Logic
    $(document).on('change', '.select-vendor-checkbox', function () {
      const cb = $(this);
      const docId = cb.data('doc-id');
      const vendorId = cb.data('vendor-id');
      const projectId = cb.data('project-id');

      if (cb.is(':checked') && confirm("Do you want to select this vendor?")) {
        $.post("{{ route('vendor.select') }}", {
          _token: $('meta[name="csrf-token"]').attr('content'),
          project_id: projectId,
          vendor_id: vendorId,
          document_id: docId
        }, res => {
          alert(res.message || "Vendor selected.");
        }).fail(() => {
          alert("Failed to save selection.");
          cb.prop('checked', false);
        });
      } else {
        cb.prop('checked', false);
      }
    });

  });
</script>
@endsection
