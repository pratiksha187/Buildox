@extends('layouts.app')
@section('title', 'Project Information')
@section('content')

<!-- Tailwind & Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.tailwindcss.com"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- Body -->
<body class="bg-gradient-to-br from-blue-50 to-orange-50 font-sans text-gray-800 min-h-screen">

  <!-- Form Container -->
    <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-xl mt-10">

    <div class="mb-6 text-center">
      <h2 class="text-3xl font-bold text-black">📋 Project Details</h2>
      <p class="text-gray-500 mt-1">Fill in the form below to share your project information.</p>
    </div>

    <!-- Form -->
    <form id="projectForm" class="space-y-6" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}">

      <!-- Project Name & Location -->
      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Project Name</label>
          <input type="text" id="project_name" name="project_name" placeholder="e.g., Dream Home"
            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Project Location</label>
          <input type="text" id="project_location" name="project_location" placeholder="e.g., Bangalore, India"
            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
      </div>

      <!-- Budget & Timeline -->
      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Budget</label>
          <input type="text" id="budget_range" name="budget_range" placeholder="e.g., ₹10L - ₹50L"
            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1">Expected Timeline</label>
          <select id="expected_timeline" name="expected_timeline"
            class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option value="">Select timeline</option>
            <option value="1">1-3 Months</option>
            <option value="3">3-6 Months</option>
            <option value="4">6-12 Months</option>
            <option value="5">12+ Months</option>
          </select>
        </div>
      </div>

      <!-- Description -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Project Description</label>
        <textarea id="project_description" name="project_description" rows="4"
          placeholder="Describe your project in detail..."
          class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
      </div>

<div>
  <label class="block text-sm font-medium text-gray-700 mb-2">Project Documents</label>
  <label for="upload"
    class="w-full flex flex-col items-center justify-center border-2 border-dashed border-indigo-300 p-6 rounded-lg cursor-pointer hover:border-indigo-400 transition">
    <div class="text-4xl text-indigo-400 mb-2">📁</div>
    <p class="text-gray-600">Click to upload or drag files here</p>
    <p class="text-xs text-gray-400 mt-1">PDF, DOC, JPG, PNG (Max 10MB each)</p>
    <input type="file" id="upload" name="upload[]" class="hidden" multiple>
  </label>

  <!-- File preview list -->
  <ul id="fileList" class="mt-3 text-sm text-gray-700 list-disc pl-5 space-y-1"></ul>
</div>

      <!-- Buttons -->
      <div class="flex flex-col sm:flex-row justify-between items-center gap-4 mt-10">
        <button type="button"
          class="w-full sm:w-auto bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 transition">
          ⬅ Back
        </button>
        <button type="submit"
          class="w-full sm:w-auto bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
          ✅ Submit for Verification
        </button>
      </div>
    </form>
  </div>

  <!-- Scripts -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function () {
      $('#projectForm').on('submit', function (e) {
        e.preventDefault();

        const formData = new FormData(this);
        const projectId = $('#project_id').val();

        $.ajax({
          url: '{{ route("project-details-store") }}',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            alert(response.message);
            window.location.href = '{{ route("customer_details") }}' + '?project_id=' + projectId;
          },
          error: function (xhr) {
            const errors = xhr.responseJSON.errors;
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();

            if (errors) {
              $.each(errors, function (field, messages) {
                const inputField = $('#' + field);
                inputField.addClass('is-invalid');
                inputField.after('<div class="invalid-feedback text-red-600 mt-1 text-sm">' + messages.join('<br>') + '</div>');
              });
            } else if (xhr.responseJSON && xhr.responseJSON.exists) {
              alert(xhr.responseJSON.exists);
            } else {
              alert('An unexpected error occurred. Please try again.');
            }
          }
        });
      });
    });
    
  </script>
  <script>
  $('#upload').on('change', function () {
    const files = this.files;
    const $fileList = $('#fileList');
    $fileList.empty(); // Clear previous list

    if (files.length > 0) {
      for (let i = 0; i < files.length; i++) {
        const fileName = files[i].name;
        $fileList.append('<li>' + fileName + '</li>');
      }
    }
  });
</script>

@endsection
