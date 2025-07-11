@extends('layouts.vendor.app')

@section('title', 'Verification Pending | ConstructKaro')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<body class="bg-[#F0F4FA] font-sans text-[#2D3748]">

  <div class="max-w-4xl mx-auto mt-10">
    <!-- Header -->
    <div class="bg-[#6EC1E4] text-white p-6 rounded-t-xl shadow-md relative">
      <h1 class="text-2xl font-semibold">👋 Welcome, XYZ Construction Pvt. Ltd.</h1>

      <div class="mt-4 h-2 w-full bg-[#D8EAFE] rounded-full overflow-hidden">
        <div class="bg-green-500 h-2 w-[65%]"></div>
      </div>
      <span class="absolute right-4 top-4 text-sm font-medium">65% Complete</span>
    </div>

    <!-- Main Content -->
    <div class="bg-white p-6 shadow-md rounded-b-xl space-y-6">

      <!-- Profile Status -->
      <div>
        <h2 class="text-xl font-semibold">Profile Status:
          <span class="text-yellow-600">Verification Pending</span>
        </h2>
        <p class="text-sm text-gray-500">Submitted on: 10 June 2025</p>
        <span class="inline-block mt-2 text-xs bg-[#D8EAFE] text-[#6EC1E4] px-2 py-1 rounded-md">
          ID: VN-2025-06-10-XYZ
        </span>
      </div>

      <!-- Missing Documents -->
      <div class="bg-[#FEFAF0] border border-[#CBD5E0] p-5 rounded-md">
        <h3 class="text-sm font-semibold text-red-600 mb-3">⚠️ Missing Documents</h3>
        <ul class="list-disc list-inside text-sm text-red-500 space-y-1 mb-4">
          <li>Turnover Certificate</li>
          <li>Work Reference 2</li>
        </ul>
        <div class="flex flex-wrap gap-3">
          <button class="bg-[#6EC1E4] hover:bg-[#5bb4d9] text-white px-4 py-2 rounded-md text-sm transition">
            ⬆️ Upload Now
          </button>
          <button class="border border-gray-300 text-green-700 hover:bg-green-50 px-4 py-2 rounded-md text-sm transition">
            ✔️ Mark as Complete
          </button>
        </div>
      </div>

      <!-- Verification Timeline -->
      <div>
        <h3 class="text-lg font-semibold mb-4">Verification Process</h3>
        <ol class="space-y-5 text-sm">
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
          <li class="flex items-start gap-3 text-gray-400">
            <span class="text-xl">4</span>
            <div>
              <p class="font-semibold">Background Check</p>
              <p class="text-gray-400">Pending</p>
            </div>
          </li>
          <li class="flex items-start gap-3 text-gray-400">
            <span class="text-xl">5</span>
            <div>
              <p class="font-semibold">Verification Complete</p>
              <p class="text-gray-400">Pending</p>
            </div>
          </li>
        </ol>
      </div>

      <!-- Info Box -->
      <div class="bg-green-50 border border-green-200 text-green-800 text-sm p-4 rounded-md">
        <p class="font-semibold mb-2">⚡ Once verified, you'll get full access to project bidding</p>
        <ul class="list-disc list-inside space-y-1">
          <li>Full project listings</li>
          <li>Bid submission capability</li>
          <li>Direct communication with project owners</li>
          <li>Featured vendor status</li>
        </ul>
      </div>

      <!-- Footer -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between text-sm text-gray-500 gap-4">
        <p>
          Need help?
          <a href="#" class="text-[#6EC1E4] font-medium underline hover:text-[#5bb4d9]">Contact our verification team</a>
        </p>
        <div class="flex gap-2">
          <button class="bg-[#E2E8F0] hover:bg-[#cbd5e1] text-gray-700 px-4 py-1.5 rounded-md transition">
            Go to Dashboard
          </button>
          <button class="bg-[#2D3748] hover:bg-[#1a202c] text-white px-4 py-1.5 rounded-md transition">
            Get Support
          </button>
        </div>
      </div>

    </div>
  </div>

@endsection
