<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Explore Projects</title>

  <!-- Fonts & CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css"/>

  <style>
    body {
      font-family: 'Inter', sans-serif;
    }
    .table td, .table th {
      vertical-align: middle;
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-5">
  <div class="card shadow-sm">
    <div class="card-body">
      <div class="text-end mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Back
        </a>
      </div>
      <h3 class="mb-4 text-primary">🔍 Interested Vendor</h3>
      <form id="filterForm" class="row g-3 mb-4">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Project Name</label>
          <input type="text" name="project_name" class="form-control" placeholder="e.g. Residential">
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <button type="submit" class="btn btn-primary me-2 w-50">🔎 Filter</button>
          <button type="button" id="resetBtn" class="btn btn-outline-secondary w-50">♻️ Reset</button>
        </div>
      </form>
      <div class="table-responsive">
        <table id="projectsTable" class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>📌 Project Name (ID)</th>
              <th>💰 Customer Budget</th>
              <th>⏱️ Project Location</th>
              <th>👁️ Views</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Tender Modal -->
<div class="modal fade" id="tenderModal" tabindex="-1" aria-labelledby="tenderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tender Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="tenderModalBody">
        <div class="text-center text-muted">Loading...</div>
      </div>
    </div>
  </div>
</div>


<!-- Tender Documents Modal -->
<div class="modal fade" id="vendorSelectModal" tabindex="-1" aria-labelledby="vendorSelectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Tender Documents</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="vendorSelectModalBody">
        <div class="text-center text-muted">Loading...</div>
      </div>
    </div>
  </div>
</div>

<!-- JS Dependencies -->
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
        data: function (d) {
          d.project_name = $('input[name=project_name]').val();
        },
        error: function (xhr) {
          console.error("AJAX Error:", xhr.responseText);
        }
      },
      columns: [
        {
          data: null,
          name: 'project_name',
          render: function (data, type, row) {
            return `${row.project_name} (${row.submission_id})`;
          }
        },
        { data: 'budget_range', name: 'budget_range' },
        { data: 'project_location', name: 'project_location' },
        {
          data: 'view',
          name: 'view',
          render: function (data, type, row) {
            return `<button class="btn btn-sm btn-outline-primary view-tender-btn" data-project-id="${row.id}">
                      👁️ 
                    </button>
                    <button class="btn btn-sm btn-outline-success vendor-select-btn" data-project-id="${row.id}">
                        ✅ Vendor Select
                    </button>`;
          }
        }
      ]
    });

    $('#filterForm').on('submit', function (e) {
      e.preventDefault();
      table.draw();
    });

    $('#resetBtn').on('click', function () {
      $('#filterForm')[0].reset();
      table.draw();
    });

    // AJAX modal load
    $(document).on('click', '.view-tender-btn', function () {
      const projectId = $(this).data('project-id');

      $('#tenderModalBody').html('<div class="text-center text-muted">Loading...</div>');
      $('#tenderModal').modal('show');

      $.ajax({
        url: "{{ route('vendor.tender.details') }}",
        method: 'GET',
        data: { project_id: projectId },
        success: function (response) {
          if (response.status === 'success') {
            const tenders = response.data;
            let html = '<table class="table table-bordered"><thead><tr>';
            html += `
              <th>ID</th>
              
              <th>Tender Value</th>
              <th>Category</th>
              <th>Sub Category</th>
              <th>Contract Type</th>
              <th>Location</th>
              <th>Bid Dates</th>
            </tr></thead><tbody>`;

            tenders.forEach(tender => {
              html += `
                <tr>
                  <td>${tender.id}</td>
                  
                  <td>₹${parseFloat(tender.tender_value).toLocaleString()}</td>
                  <td>${tender.product_category}</td>
                  <td>${tender.sub_category}</td>
                  <td>${tender.contract_type}</td>
                  <td>${tender.location} - ${tender.pincode}</td>
                  <td>
                    Start: ${tender.bid_submission_start}<br>
                    End: ${tender.bid_submission_end}
                  </td>
                </tr>`;
            });

            html += '</tbody></table>';
            $('#tenderModalBody').html(html);
          } else {
            $('#tenderModalBody').html('<div class="text-danger">' + response.message + '</div>');
          }
        },
        error: function () {
          $('#tenderModalBody').html('<div class="text-danger">Error loading tender data.</div>');
        }
      });
    });
  });



  $(document).on('click', '.vendor-select-btn', function () {
    const projectId = $(this).data('project-id');

    $('#vendorSelectModalBody').html('<div class="text-center text-muted">Loading...</div>');
    $('#vendorSelectModal').modal('show');

    $.ajax({
      url: "{{ route('vendor.tender.documents') }}", // <-- create this route
      method: 'GET',
      data: { project_id: projectId },
      
      success: function (response) {
        if (response.status === 'success') {
          const documents = response.data;
          if (documents.length === 0) {
            $('#vendorSelectModalBody').html('<div class="text-muted">No documents found.</div>');
            return;
          }

          let html = '<table class="table table-bordered"><thead><tr><th>ID</th><th>File</th><th>Vendor Id</th><th>Vendor Cost</th><th>Action</th></tr></thead><tbody>';
          documents.forEach(doc => {
            html += `
              <tr>
                <td>${doc.id}</td>
                <td>${doc.file_name}</td>
                <td>${doc.vendor_id}</td>
                <td>₹${parseFloat(doc.vendor_cost).toLocaleString()}</td>
                <td>
                  <a href="${doc.document_url}" target="_blank" class="btn btn-sm btn-outline-secondary">📥 Download</a>
                  <input type="checkbox" class="form-check-input select-vendor-checkbox"
                    data-doc-id="${doc.id}" data-project-id="${projectId}" data-vendor-id="${doc.vendor_id}">

                </td>
              </tr>`;
          });
          html += '</tbody></table>';
          $('#vendorSelectModalBody').html(html);
        } else {
          $('#vendorSelectModalBody').html('<div class="text-danger">' + response.message + '</div>');
        }
      },

      error: function () {
        $('#vendorSelectModalBody').html('<div class="text-danger">Error loading documents.</div>');
      }
    });
  });



$(document).off('change', '.select-vendor-checkbox').on('change', '.select-vendor-checkbox', function () {
  const checkbox = $(this);
  const docId = checkbox.data('doc-id');
  const vendorId = checkbox.data('vendor-id');
  const projectId = checkbox.data('project-id');

  if (checkbox.is(':checked')) {
    if (confirm("Do you want to select this vendor?")) {
      $.ajax({
        url: "{{ route('vendor.select') }}", // <-- create this route
        method: 'POST',
        data: {
          _token: $('meta[name="csrf-token"]').attr('content'),
          project_id: projectId,
          vendor_id: vendorId,
          document_id: docId
        },
        success: function (res) {
          alert(res.message || "Vendor selected successfully.");
        },
        error: function (err) {
          alert("Failed to save selection.");
          checkbox.prop('checked', false); // uncheck on failure
        }
      });
    } else {
      checkbox.prop('checked', false); // cancel if user denies
    }
  }
});

</script>

</body>
</html>
