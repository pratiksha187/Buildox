<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Construction Project Planner</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

  <div class="bg-white rounded-xl shadow-lg max-w-2xl w-full p-6">
    <!-- Header -->
    <div class="text-center mb-6">
      <h2 class="text-2xl font-semibold text-gray-800">Construction Project Planner</h2>
      <p class="text-gray-500 text-sm">Select your project details to get started with your construction needs</p>
    </div>

    <!-- Stepper -->
    <div class="flex justify-between items-center mb-6">
      <div class="flex flex-col items-center text-green-600">
        <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-bold">1</div>
        <span class="text-sm mt-1">Project Type</span>
      </div>
      <div class="flex-1 h-1 bg-green-500 mx-2"></div>
      <div class="flex flex-col items-center text-green-600">
        <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center text-sm font-bold">2</div>
        <span class="text-sm mt-1">Details</span>
      </div>
      <div class="flex-1 h-1 bg-blue-500 mx-2"></div>
      <div class="flex flex-col items-center text-blue-600">
        <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center text-sm font-bold">3</div>
        <span class="text-sm mt-1">Summary</span>
      </div>
    </div>

    <!-- Summary Box -->
    <div class="bg-blue-50 p-4 rounded-md mb-6">
      <h3 class="text-blue-700 font-semibold text-lg mb-3">Project Summary</h3>
      <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
        <div>
          <p class="font-medium">Project Type</p>
          <p>Commercial Construction</p>
        </div>
        <div>
          <p class="font-medium">Sub-Category</p>
          <p>Office Space / Co-working</p>
        </div>
        <div>
          <p class="font-medium">Project Name</p>
          <p>-</p>
        </div>
        <div>
          <p class="font-medium">Location</p>
          <p>-</p>
        </div>
        <div>
          <p class="font-medium">Budget</p>
          <p>-</p>
        </div>
        <div>
          <p class="font-medium">Timeline</p>
          <p>-</p>
        </div>
        <div class="col-span-2">
          <p class="font-medium">Description</p>
          <p>-</p>
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
      <button class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition">Submit Request</button>
    </div>
  </div>

</body>
</html>
