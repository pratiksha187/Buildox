@extends('layouts.project.app')

@section('title', 'Select Your Role')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow rounded-4">
        <div class="card-body p-5">
          <h2 class="text-center mb-2">Join BuildXO as a Service Provider</h2>
          <p class="text-center text-muted mb-4">Create your account and start growing your business with us</p>

          <form id="serviceprovider">
            {{-- @csrf --}}

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="name" class="form-label">Full Name *</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your full name" required>
              </div>
              <div class="col-md-6">
                <label for="mobile" class="form-label">Mobile Number *</label>
                <input type="tel" id="mobile" name="mobile" class="form-control" placeholder="Enter your mobile number" required>
              </div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">Email ID *</label>
              <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="business_name" class="form-label">Business Name</label>
                <input type="text" name="business_name" id="business_name" class="form-control" placeholder="Enter your business name">
              </div>
              <div class="col-md-6">
                <label for="gst_number" class="form-label">GST Number</label>
                <input type="text" name="gst_number" id="gst_number" class="form-control" placeholder="Enter your GST number">
              </div>
            </div>

            <div class="mb-3">
              <label for="location" class="form-label">City / Location *</label>
              <input type="text" name="location" id="location" class="form-control" placeholder="Enter your city or location" required>
            </div>

            <div class="row mb-4">
              <div class="col-md-6">
                <label for="password" class="form-label">Password *</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Create a password" required>
              </div>
              <div class="col-md-6">
                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm your password" required>
              </div>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-success">Create Account</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- CSRF Meta for AJAX --}}
<meta name="csrf-token" content="{{ csrf_token() }}">



<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function () {
    $('#serviceprovider').on('submit', function (e) {
      e.preventDefault();

      let formData = new FormData(this);

      $.ajax({
        url: "{{ route('registerServiceProvider') }}",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (response) {
          window.location.href = "{{ route('types_of_agency') }}";
        },
        error: function (xhr) {
          let errors = xhr.responseJSON?.errors;
          let errorMessage = "";

          if (errors) {
            $.each(errors, function (key, value) {
              errorMessage += value[0] + "\n";
            });
          } else {
            errorMessage = "An unexpected error occurred. Please try again.";
          }

          alert(errorMessage);
        }
      });
    });
  });
</script>
@endsection