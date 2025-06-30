<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile Verification</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f1f5f9] font-sans text-gray-800">

  <div class="max-w-3xl mx-auto mt-10">
    <!-- Header -->
    <div class="bg-blue-700 text-white p-6 rounded-t-xl shadow-md relative">
      <h1 class="text-2xl font-semibold">👋 Welcome, XYZ Construction Pvt. Ltd.</h1>
      <div class="mt-4 h-2 w-full bg-blue-200 rounded-full overflow-hidden">
        <div class="bg-green-500 h-2 w-[65%]"></div>
      </div>
      <span class="absolute right-4 top-4 text-sm">65% Complete</span>
    </div>

    <!-- Main Card -->
    <div class="bg-white p-6 shadow-md rounded-b-xl">
      <!-- Status -->
      <div class="mb-4">
        <h2 class="text-xl font-semibold text-gray-700">Profile Status: <span class="text-yellow-500">Verification Pending</span></h2>
        <p class="text-sm text-gray-500">Submitted on: 10 June 2025</p>
        <div class="mt-2">
          <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-md">ID: VN-2025-06-10-XYZ</span>
        </div>
      </div>

      <!-- Missing Docs -->
      <div class="bg-yellow-50 border border-yellow-300 p-4 rounded-md mb-6">
        <h3 class="text-sm font-semibold text-yellow-600 mb-2">⚠️ Missing Documents</h3>
        <ul class="list-disc list-inside text-sm text-red-600 mb-4">
          <li>Turnover Certificate</li>
          <li>Work Reference 2</li>
        </ul>
        <div class="flex gap-3">
          <button class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-md text-sm">⬆️ Upload Now</button>
          <button class="border border-gray-300 text-green-600 px-4 py-2 rounded-md text-sm">✔️ Mark as Complete</button>
        </div>
      </div>

      <!-- Verification Process -->
      <div>
        <h3 class="text-lg font-semibold mb-3">Verification Process</h3>
        <ol class="space-y-4 text-sm">
          <li class="flex items-start gap-3">
            <span class="text-green-500 text-xl">✔️</span>
            <div>
              <p class="font-semibold">Profile Created</p>
              <p class="text-gray-500">10 June 2025, 09:15 AM</p>
            </div>
          </li>
          <li class="flex items-start gap-3">
            <span class="text-green-500 text-xl">✔️</span>
            <div>
              <p class="font-semibold">Basic Information Submitted</p>
              <p class="text-gray-500">10 June 2025, 09:30 AM</p>
            </div>
          </li>
          <li class="flex items-start gap-3">
            <span class="text-yellow-500 text-xl">⏳</span>
            <div>
              <p class="font-semibold">Document Verification</p>
              <p class="text-gray-500">Awaiting missing documents</p>
            </div>
          </li>
          <li class="flex items-start gap-3 opacity-50">
            <span class="text-gray-400 text-xl">4</span>
            <div>
              <p class="font-semibold">Background Check</p>
              <p class="text-gray-500">Pending</p>
            </div>
          </li>
          <li class="flex items-start gap-3 opacity-50">
            <span class="text-gray-400 text-xl">5</span>
            <div>
              <p class="font-semibold">Verification Complete</p>
              <p class="text-gray-500">Pending</p>
            </div>
          </li>
        </ol>
      </div>

      <!-- Success Note -->
      <div class="bg-green-50 border border-green-200 text-green-800 text-sm p-4 rounded-md mt-6">
        <p class="font-semibold mb-2">⚡ Once verified, you'll get full access to project bidding</p>
        <ul class="list-disc list-inside">
          <li>Full project listings</li>
          <li>Bid submission capability</li>
          <li>Direct communication with project owners</li>
          <li>Featured vendor status</li>
        </ul>
      </div>

      <!-- Footer -->
      <div class="flex items-center justify-between mt-6 text-sm text-gray-500">
        <p>Need help? <a href="#" class="text-blue-600 underline">Contact our verification team</a></p>
        <div class="flex gap-2">
          <button class="bg-gray-200 px-4 py-1 rounded-md">Go to Dashboard</button>
          <button class="bg-blue-600 text-white px-4 py-1 rounded-md">Get Support</button>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
