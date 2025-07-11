@extends('layouts.app')
@section('title', 'Project Inquiry')

@section('content')

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<div class="container my-5">
  <div class="max-w-3xl mx-auto bg-white rounded-4 shadow-sm p-5">

    <h2 class="fs-3 fw-bold mb-2">Tell Us About Your Project</h2>
    <p class="text-muted mb-4">
      Don't worry if you don't have all the details. Our team will call you to discuss your project and help finalize the details.
    </p>

    <!-- Message container -->
    <div id="message" class="alert d-none" role="alert"></div>

    <form id="inquiryForm" class="row g-4">
      @csrf

      <!-- Name & Phone -->
      <div class="col-md-6">
        <label for="name" class="form-label fw-medium">Your Name</label>
        <input type="text" name="name" id="name" class="form-control" />
      </div>
      <div class="col-md-6">
        <label for="phone" class="form-label fw-medium">Phone Number</label>
        <input type="tel" name="phone" id="phone" class="form-control" />
      </div>

      <!-- Email -->
      <div class="col-12">
        <label for="email" class="form-label fw-medium">Email Address</label>
        <input type="email" name="email" id="email" class="form-control" />
      </div>

      <!-- Project Type -->
      <div class="col-12">
        <label for="project_type" class="form-label fw-medium">Project Type</label>
        <select name="project_type" id="project_type" class="form-select">
          <option selected disabled>Select project type</option>
          <option>Residential</option>
          <option>Commercial</option>
          <option>Renovation</option>
        </select>
      </div>

      <!-- Project Brief -->
      <div class="col-12">
        <label for="project_brief" class="form-label fw-medium">Project Brief</label>
        <textarea name="project_brief" id="project_brief" rows="5" class="form-control" placeholder="Share a few details about your project..."></textarea>
      </div>

      <!-- Preferred Day & Time -->
      <div class="col-md-6">
        <label for="preferred_day" class="form-label fw-medium">Best Day to Call You</label>
        <select name="preferred_day" id="preferred_day" class="form-select">
          <option selected disabled>Select day</option>
          <option>Monday</option>
          <option>Tuesday</option>
          <option>Wednesday</option>
          <option>Thursday</option>
          <option>Friday</option>
        </select>
      </div>
      <div class="col-md-6">
        <label for="preferred_time" class="form-label fw-medium">Preferred Time</label>
        <select name="preferred_time" id="preferred_time" class="form-select">
          <option selected disabled>Select time</option>
          <option>10:00 AM</option>
          <option>12:00 PM</option>
          <option>3:00 PM</option>
          <option>5:00 PM</option>
        </select>
      </div>

      <!-- Submit Buttons -->
      <div class="col-12 d-flex justify-content-between mt-4">
        <button type="button" class="btn btn-secondary">
          <i class="bi bi-arrow-left"></i> Back
        </button>
        <button type="submit" class="btn btn-primary">
          Submit Request <i class="bi bi-send ms-1"></i>
        </button>
      </div>
    </form>
  </div>
</div>

<!-- AJAX Script -->
<script>
  document.getElementById("inquiryForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const messageBox = document.getElementById("message");

    fetch("{{ route('projectinquiry') }}", {
      method: "POST",
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      messageBox.classList.remove("d-none", "alert-danger", "alert-success");

      if (data.success) {
        form.reset();
        messageBox.classList.add("alert", "alert-success");
        messageBox.textContent = data.message;
      } else {
        messageBox.classList.add("alert", "alert-danger");
        messageBox.innerHTML = Object.values(data.errors).map(e => `<div>${e}</div>`).join('');
      }
    })
    .catch(error => {
      messageBox.classList.remove("d-none");
      messageBox.classList.add("alert", "alert-danger");
      messageBox.textContent = "Something went wrong. Please try again.";
    });
  });
</script>

@endsection
