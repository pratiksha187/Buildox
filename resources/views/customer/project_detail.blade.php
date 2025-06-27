<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload Your Project Details</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="bg-gray-100 font-sans text-gray-800">
  <div class="max-w-4xl mx-auto p-6 bg-white shadow-md rounded-xl mt-10">
    <h2 class="text-2xl font-semibold mb-6">Upload Your Project Details</h2>

    <form id="projectForm" class="space-y-6">
      <!-- Project Name & Type -->
      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium mb-1">Project Name</label>
          <input type="text" placeholder="Enter project name" id="project_name" name="project_name"
                 class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Project Location</label>
         
          <input type="text" placeholder="Enter project Location" id="project_location" name="project_location"
                 class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
      </div>

      <div class="grid md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium mb-1">Estimated Budget</label>
           <input type="text" placeholder="Enter project Location" id="budget_range" name="budget_range"
                 class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>
        <div>
          <label class="block text-sm font-medium mb-1">Expected Timeline</label>
          <select id="expected_timeline" name="expected_timeline" class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <option>Select timeline</option>
            <option value="1">1-3 Month</option>
            <option value="3">3-6 Month</option>
            <option value="4">6-12 Month</option>
            <option value="5">12+ Month</option>
            <!-- Populate with actual options -->
          </select>
        </div>
      </div>
      <div>
        <label class="block text-sm font-medium mb-1">Project Description</label>
        <textarea id="project_description" name="project_description" rows="4" placeholder="Describe your project in detail"
                  class="w-full border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"></textarea>
      </div>
      
      <div>
        <label class="block text-sm font-medium mb-2">Upload Project Documents</label>
        <div class="border-2 border-dashed border-gray-300 p-6 rounded-md text-center">
          <div class="text-3xl mb-2 text-gray-400">☁️</div>
          <p class="text-gray-600 mb-1">Drag and drop files here, or click to browse</p>
          <p class="text-sm text-gray-400 mb-4">Accepted formats: PDF, DOC, JPG, PNG (Max 10MB)</p>
          <input type="file" class="hidden" id="upload" name="upload[]" multiple>
          <label for="upload"
                 class="cursor-pointer bg-indigo-100 text-indigo-600 py-2 px-4 rounded-md font-semibold hover:bg-indigo-200">
            Browse Files
          </label>
        </div>
      </div>

      <!-- Action Buttons -->
      <div class="flex justify-between mt-8">
        <button type="button"
                class="bg-gray-200 text-gray-800 px-6 py-2 rounded-md hover:bg-gray-300 transition">
          Back
        </button>
        <button type="submit"
                class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition">
          Submit for Verification
        </button>
      </div>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
  

    $(document).ready(function() {
      $('#projectForm').on('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
          url: '{{ route("project-details-store") }}',
          method: 'POST',
          data: formData,
          processData: false,
          contentType: false,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          success: function(response) {
            // Optional: show a message
            alert(response.message);

            // Redirect to confirmation page
            // window.location.href = '{{ route("conformation-page") }}';
            window.location.href = '{{ route("customer_details") }}';

          },
          error: function(xhr) {
            const errors = xhr.responseJSON.errors;
            if (errors) {
              $('.is-invalid').removeClass('is-invalid');
              $('.invalid-feedback').remove();

              $.each(errors, function(field, messages) {
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
</body>
</html>
