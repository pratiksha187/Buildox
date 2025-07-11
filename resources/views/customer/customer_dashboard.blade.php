@extends('layouts.customer.app')
@section('title', 'Project Submitted')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js" defer></script>

<input type="hidden" id="project_det_id" value="{{ $project_id }}">

<main class="bg-gradient-to-br from-[#fefefe] via-[#f6f8fc] to-[#fff6ee] min-h-screen py-10 px-6 rounded-2xl max-w-7xl mx-auto" x-data="projectModal()" x-cloak>

  <!-- Card Container -->
  <div class="bg-white shadow-2xl rounded-2xl p-8 space-y-12">

    <!-- Welcome -->
    <div class="border-l-4 border-[#f25c05] pl-6">
      <h2 class="text-3xl font-bold text-[#1c2c3e]">👋 Welcome, {{ $proj_data->full_name ?? 'Customer' }}!</h2>
      <p class="text-gray-600 mt-2 text-sm">Here's an overview of your submitted projects and updates.</p>
    </div>

    <!-- Projects -->
    <section>
      <h3 class="text-xl font-semibold text-[#1c2c3e] mb-4">📂 My Projects</h3>
      <div class="bg-white border border-gray-200 rounded-xl overflow-hidden shadow-sm">
        <table class="min-w-full divide-y divide-gray-100 text-sm">
          <thead class="bg-gray-50 text-gray-700">
            <tr>
              <th class="px-6 py-4 text-left">Project Name</th>
              <th class="px-6 py-4 text-left">Status</th>
              <th class="px-6 py-4 text-left">Submitted On</th>
              <th class="px-6 py-4 text-left">Actions</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-100">
            @foreach ($get_project_det as $project)
              <tr>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-3">
                    <div class="bg-[#f25c05]/10 p-2 rounded-full text-[#f25c05]">
                      <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2L2 7v11h6v-5h4v5h6V7l-8-5z"/>
                      </svg>
                    </div>
                    <div>
                      <div class="font-medium text-[#1c2c3e]">{{ $project->project_name ?? '-' }}</div>
                      <div class="text-xs text-gray-500">Residential Project</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  @if ($project->confirm == 1)
                    <span class="bg-yellow-100 text-yellow-800 text-xs font-semibold px-3 py-1 rounded-full">Under Review</span>
                  @else
                    <span class="bg-gray-100 text-gray-600 text-xs font-semibold px-3 py-1 rounded-full">Draft</span>
                  @endif
                </td>
                <td class="px-6 py-4">{{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}</td>
                <td class="px-6 py-4">
                  {{-- <button @click="openModal({{ json_encode($project) }})" class="text-[#f25c05] hover:underline font-medium">View</button> --}}
                  <td class="px-6 py-4">
      <button
        onclick="openModal(
          '{{ $project->project_name }}',
          '{{ $project->confirm == 1 ? 'Under Review' : 'Draft' }}',
          '{{ $project->description ?? 'No description available.' }}',
          '{{ \Carbon\Carbon::parse($project->created_at)->format('d M Y') }}'
        )"
        class="text-[#f25c05] hover:underline font-medium"
      >
        View
      </button>
    </td>
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </section>

    <!-- Notifications -->
    <section>
      <h3 class="text-xl font-semibold text-[#1c2c3e] mb-4">🔔 Notifications</h3>
      <div class="space-y-4">
        <div class="bg-white border-l-4 border-[#f25c05] p-4 rounded-xl shadow-sm">
          <div class="text-sm text-gray-800">
            📞 We tried calling you regarding your Karjat project.
            <a href="#" class="text-[#f25c05] font-medium">Reschedule call</a>
          </div>
          <div class="text-xs text-gray-400 mt-1">2 hours ago</div>
        </div>
        <div class="bg-white border-l-4 border-green-500 p-4 rounded-xl shadow-sm">
          <div class="text-sm text-gray-800">📄 Your project documents have been verified.</div>
          <div class="text-xs text-gray-400 mt-1">Yesterday</div>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="bg-white p-6 border border-gray-200 rounded-xl flex justify-between items-center">
      <div>
        <h4 class="text-lg font-semibold text-[#1c2c3e]">Need help with a new project?</h4>
        <p class="text-gray-600 text-sm">Let us guide you from start to finish.</p>
      </div>
      <a href="{{ route('project') }}" class="px-5 py-2 bg-[#f25c05] text-white rounded-lg hover:bg-[#c94a03] transition">+ Add Project</a>
    </section>

  </div>

{{-- </main> --}}
  <!-- Place Modal INSIDE the Alpine scope (before closing </main>) -->
  <!-- Project Detail Modal -->
  <!-- Modal -->
<div id="simpleModal" style="display:none;" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50">
  <div class="bg-white w-full max-w-md rounded-lg p-6 relative">
    <button onclick="closeModal()" class="absolute top-2 right-3 text-gray-600 hover:text-gray-900">✕</button>
    <h2 class="text-xl font-bold mb-4 text-gray-800">Project Details</h2>

    <div class="space-y-2 text-sm text-gray-700">
      <div><strong>Name:</strong> <span id="projName">-</span></div>
      <div><strong>Status:</strong> <span id="projStatus">-</span></div>
      <div><strong>Description:</strong> <span id="projDesc">-</span></div>
      <div><strong>Created On:</strong> <span id="projDate">-</span></div>
    </div>
  </div>
</div>


</main>

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

<script>
  function openModal(name, status, desc, date) {
    document.getElementById('projName').innerText = name;
    document.getElementById('projStatus').innerText = status;
    document.getElementById('projDesc').innerText = desc;
    document.getElementById('projDate').innerText = date;
    document.getElementById('simpleModal').style.display = 'flex';
  }

  function closeModal() {
    document.getElementById('simpleModal').style.display = 'none';
  }
</script>

@endsection
