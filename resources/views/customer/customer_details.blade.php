@extends('layouts.app')
@section('title', 'Project Information')
@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<input type="hidden" name="project_id" id="project_id" value="{{ $project->id }}">

<div class="min-h-screen py-10 flex items-center justify-center">
  <div class="bg-white rounded-2xl shadow-xl max-w-3xl w-full p-8">

    <!-- Header -->
    <div class="text-center mb-8">
      <h2 class="text-3xl font-bold text-gray-800">🏗️ Construction Project Planner</h2>
      <p class="text-gray-500 text-sm mt-1">Review your project details and submit your request</p>
    </div>

    <!-- Project Summary -->
    <div class="bg-blue-50 p-6 rounded-lg border border-blue-100 mb-6">
      <h3 class="text-lg font-semibold text-blue-700 mb-4">📄 Project Summary</h3>
      <div class="grid grid-cols-2 gap-6 text-sm text-gray-800">
        <div>
          <p class="font-semibold">Project Name</p>
          <p class="text-gray-600">{{ $project->project_name ?? '-' }}</p>
        </div>
        <div>
          <p class="font-semibold">Location</p>
          <p class="text-gray-600">{{ $project->project_location ?? '-' }}</p>
        </div>
        <div>
          <p class="font-semibold">Budget</p>
          <p class="text-gray-600">{{ $project->budget_range ?? '-' }}</p>
        </div>
        <div>
          <p class="font-semibold">Timeline</p>
          <p class="text-gray-600">{{ $project->expected_timeline ?? '-' }}</p>
        </div>
        <div class="col-span-2">
          <p class="font-semibold">Description</p>
          <p class="text-gray-600 mt-1 leading-relaxed">{{ $project->project_description ?? '-' }}</p>
        </div>
      </div>
    </div>

    <!-- Ready Message -->
    <div class="bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-lg mb-6 flex items-start space-x-3">
      <svg class="w-6 h-6 mt-0.5 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>
      <div>
        <p class="font-semibold">Ready to proceed!</p>
        <p class="text-sm text-green-700">Your project details are set. Click submit to send your request. Our team will contact you soon.</p>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="text-right">
      <button id="submitRequestBtn"
        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold transition transform hover:scale-105">
        🚀 Submit Request
      </button>
    </div>

  </div>
</div>

<!-- JS Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#submitRequestBtn').on('click', function () {
      const project_id = '{{ $project->id }}';
      $.ajax({
        url: '{{ route("update.project.action") }}',
        method: 'POST',
        data: {
          project_id: project_id,
          confirm: 1
        },
        headers: {
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        success: function (response) {
          $.post('{{ route("store.project.session") }}', {
            project_id: project_id,
            _token: '{{ csrf_token() }}'
          }, function () {
            window.location.href = '{{ route("conformation-page") }}';
          });
        }
      });
    });
  });
</script>

@endsection
