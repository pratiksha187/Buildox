<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Construction Project Planner</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
 <input type="text" name="project_id" id="project_id" value="{{ $project->id }}">
  <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-6">
    <!-- Header -->
    <div class="text-center mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">Construction Project Planner</h2>
      <p class="text-gray-500 text-sm">Select your project details to get started with your construction needs</p>
    </div>

    <!-- Summary Box -->
    <div class="bg-blue-50 p-4 rounded-md mb-6">
      <h3 class="text-blue-700 font-semibold text-lg mb-3">Project Summary</h3>
      <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
      
        <div>
          <p class="font-medium">Project Name</p>
          <p>{{ $project->project_name ?? '-' }}</p>
        </div>
        <div>
          <p class="font-medium">Location</p>
          <p>{{ $project->project_location ?? '-' }}</p>
        </div>
        <div>
          <p class="font-medium">Budget</p>
          <p>{{ $project->budget_range ?? '-' }}</p>
        </div>
        <div>
          <p class="font-medium">Timeline</p>
          <p>{{ $project->expected_timeline ?? '-' }}</p>
        </div>
        <div class="col-span-2">
          <p class="font-medium">Description</p>
          <p>{{ $project->project_description ?? '-' }}</p>
        </div>
      </div>
    </div>

    <!-- Ready Notice -->
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md mb-4">
      <div class="flex items-start">
        <svg class="w-5 h-5 mt-1 mr-2 text-green-500" fill="none" stroke="currentColor" stroke-width="2"
             viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
                d="M5 13l4 4L19 7"/>
        </svg>
        <div>
          <p class="font-medium">Ready to proceed!</p>
          <p class="text-sm">Your project details have been prepared. Click submit to send your request and our team will contact you shortly.</p>
        </div>
      </div>
    </div>

    <!-- Submit Button -->
    <div class="text-right">
      {{-- <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Submit Request</button> --}}
      <button id="submitRequestBtn" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">
        Submit Request
      </button>

    </div>
  </div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function () {
    $('#submitRequestBtn').on('click', function () {
      const project_id = '{{ $project->id }}'; // Make sure this is available from Blade

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
        // Save project_id to session using another request
        $.post('{{ route("store.project.session") }}', {
          project_id: project_id,
          _token: '{{ csrf_token() }}'
        }, function () {
          window.location.href = '{{ route("conformation-page") }}';
        });
      }
    });

      // $.ajax({
      //   url: '{{ route("update.project.action") }}',
      //   method: 'POST',
      //   data: {
      //     project_id: project_id,
      //     confirm: 1
      //   },
      //   headers: {
      //     'X-CSRF-TOKEN': '{{ csrf_token() }}'
      //   },
      //   success: function (response) {
      //     alert('Project action updated!');
      //     // Redirect with project_id in URL
      //     window.location.href = '{{ route("conformation-page") }}' + '?project_id=' + project_id;
      //   },
      //   error: function (xhr) {
      //     alert('Something went wrong. Please try again.');
      //   }
      // });
    });
  });
</script>

</body>
</html>
