<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <title>Explore Like Projects</title>

  <!-- Fonts & CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

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
    <div class="col-md-10 text-end mt-3">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">
          <i class="bi bi-arrow-left"></i> Back
        </a>
      </div>

    <div class="card-body">
      <h3 class="mb-4 text-primary">🔍 Explore Like Projects</h3>

      <!-- Filter Form -->
      <form id="filterForm" class="row g-3 mb-4">
        <div class="col-md-4">
          <label class="form-label fw-semibold">Project Type</label>
          <input type="text" name="project_name" class="form-control" placeholder="e.g. Residential">
        </div>
        <div class="col-md-4">
          <label class="form-label fw-semibold">Budget Range</label>
          <input type="text" name="budget_range" class="form-control" placeholder="e.g. 10-20 Lacs">
        </div>
        <div class="col-md-4 d-flex align-items-end">
          <button type="submit" class="btn btn-primary me-2 w-50">🔎 Filter</button>
          <button type="button" id="resetBtn" class="btn btn-outline-secondary w-50">♻️ Reset</button>
        </div>
      </form>

      <!-- Projects Table -->
      <div class="table-responsive">
        <table id="projectsTable" class="table table-hover table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>📌 Project Name</th>
              <th>💰 Budget</th>
              <th>⏱️ Timeline</th>
              <th>👁️ View</th>
            </tr>
          </thead>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="projectModal" tabindex="-1" aria-labelledby="projectModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content border-0 shadow-lg">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="projectModalLabel">Project Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Project Name:</strong> <span id="modalProjectName"></span></p>
        <p><strong>Customer Budget:</strong> <span id="modalBudget" class="badge bg-success text-white"></span></p>
        <p><strong>Timeline:</strong> <span id="modalTimeline" class="badge bg-warning text-dark"></span></p>
        <hr>
        <h6>Upload Tender Documents</h6>

        <form id="documentUploadForm" enctype="multipart/form-data">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">EMD Receipt (.pdf)</label>
              <input type="file" name="emd_receipt" id="emd_receipt" class="form-control" accept=".pdf" required>
            </div>
            <div class="col-md-6">
              <label class="form-label">Company Profile (.pdf)</label>
              <input type="file" name="company_profile" id="company_profile" class="form-control" accept=".pdf">
            </div>

            <div class="col-md-6">
              <label class="form-label">Address Proof (.pdf)</label>
              <input type="file" name="address_proof" id="address_proof" class="form-control" accept=".pdf">
            </div>
            <div class="col-md-6">
              <label class="form-label">GST Certificate (.pdf)</label>
              <input type="file" name="gst_certificate" id="gst_certificate" class="form-control" accept=".pdf">
            </div>

            <div class="col-md-6">
              <label class="form-label">Work Experience (.pdf)</label>
              <input type="file" name="work_experience" id="work_experience" class="form-control" accept=".pdf">
            </div>
            <div class="col-md-6">
              <label class="form-label">Financial Capacity (.pdf)</label>
              <input type="file" name="financial_capacity" id="financial_capacity" class="form-control" accept=".pdf">
            </div>

            <div class="col-md-6">
              <label class="form-label">Declaration (.pdf)</label>
              <input type="file" name="declaration" id="declaration" class="form-control" accept=".pdf">
            </div>
            <div class="col-md-6">
              <label class="form-label">BOQ File (.xls/.xlsx)</label>
              <input type="file" name="boq_file" id="boq_file" class="form-control" accept=".xls,.xlsx">
            </div>
            <div class="col-md-6">
              <label class="form-label">Vendor Cost</label>
              <input type="number" name="vendor_cost" id="vendor_cost" class="form-control" placeholder="Enter Vendor Cost" required>
            </div>
          </div>

          <button type="submit" class="btn btn-success mt-4">Upload All Files</button>
        </form>
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
let activeProject = null; 

$(document).ready(function () {
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  // Init DataTable
  let table = $('#projectsTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
      url: "{{ url('/vender/like-projects-data') }}",
      data: function (d) {
        d.project_name = $('input[name=project_name]').val();
        d.budget_range = $('input[name=budget_range]').val();
      }
    },
    columns: [
      { data: 'project_name', name: 'project_name' },
      { data: 'budget_range', name: 'budget_range' },
      { data: 'expected_timeline', name: 'expected_timeline' },
      {
        data: null,
        name: 'view',
        orderable: false,
        searchable: false,
        render: function (data, type, row) {
          return `<button class="btn btn-outline-primary btn-sm view-btn" data-id="${row.id}">👁️ View</button>`;
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

  $('#projectsTable').on('click', '.view-btn', function () {
    const projectId = $(this).data('id');

    $.ajax({
      url: `/project-details-vendor/${projectId}`,
      method: 'GET',
      success: function (data) {
        // Set global project object
        activeProject = {
          id: projectId,
          ...data
        };

        $('#modalProjectName').text(data.project_name);
        $('#modalBudget').text(data.budget_range);
        $('#modalTimeline').text(data.expected_timeline);

        const modal = new bootstrap.Modal(document.getElementById('projectModal'));
        modal.show();
      },
      error: function () {
        alert('Failed to load project details.');
      }
    });
  });
});

// Upload Tender Docs
document.getElementById('documentUploadForm').addEventListener('submit', function (e) {
  e.preventDefault();
  const form = e.target;
  const formData = new FormData(form);

  if (!activeProject || !activeProject.id) {
    alert("No project selected.");
    return;
  }

  formData.append('project_id', activeProject.id);

  fetch('/engineer/tender-documents', {
    method: 'POST',
    body: formData,
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    }
  })
    .then(res => res.json())
    .then(data => {
      alert(data.message);
      form.reset();
      bootstrap.Modal.getInstance(document.getElementById('projectModal')).hide();
    })
    .catch(err => {
      console.error(err);
      alert("Upload failed!");
    });
});
</script>

</body>
</html>
