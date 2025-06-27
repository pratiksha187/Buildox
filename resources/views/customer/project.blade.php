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

    <!-- Title in separate div, centered -->
    <div class="form-title-wrapper">
      <h4>Tell us about your project</h4>
    </div>

    <form id="projectForm">
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
          <select class="form-select js-multi-select" id="construction_type" name="construction_type[]" multiple>
            <option value="1">Contractor</option>
            <option value="2">Architect</option>
            <option value="3">Consultant</option>
            <option value="4">Interior Designer</option>
          </select>
        </div>
      </div>

      <div class="col-md-6 mb-3">
        <label for="project_type" class="form-label">Select Project Type</label>
        <select class="form-select" id="project_type" name="project_type">
          <option selected disabled>Choose project type</option>
          <option value="residential">Residential Construction</option>
          <option value="commercial">Commercial Construction</option>
        </select>
      </div>

      <div id="sub_categories_container" class="mb-3" style="display: none;">
        <label class="form-label fw-bold" id="sub_category_title"></label>
        <div id="sub_categories" class="form-check d-flex flex-column gap-2 mt-2">
          <!-- Checkboxes will be injected here -->
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
  const subCategoryData = {
  residential: {
    title: 'Select Residential Construction Sub-Categories',
    options: [
      'RCC Work – Core & Shell',
      'Complete Turnkey Work',
      'Bungalow Construction',
      'Apartment / Building',
      'Row Houses / Villas'
    ]
  },
  commercial: {
    title: 'Select Commercial Construction Sub-Categories',
    options: [
      'Office Space / Co-working',
      'Showroom / Retail',
      'Hotels / Resorts',
      'Hospitals / Clinics',
      'School / College / Institutional'
    ]
  }
};

$('#project_type').on('change', function () {
  const selected = $(this).val();
  const container = $('#sub_categories');
  const title = $('#sub_category_title');

  container.empty(); // Clear existing checkboxes

  if (subCategoryData[selected]) {
    const { title: categoryTitle, options } = subCategoryData[selected];
    title.text(categoryTitle);

    options.forEach((opt, index) => {
      const id = `subcat_${selected}_${index}`;
      const checkboxHTML = `
        <div class="form-check">
          <input class="form-check-input" type="checkbox" value="${opt}" id="${id}" name="sub_categories[]">
          <label class="form-check-label" for="${id}">${opt}</label>
        </div>`;
      container.append(checkboxHTML);
    });

    $('#sub_categories_container').show();
  } else {
    $('#sub_categories_container').hide();
  }
});

</script>
<script>
  $(document).ready(function () {
    $('.js-multi-select').select2({
      placeholder: "Select construction type",
      allowClear: true,
      width: '100%'
    });

    $('#projectForm').on('submit', function (e) {
      e.preventDefault();

      const formData = {
        full_name: $('#full_name').val(),
        phone_number: $('#phone_number').val(),
        email: $('#email').val(),
        role: $('#role').val(),
        construction_type: $('#construction_type').val(),
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
            window.location.href = '{{ route('more-about-project') }}';
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
@endsection
