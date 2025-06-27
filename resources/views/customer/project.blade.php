@extends('layouts.project.app')

@section('title', 'Project Information')

@section('content')
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
  .form-section {
    background-color: #f9f9fb;
    padding: 40px;
    border-radius: 10px;
  }

  .form-title-wrapper {
    text-align: center;
    margin-bottom: 30px;
  }

  .form-title-wrapper h4 {
    font-weight: 600;
    font-size: 1.75rem;
  }

  .form-switch label {
    margin-left: 0.5rem;
  }

  .select2-container--default .select2-selection--multiple {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
  }
</style>

<div class="container my-5">
  <div class="form-section shadow-sm">
    <div class="form-title-wrapper">
      <h4>Tell us about your project</h4>
    </div>

    <form id="projectForm"  method="POST">
      <div class="row mb-3">
        <div class="col-md-6">
          <label class="form-label">Full Name</label>
          <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Enter full name">
        </div>
        <div class="col-md-6">
          <label class="form-label">Phone Number</label>
          <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Enter phone number">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Email </label>
        <input type="email" name="email" id="email" class="form-control" placeholder="Enter email">
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="role" class="form-label">Select Your Role</label>
          <select class="form-select" id="role" name="role">
            <option selected disabled>Choose your role</option>
            <option value="1">Private Property Owner</option>
            <option value="2">Builder (Residential/Commercial/Mixed Use)</option>
            <option value="3">Developer</option>
            <option value="4">Factory Head</option>
            <option value="5">Institutional Head</option>
            <option value="6">Hospitality Owner</option>
          </select>
        </div>

        <div class="col-md-6 mb-3">
          <label for="construction_type" class="form-label">Type of Vendor Needed</label>
         
          <select id="construction_type" class="form-select">
            <option value="">Select Construction Type</option>
            @foreach($construction_types as $type)
              <option value="{{ $type->id }}">{{ $type->name }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="col-md-6 mb-3">
        <label for="project_type" class="form-label">Select Project Type</label>
        
        <select id="project_type" name="project_type" class="form-select mt-3">
          <option value="">Select Project Type</option>
        </select>
      </div>

      <div id="sub_categories_container" class="col-md-6 mb-3" style="display: none;">
        <label class="form-label fw-bold" id="sub_category_title"></label>
        
        Select Sub-Categories
       <div id="sub_categories" class="form-check d-flex flex-column gap-2 mt-2">
        
      </div>

      </div>

      <div class="form-check form-switch mb-4">
        <input class="form-check-input" type="checkbox" id="plot_ready" name="plot_ready">
        <label class="form-check-label" for="plot_ready">Do you have your plot/site ready?</label>
      </div>

      <button class="btn btn-primary" type="submit">Next</button>
    </form>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script> 
$(document).ready(function () {
  $('#projectForm').on('submit', function (e) {
    e.preventDefault();

    // Collect sub-category checkbox values
    let selectedSubCategories = [];
    $('input[name="sub_categories[]"]:checked').each(function () {
      selectedSubCategories.push($(this).val());
    });

    const formData = {
      full_name: $('#full_name').val(),
      phone_number: $('#phone_number').val(),
      email: $('#email').val(),
      role: $('#role').val(),
      construction_type: $('#construction_type').val(),
      project_type: $('#project_type').val(),
      sub_categories: selectedSubCategories,
      plot_ready: $('#plot_ready').is(':checked') ? 1 : 0,
    };

    $.ajax({
      url: '{{ route('projectinfostore') }}',
      method: 'POST',
      data: formData,
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function (response) {
        if (response.status === 'success') {
          alert(response.message);
          $('#projectForm')[0].reset();
          $('#construction_type').val(null).trigger('change');
          $('#project_type').empty().append('<option value="">Select Project Type</option>');
          $('#sub_categories').empty();
          $('#sub_categories_container').hide();
          window.location.href = '{{ route("more-about-project") }}';
        }
      },
      error: function (xhr) {
        if (xhr.status === 409 && xhr.responseJSON.status === 'exists') {
          alert(xhr.responseJSON.message);
          return;
        }

        const errors = xhr.responseJSON.errors;
        if (errors) {
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').remove();

          $.each(errors, function (field, messages) {
            const inputField = $('#' + field);
            inputField.addClass('is-invalid');
            inputField.after('<div class="invalid-feedback">' + messages.join('<br>') + '</div>');
          });
        } else {
          alert('An unexpected error occurred. Please try again.');
        }
      }
    });
  });
});
</script>

<script>
  $(document).ready(function () {
  $('#construction_type').on('change', function () {
    let id = $(this).val();
    $('#project_type').empty().append('<option value="">Select Project Type</option>');
    $('#subcategory').empty().append('<option value="">Select Subcategory</option>');

    if (id) {
      $.get('/get-project-types/' + id, function (data) {
        $.each(data, function (i, type) {
          $('#project_type').append(`<option value="${type.id}">${type.name}</option>`);
        });
      });
    }
  });

  
  $('#project_type').on('change', function () {
  let id = $(this).val();
  const container = $('#sub_categories');
  container.empty(); // Clear old checkboxes
  $('#sub_categories_container').hide(); // Hide initially

  if (id) {
    $.get('/get-subcategories/' + id, function (data) {
      if (data.length > 0) {
        data.forEach(sub => {
          const checkboxHTML = `
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="subcat_${sub.id}" name="sub_categories[]" value="${sub.id}">
              <label class="form-check-label" for="subcat_${sub.id}">${sub.name}</label>
            </div>`;
          container.append(checkboxHTML);
        });
        $('#sub_categories_container').show();
      }
    });
  }
});

});

  </script>
@endsection
