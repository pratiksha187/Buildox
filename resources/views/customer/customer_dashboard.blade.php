<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Constructkaro Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

<input type="hidden" name="project_det_id" id="project_det_id" value="{{ $project_id }}">

<!-- Header -->

<header class="bg-white shadow">
  <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-blue-600">Constructkaro</h1>
    <nav class="flex items-center space-x-6">
      
      <!-- Vendor List Link -->
      <a href="{{ route('vendor_details')}} " class="text-sm font-medium text-gray-700 hover:text-blue-600">
        Vendor List
      </a>

      <!-- User Dropdown -->
      <div class="relative" x-data="{ open: false }">
        <div class="flex items-center space-x-2 cursor-pointer" @click="open = !open">
          <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">
            {{ strtoupper(substr($proj_data->full_name ?? 'U', 0, 1)) }}
          </div>
          <div class="text-sm">
            <div class="font-medium">{{ $proj_data->full_name ?? 'Unknown' }}</div>
            <div class="text-gray-500">{{ $proj_data->email ?? '' }}</div>
          </div>
          <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
          </svg>
        </div>

        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">
          <a href="{{ route('customer.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Dashboard
          </a>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-red-50">
              Logout
            </button>
          </form>
        </div>
      </div>
    </nav>
  </div>
</header>

<!-- Main Content -->
<main class="max-w-6xl mx-auto px-6 py-8" x-data="projectModal()" x-cloak>
  
  <!-- Welcome -->
  <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl p-6 mb-6">
    <h2 class="text-2xl font-semibold">👋 Welcome back, {{ $proj_data->full_name ?? 'Customer' }}!</h2>
    <p class="mt-1 text-sm">Here's an overview of your projects and notifications.</p>
  </div>

  <!-- My Projects -->
  <section class="mb-8">
    <h3 class="text-xl font-semibold mb-4">📂 My Projects</h3>
    <div class="bg-white rounded-xl shadow overflow-hidden">
      <table class="min-w-full text-sm text-left">
        <thead class="bg-gray-100 text-gray-600 uppercase">
          <tr>
            <th class="px-6 py-3">Project Name</th>
            <th class="px-6 py-3">Status</th>
            <th class="px-6 py-3">Submitted On</th>
            <th class="px-6 py-3">Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($get_project_det as $project)
            <tr class="border-b">
              <td class="px-6 py-4">
                <div class="flex items-center space-x-2">
                  <div class="bg-blue-100 p-2 rounded-full text-blue-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 2L2 7v11h6v-5h4v5h6V7l-8-5z"/>
                    </svg>
                  </div>
                  <div>
                    <div class="font-medium">{{ $project->project_name ?? '-' }}</div>
                    <div class="text-gray-500 text-xs">Residential Project</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                @if ($project->confirm == 1)
                  <span class="bg-orange-100 text-orange-600 text-xs px-3 py-1 rounded-full">Under Review</span>
                @else
                  <span class="bg-gray-200 text-gray-600 text-xs px-3 py-1 rounded-full">Draft</span>
                @endif
              </td>
              <td class="px-6 py-4">
                {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}
              </td>
              <td class="px-6 py-4">
                <button
                  @click="openModal({{ json_encode($project) }})"
                  class="text-blue-600 hover:underline text-sm"
                >View</button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </section>

  <!-- Notifications -->
  <section class="mb-8">
    <h3 class="text-xl font-semibold mb-4">🔔 Notifications</h3>
    <div class="space-y-3">
      <div class="bg-white border-l-4 border-red-500 p-4 rounded shadow-sm">
        <div class="text-sm text-gray-700">
          📞 We tried calling you for your Karjat project.
          <a href="#" class="text-blue-600 font-semibold">Reschedule call.</a>
        </div>
        <div class="text-xs text-gray-500 mt-1">2 hours ago</div>
      </div>
      <div class="bg-white border-l-4 border-green-500 p-4 rounded shadow-sm">
        <div class="text-sm text-gray-700">
          📄 Your project documents have been verified.
        </div>
        <div class="text-xs text-gray-500 mt-1">Yesterday</div>
      </div>
    </div>
  </section>

  <!-- CTA -->
  <section class="mt-8 bg-blue-50 border border-blue-100 rounded-lg flex justify-between items-center px-6 py-4">
    <div>
      <h4 class="text-lg font-semibold text-gray-800">Ready to start a new project?</h4>
      <p class="text-gray-600 text-sm">Let us help you bring your vision to life.</p>
    </div>
    <a href="{{ route('project') }}" class="text-blue-600 border border-blue-500 hover:bg-blue-100 font-medium px-4 py-2 rounded">
      + Add Another Project
    </a>
  </section>

<div
  x-show="showModal"
  x-transition
  class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-70 backdrop-blur-sm"
>
  <div
    class="relative w-full max-w-4xl mx-auto bg-white rounded-xl shadow-lg p-8 overflow-y-auto max-h-[90vh]"
    @click.away="showModal = false"
  >
    <!-- Close button -->
    <button
      @click="showModal = false"
      class="absolute top-4 right-4 text-gray-400 hover:text-black text-xl"
      aria-label="Close"
    >
      &times;
    </button>

    <!-- Title -->
    <h2 class="text-2xl font-bold text-blue-600 mb-6 border-b pb-2">📋 Project Details</h2>

    <!-- Project content -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
      <div>
        <p class="font-semibold text-gray-700">Project Name</p>
        <p class="text-gray-800" x-text="project.project_name"></p>
      </div>
      <div>
        <p class="font-semibold text-gray-700">Location</p>
        <p class="text-gray-800" x-text="project.project_location"></p>
      </div>
      <div class="md:col-span-2">
        <p class="font-semibold text-gray-700">Description</p>
        <p class="text-gray-800" x-text="project.project_description"></p>
      </div>
      <div>
        <p class="font-semibold text-gray-700">Budget</p>
        <p class="text-gray-800">₹<span x-text="project.budget_range"></span></p>
      </div>
      <div>
        <p class="font-semibold text-gray-700">Timeline</p>
        <p class="text-gray-800"><span x-text="project.expected_timeline"></span> month(s)</p>
      </div>
      <div>
        <p class="font-semibold text-gray-700">Submission ID</p>
        <p class="text-gray-800" x-text="project.submission_id"></p>
      </div>
      <div>
        <p class="font-semibold text-gray-700">Status</p>
        <p class="text-gray-800" x-text="project.confirm == 1 ? 'Under Review' : 'Draft'"></p>
      </div>
    </div>

    <!-- Close button bottom -->
    <div class="mt-8 text-right">
      <button
        @click="showModal = false"
        class="inline-flex items-center px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition"
      >
        Close
      </button>
    </div>
  </div>
</div>

</main>

<!-- Footer -->
<footer class="bg-white shadow-inner mt-12">
  <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center text-sm text-gray-500">
    <p>&copy; 2025 Constructkaro. All rights reserved.</p>
    <div class="space-x-4">
      <a href="#" class="hover:text-blue-600">Privacy Policy</a>
      <a href="#" class="hover:text-blue-600">Terms of Service</a>
    </div>
  </div>
</footer>

<!-- AlpineJS component -->
<script>
  function projectModal() {
    return {
      showModal: false,
      project: {},
      openModal(data) {
        this.project = data;
        this.showModal = true;
      }
    }
  }
</script>

</body>
</html>
