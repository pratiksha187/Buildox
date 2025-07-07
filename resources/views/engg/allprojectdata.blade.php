@extends('layouts.engg.app')

@section('title', 'Projects List')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
  .animate-fade-in {
    animation: fadeIn 0.3s ease-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }
</style>

<div class="max-w-6xl mx-auto px-6" x-data="{ activeProject: null, showCallModal: false }">
    <div class="bg-white p-6 rounded shadow-md mt-8">
        <h2 class="text-xl font-semibold mb-4">Projects List</h2>

        @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="table-responsive">
        <table class="min-w-full table-auto border border-collapse text-sm">
            <thead class="table-light">
            <tr>
                <th class="border px-4 py-2">Id</th>
                <th class="border px-4 py-2">Project Name</th>
                <th class="border px-4 py-2">Address</th>
                <th class="border px-4 py-2">Description</th>
                <th class="border px-4 py-2">Action</th>
            </tr>
            </thead>
            <tbody class="text-gray-700">
            @forelse($projects as $index => $project)
                <tr class="hover:bg-gray-50">
                {{-- <td class="border px-4 py-2">{{ $index + 1 }}</td> --}}
                  <td class="border px-4 py-2">{{ $projects->firstItem() + $index }}</td>
                <td class="border px-4 py-2">{{ $project->project_name }}</td>
                <td class="border px-4 py-2">{{ $project->project_location }}</td>
                <td class="border px-4 py-2">{{ $project->project_description }}</td>
                <td class="border px-4 py-2 text-center">
                    <button @click="activeProject = {{ json_encode($project) }}" 
                            class="text-blue-600 hover:text-blue-800" title="View Details">
                        <span class="material-icons">visibility</span>
                    </button>
                </td>
                </tr>
            @empty
                <tr>
                <td colspan="5" class="text-center text-gray-500 py-4">No vendors found.</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        </div>
        {{ $projects->links() }}

    </div>

    <!-- Main Modal -->
    <div x-show="activeProject" x-cloak class="fixed inset-0 bg-black/60 flex items-center justify-center z-50" x-transition>
        <div class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl p-8 relative animate-fade-in max-h-[90vh] overflow-y-auto" x-data="{ showTextarea: false }">
            <button @click="activeProject = null" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl">
                <span class="material-icons">close</span>
            </button>

            <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3" x-text="activeProject.project_name"></h2>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2 border-b pb-1">Project Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div><p class="font-semibold">📍 Location</p><p x-text="activeProject.project_location"></p></div>
                    <div><p class="font-semibold">📝 Description</p><p x-text="activeProject.project_description"></p></div>
                    <div><p class="font-semibold">💰 Budget</p><p x-text="activeProject.budget_range"></p></div>
                    <div><p class="font-semibold">⏱ Timeline</p><p x-text="activeProject.expected_timeline"></p></div>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2 border-b pb-1">Submission Info</h3>
                <p class="font-semibold text-sm">🧾 Submission ID:</p>
                <p x-text="activeProject.submission_id" class="text-sm"></p>

                <p class="font-semibold text-sm mt-2">📁Project Files:</p>
                <template x-if="activeProject.file_path">
                    <ul class="list-disc list-inside text-blue-600">
                        <template x-for="file in JSON.parse(activeProject.file_path)">
                            <li>
                                <a :href="`/${file}`" target="_blank" class="hover:underline" x-text="file.split('/').pop()"></a>
                            </li>
                        </template>
                    </ul>
                </template>

               <p class="font-semibold text-sm mt-2">📁 BOQ File:</p>
                <template x-if="activeProject.boqFile">
                    <ul class="list-disc list-inside text-blue-600">
                        <li>
                            <a 
                                :href="`/storage/boq_files/${activeProject.boqFile.split('/').pop()}`" 
                                download 
                                class="hover:underline text-blue-700 font-medium"
                                target="_blank">
                                Download BOQ File
                            </a>
                        </li>
                    </ul>
                </template>


            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2 border-b pb-1">Contact Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                    <div><p class="font-semibold">👤 Full Name</p><p x-text="activeProject.full_name"></p></div>
                    <div><p class="font-semibold">📧 Email</p><p x-text="activeProject.email"></p></div>
                    <div><p class="font-semibold">📱 Phone</p><p x-text="activeProject.phone_number"></p></div>
                </div>
            </div>

            <div class="mt-6 border-t pt-4">
                <div class="flex items-center gap-4">
                    <a href="#" @click.prevent="showCallModal = true" class="flex items-center text-white bg-green-600 px-4 py-2 rounded hover:bg-green-700">
                        <span class="material-icons mr-1">call</span> Call
                    </a>

                    <button @click="showTextarea = !showTextarea" class="flex items-center text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
                        <span class="material-icons mr-1">description</span> Description
                    </button>
                </div>

                <div class="mt-4" x-show="showTextarea" x-transition x-cloak>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Enter Remarks:</label>
                    <textarea rows="4" x-ref="remarks" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300" placeholder="Write something here..."></textarea>
                    <button @click="submitRemarks(activeProject.id, $refs.remarks.value)" class="mt-3 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Call Response Modal -->
    <div x-show="showCallModal" x-cloak class="fixed inset-0 bg-black/60 flex items-center justify-center z-50" x-transition>
        <div class="bg-white w-full max-w-md p-6 rounded-2xl shadow-lg animate-fade-in" x-data="{ callStatus: '', callRemarks: '' }">
            <button @click="showCallModal = false" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl">
                <span class="material-icons">close</span>
            </button>
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Call Status</h2>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Select Call Response</label>
                <select x-model="callStatus" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300">
                    <option value="">-- Select Response --</option>
                    <option value="1">Received</option>
                    <option value="2">Not Reachable</option>
                    <option value="3">Call Rejected</option>
                    <option value="4">Switched Off</option>
                    <option value="5">Wrong Number</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Remarks</label>
                <textarea x-model="callRemarks" rows="3" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring focus:border-blue-300" placeholder="Enter call remarks..."></textarea>
            </div>
            <button @click="submitCallResponse(activeProject.id, callStatus, callRemarks)" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">Submit Response</button>
        </div>
    </div>
</div>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>
<script>
  function submitRemarks(projectId, engg_decription) {
    if (!engg_decription.trim()) {
      alert("Please enter some remarks.");
      return;
    }

    $.ajax({
      url: '/engineer/project/update-remarks',
      type: 'POST',
      data: {
        _token: '{{ csrf_token() }}',
        id: projectId,
        engg_decription: engg_decription
      },
      success: function () {
        alert('Remarks updated successfully!');
        location.reload();
      },
      error: function () {
        alert('Error occurred while updating remarks.');
      }
    });
  }


  function submitCallResponse(projectId, callStatus, callRemarks) {
    if (!callStatus) {
        alert("Please select a call status.");
        return;
    }

    $.ajax({
        url: '/engineer/project/update-call-response',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            id: projectId,
            call_status: callStatus,
            call_remarks: callRemarks
        },
        success: function () {
            alert('Call response updated successfully!');
            location.reload();
        },
        error: function () {
            alert('Error occurred while updating call response.');
        }
    });
}

 
</script>
@endsection
