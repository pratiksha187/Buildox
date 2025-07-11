@extends('layouts.vendor.app')

@section('title', 'Select Your Role')

@section('content')
<style>
  body {
    background-color: #f5f7fa;
    font-family: 'Segoe UI', sans-serif;
  }

  .card {
    border: none;
    background-color: #fff;
    border-radius: 16px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
  }

  h2 {
    font-weight: 700;
    color: #1b2a3d;
  }

  .form-label {
    font-weight: 600;
    color: #1b2a3d;
  }

  .form-control {
    border-radius: 8px;
    border: 1px solid #d1d9e6;
    transition: all 0.2s ease;
  }

  .form-control:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.2);
  }

  .btn-success {
    background-color: #28a745;
    border-color: #28a745;
    padding: 12px;
    font-weight: 600;
    font-size: 16px;
    border-radius: 8px;
    transition: all 0.3s ease;
  }

  .btn-success:hover {
    background-color: #218838;
    border-color: #1e7e34;
  }

  #suggestions {
    max-height: 200px;
    overflow-y: auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    z-index: 1000;
    position: absolute;
  }

  .dropdown-item {
    cursor: pointer;
    padding: 10px 15px;
    font-size: 14px;
  }

  .dropdown-item:hover {
    background-color: #f1f1f1;
  }

  .d-grid .btn {
    margin-top: 10px;
  }

  footer {
    background-color: #1b2a3d;
    color: #fff;
    padding: 20px 0;
    font-size: 14px;
  }

  footer a {
    color: #f47c1c;
    text-decoration: none;
    margin: 0 10px;
  }

  footer a:hover {
    text-decoration: underline;
  }

  .brand-highlight {
    color: #f47c1c;
  }
</style>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-lg-10 col-xl-8">
      <div class="card shadow rounded-4">
        <div class="card-body p-5">
          <h2 class="text-center mb-2">Join <span class="brand-highlight">Constructkaro</span> as a Service Provider</h2>
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

            <div class="mb-3 position-relative">
              <label for="email" class="form-label">Email ID *</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" autocomplete="off" required>
              <div id="suggestions" class="dropdown-menu show w-100" style="display: none;"></div>
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
        success: function () {
          window.location.href = "{{ route('types_of_agency') }}";
        },
        error: function (xhr) {
          let errors = xhr.responseJSON?.errors;
          let errorMessage = "";

          if (errors) {
            $.each(errors, function (key, value) {
              errorMessage += `<div>${value[0]}</div>`;
            });
          } else {
            errorMessage = "An unexpected error occurred. Please try again.";
          }

          $('body').prepend(`
            <div class="alert alert-danger alert-dismissible fade show mx-auto mt-3" style="max-width: 600px;" role="alert">
              ${errorMessage}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          `);
        }
      });
    });
  });
</script>

<script>
  const emailInput = document.getElementById('email');
  const suggestionsBox = document.getElementById('suggestions');
  const domains = [
    'gmail.com', 'yahoo.com', 'rediffmail.com', 'outlook.com', 'hotmail.com',
    'live.com', 'aol.com', 'icloud.com', 'protonmail.com', 'mail.com',
    'zoho.com', 'gmx.com', 'yandex.com', 'msn.com', 'inbox.com', 'me.com'
  ];

  emailInput.addEventListener('input', function () {
    const value = this.value;
    const atIndex = value.indexOf('@');

    if (atIndex !== -1 && !value.includes('.', atIndex)) {
      const username = value.slice(0, atIndex + 1);
      suggestionsBox.innerHTML = '';
      domains.forEach(domain => {
        const item = document.createElement('a');
        item.className = 'dropdown-item';
        item.textContent = username + domain;
        item.onclick = () => {
          emailInput.value = item.textContent;
          suggestionsBox.style.display = 'none';
        };
        suggestionsBox.appendChild(item);
      });
      suggestionsBox.style.display = 'block';
    } else {
      suggestionsBox.style.display = 'none';
    }
  });

  document.addEventListener('click', (e) => {
    if (!suggestionsBox.contains(e.target) && e.target !== emailInput) {
      suggestionsBox.style.display = 'none';
    }
  });
</script>
@endsection
