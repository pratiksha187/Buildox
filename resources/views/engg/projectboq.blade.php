@extends('layouts.engg.app')

@section('title', 'Dashboard')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.tailwindcss.com" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <style>
        .animate-fade-in {
            animation: fadeIn 0.3s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>

<body class="bg-gray-100">

<div class="max-w-6xl mx-auto px-6 py-10">
    <div class="bg-white p-6 rounded shadow-md">
        <h2 class="text-xl font-semibold mb-4">Projects List</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">Id</th>
                        <th class="border px-4 py-2">Project Name</th>
                        <th class="border px-4 py-2">Address</th>
                        <th class="border px-4 py-2">Description</th>
                        <th class="border px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody id="projectBody"></tbody>
            </table>
        </div>
    </div>
</div>

<!-- Project Modal -->
<div id="projectModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-50">
    <div class="bg-white w-full max-w-5xl rounded-2xl shadow-2xl p-8 relative animate-fade-in max-h-[90vh] overflow-y-auto">
        <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-xl">
            <span class="material-icons">close</span>
        </button>

        <h2 id="modalTitle" class="text-2xl font-bold mb-6 border-b pb-3"></h2>
        <p class="text-sm font-semibold">Submission ID:</p>
        <p id="modalSubmissionId" class="text-sm"></p>
        <p class="text-sm font-semibold mt-2">Description:</p>
        <p id="modalDescription" class="text-sm"></p>

        <p class="text-sm font-semibold mt-2">Project Files:</p>
        <ul id="modalFiles" class="list-disc list-inside text-blue-600"></ul>

        <p class="text-sm font-semibold mt-2">BOQ File:</p>
        <ul id="modalBoqFile" class="list-disc list-inside text-blue-600"></ul>

        <div class="mt-4 border-t pt-4 space-y-4">
            <div class="flex items-center gap-4">
                <button onclick="document.getElementById('boqInput').click()" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Upload BOQ</button>
                <button onclick="toggleTenderModal(true)" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">➕ Add Tender</button>
            </div>
            <input type="file" id="boqInput" class="hidden" accept=".csv, application/vnd.ms-excel, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet">
            <ul id="boqFileList" class="list-disc list-inside text-sm text-gray-600"></ul>
            <button id="submitBoqBtn" onclick="submitBOQFiles()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded mt-2 hidden">Submit BOQ</button>
        </div>
    </div>
</div>

<!-- Tender Modal -->
<div id="tenderModal" class="fixed inset-0 bg-black/60 hidden items-center justify-center z-[999]">
    <div class="bg-white w-full max-w-4xl rounded-xl p-6 relative overflow-y-auto max-h-[90vh] space-y-6">
        <button onclick="toggleTenderModal(false)" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-xl">
            <span class="material-icons">close</span>
        </button>
        <h2 class="text-xl font-semibold text-gray-800">Add Tender Details</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="tenderFormFields"></div>
        <div class="text-right">
            <button onclick="submitTender()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Submit Tender</button>
        </div>
    </div>
</div>

<script>
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const projectList = @json($projects);
renderProjects();
    let activeProject = null;
    let boqFiles = [];
    const tenderForm = {
        tender_value: '',
        product_category: '',
        sub_category: '',
        contract_type: '',
        bid_validity_days: '',
        period_of_work_days: '',
        location: '',
        pincode: '',
        published_date: '',
        bid_opening_date: '',
        bid_submission_start: '',
        bid_submission_end: ''
    };

    function renderProjects() {
        const tbody = document.getElementById('projectBody');
        tbody.innerHTML = '';
        projectList.forEach((proj, idx) => {
            tbody.innerHTML += `
                <tr class="hover:bg-gray-50">
                    <td class="border px-4 py-2">${idx + 1}</td>
                    <td class="border px-4 py-2">${proj.project_name}</td>
                    <td class="border px-4 py-2">${proj.project_location}</td>
                    <td class="border px-4 py-2">${proj.project_description}</td>
                    <td class="border px-4 py-2 text-center">
                        <button onclick='openModal(${JSON.stringify(proj)})' class="text-blue-600 hover:text-blue-800">
                            <span class="material-icons">visibility</span>
                        </button>
                    </td>
                </tr>`;
        });
    }

    function openModal(project) {
        activeProject = project;
        document.getElementById('modalTitle').textContent = project.project_name;
        document.getElementById('modalSubmissionId').textContent = project.submission_id;
        document.getElementById('modalDescription').textContent = project.project_description;

        const files = JSON.parse(project.file_path || '[]');
        const filesList = document.getElementById('modalFiles');
        filesList.innerHTML = files.map(file => `<li><a href="/${file}" target="_blank">${file.split('/').pop()}</a></li>`).join('');

        const boqFileList = document.getElementById('modalBoqFile');
        boqFileList.innerHTML = project.boqFile ? `<li><a href="/storage/boq_files/${project.boqFile.split('/').pop()}" target="_blank">Download BOQ File</a></li>` : '';

        document.getElementById('projectModal').classList.remove('hidden');
        document.getElementById('projectModal').classList.add('flex');
    }

    function closeModal() {
        document.getElementById('projectModal').classList.add('hidden');
        document.getElementById('projectModal').classList.remove('flex');
        boqFiles = [];
        document.getElementById('boqFileList').innerHTML = '';
        document.getElementById('submitBoqBtn').classList.add('hidden');
    }

    document.getElementById('boqInput').addEventListener('change', function (e) {
        boqFiles = Array.from(e.target.files);
        const list = document.getElementById('boqFileList');
        list.innerHTML = boqFiles.map(f => `<li>${f.name}</li>`).join('');
        document.getElementById('submitBoqBtn').classList.remove('hidden');
    });

    function submitBOQFiles() {
        if (!activeProject?.id) return alert('Invalid project.');
        if (!boqFiles.length) return alert('Please select a file.');

        const formData = new FormData();
        formData.append('_token', CSRF_TOKEN);
        formData.append('project_id', activeProject.id);
        formData.append('files[]', boqFiles[0]);

        fetch('/engineer/project/upload-boq', {
            method: 'POST',
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            alert('BOQ uploaded successfully!');
            location.reload();
        })
        .catch(err => {
            console.error(err);
            alert('Upload failed!');
        });
    }

    function toggleTenderModal(show) {
        const modal = document.getElementById('tenderModal');
        modal.classList.toggle('hidden', !show);
        modal.classList.toggle('flex', show);

        if (show) {
            const fieldsContainer = document.getElementById('tenderFormFields');
            fieldsContainer.innerHTML = '';
            for (const key in tenderForm) {
                const isDateField = ['published_date', 'bid_opening_date', 'bid_submission_start', 'bid_submission_end'].includes(key);
                fieldsContainer.innerHTML += `
                    <div>
                        <label class="block text-sm font-medium capitalize text-gray-700">${key.replace(/_/g, ' ')}</label>
                        <input type="${isDateField ? 'date' : 'text'}"
                            class="w-full border rounded px-3 py-2"
                            id="tender-${key}"
                            value="${tenderForm[key]}" />
                    </div>`;
            }
        }
    }

    function submitTender() {
        if (!activeProject?.id) return alert('Invalid project');
        for (const key in tenderForm) {
            tenderForm[key] = document.getElementById(`tender-${key}`).value;
        }

        const payload = {
            ...tenderForm,
            project_id: activeProject.id,
            _token: CSRF_TOKEN
        };

        fetch('/engineer/project/tender', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            alert(data.message || 'Tender submitted!');
            toggleTenderModal(false);
        })
        .catch(err => {
            console.error(err);
            alert('Tender submission failed.');
        });
    }

    renderProjects();
</script>

@endsection