@extends('layouts.engg.app')
@section('title', 'Projects List')
@section('content')
<style>
   .animate-fade-in {
     animation: fadeIn 0.3s ease-out;
   }
   @keyframes fadeIn {
     from { opacity: 0; transform: scale(0.95); }
     to { opacity: 1; transform: scale(1); }
   }
</style>

<div class="max-w-6xl mx-auto px-6"
     x-data="{
        activeProject: null,
        boqFiles: [],
        handleFileUpload(event) {
            this.boqFiles = event.target.files.length ? [event.target.files[0]] : [];
        },
        submitBOQFiles() {
            if (!this.activeProject?.id) {
                alert('Invalid project.');
                return;
            }
            if (!this.boqFiles.length) {
                alert('Please select a file.');
                return;
            }

            const formData = new FormData();
            formData.append('_token', '{{ csrf_token() }}');
            formData.append('project_id', this.activeProject.id);
            formData.append('files[]', this.boqFiles[0]);

            fetch('/engineer/project/upload-boq', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert('BOQ uploaded and inserted successfully!');
                location.reload();
            })
            .catch(error => {
                console.error(error);
                alert('Upload failed!');
            });
        }
     }"
>
   <!-- Project List -->
   <div class="bg-white p-6 rounded shadow-md mt-8">
      <h2 class="text-xl font-semibold mb-4">Projects List</h2>
      @if(session('success'))
      <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
         {{ session('success') }}
      </div>
      @endif
      <div class="overflow-x-auto">
         <table class="min-w-full table-auto border border-collapse text-sm">
            <thead class="bg-gray-100">
               <tr>
                  <th class="border px-4 py-2">#</th>
                  <th class="border px-4 py-2">Project Name</th>
                  <th class="border px-4 py-2">Address</th>
                  <th class="border px-4 py-2">Description</th>
                  <th class="border px-4 py-2">Action</th>
               </tr>
            </thead>
            <tbody class="text-gray-700">
               @forelse($projects as $index => $project)
               <tr class="hover:bg-gray-50">
                  <td class="border px-4 py-2">{{ $index + 1 }}</td>
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
   </div>

   <!-- Modal -->
   <div x-show="activeProject" x-cloak class="fixed inset-0 bg-black/60 flex items-center justify-center z-50" x-transition>
      <div class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl p-8 relative animate-fade-in max-h-[90vh] overflow-y-auto">
         <button @click="activeProject = null" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl">
            <span class="material-icons">close</span>
         </button>

         <h2 class="text-2xl font-bold text-gray-800 mb-6 border-b pb-3" x-text="activeProject.project_name"></h2>

         <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2 border-b pb-1">Project Info</h3>
            <p class="font-semibold text-sm">🧾 Submission ID:</p>
            <p x-text="activeProject.submission_id" class="text-sm"></p>

            <p class="font-semibold text-sm mt-2">📁 Project Files:</p>
            <template x-if="activeProject.file_path">
               <ul class="list-disc list-inside text-blue-600">
                  <template x-for="file in JSON.parse(activeProject.file_path)">
                     <li>
                        <a :href="`/${file}`" target="_blank" class="hover:underline" x-text="file.split('/').pop()"></a>
                     </li>
                  </template>
               </ul>
            </template>
         </div>

         <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-2 border-b pb-1">Contact Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
               <div>
                  <p class="font-semibold">👤 Full Name</p>
                  <p x-text="activeProject.full_name"></p>
               </div>
               <div>
                  <p class="font-semibold">📧 Email</p>
                  <p x-text="activeProject.email"></p>
               </div>
               <div>
                  <p class="font-semibold">📱 Phone</p>
                  <p x-text="activeProject.phone_number"></p>
               </div>
            </div>
         </div>

         <!-- BOQ Upload Section -->
         <div class="mt-6 border-t pt-4">
            <div class="flex items-center gap-4">
               <button @click="$refs.fileInput.click()" 
                       class="flex items-center text-white bg-blue-600 px-4 py-2 rounded hover:bg-blue-700">
                  <span class="material-icons mr-1">description</span> Boq Upload
               </button>
            </div>

            <input type="file" 
                   class="hidden" 
                   x-ref="fileInput" 
                   @change="handleFileUpload"
                   accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">

            <div class="mt-4" x-show="boqFiles.length > 0" x-transition>
               <h4 class="text-sm font-medium text-gray-700 mb-2">Selected Files:</h4>
               <ul class="list-disc list-inside text-sm text-gray-600 space-y-1">
                  <template x-for="file in boqFiles" :key="file.name">
                     <li x-text="file.name"></li>
                  </template>
               </ul>

               <button @click="submitBOQFiles()"
                       class="mt-3 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded shadow">
                  Submit
               </button>
            </div>
         </div>

      </div>
   </div>
</div>

<!-- Scripts -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endsection
