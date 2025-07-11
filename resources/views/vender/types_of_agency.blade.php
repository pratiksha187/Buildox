@extends('layouts.vendor.app')

@section('title', 'Select Your Role')

@section('content')
<title>Select Your Service Type</title>
<script src="https://cdn.tailwindcss.com"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">

  <div class="bg-white p-8 rounded-2xl shadow-md w-full">
    <h2 class="text-2xl font-bold text-gray-900 mb-2">Select Your Service Type</h2>
    <p class="text-gray-600 mb-6">Choose the category that best describes your agency. Then select the services you provide.</p>

    <form id="serviceForm" method="POST" action="#">
      @csrf
      <div class="mb-6">
        <label for="agencyType" class="block text-sm font-medium text-gray-700 mb-1">Select Type of Agency:</label>
        <select id="agencyType" name="agencyType" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="">-- Select --</option>
          @foreach ($agencyTypes as $agency)
            <option value="{{ $agency->id }}">{{ $agency->name }}</option>
          @endforeach
        </select>
        <p id="agencyError" class="text-red-500 text-sm mt-2 hidden">You can select only one agency type.</p>
      </div>
      <div id="servicesContainer" class="mb-6 hidden">
        <label class="block text-sm font-medium text-gray-700 mb-2">Select Services:</label>
        <div id="checkboxList" class="space-y-2 pl-1">
       
        </div>
      </div>

      <div id="othersTextboxContainer" class="hidden">
        <input type="text" name="other_service" id="other_service" placeholder="Please specify" class="mt-2 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
      </div>
      <div class="flex justify-between">
        <button type="button" id="resetBtn" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200">Back</button>
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">Continue</button>
      </div>
    </form>
  </div>

  <script>
    let agencyLocked = false;

   
    document.getElementById('agencyType').addEventListener('change', function () {
      const errorBox = document.getElementById('agencyError');

      if (agencyLocked) {
        errorBox.classList.remove('hidden');
        this.value = agencyLocked; // Reset to previous value
        return;
      } else {
        errorBox.classList.add('hidden');
      }

      const agencyId = this.value;
      if (!agencyId) return;

      agencyLocked = agencyId; // Lock agency selection

      const servicesContainer = document.getElementById('servicesContainer');
      const checkboxList = document.getElementById('checkboxList');

      fetch(`/get-services/${agencyId}`)
        .then(response => response.json())
        .then(data => {
          checkboxList.innerHTML = ''; // Clear old services

          if (Object.keys(data).length > 0) {
            servicesContainer.classList.remove('hidden');

            for (const [id, name] of Object.entries(data)) {
              const checkboxWrapper = document.createElement('div');
              checkboxWrapper.className = 'flex items-center';

              const isOthers = name.trim().toLowerCase() === 'others';
              const checkboxId = `service_${id}`;

              checkboxWrapper.innerHTML = `
                <input type="checkbox" id="${checkboxId}" name="services[]" value="${id}" class="mr-2">
                <label for="${checkboxId}">${name}</label>
              `;

              checkboxList.appendChild(checkboxWrapper);

              if (isOthers) {
                const textboxContainer = document.createElement('div');
                textboxContainer.id = 'othersTextboxContainer';
                textboxContainer.className = 'hidden w-full mt-2';
                textboxContainer.innerHTML = `
                  <input type="text" name="other_service" id="other_service" placeholder="Please specify" 
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200">
                `;
                checkboxList.appendChild(textboxContainer);

                // Add change event listener to this checkbox
                setTimeout(() => {
                  const othersCheckbox = document.getElementById(checkboxId);
                  othersCheckbox.addEventListener('change', function () {
                    textboxContainer.classList.toggle('hidden', !this.checked);
                  });
                }, 0);
              }
            }
          } else {
            servicesContainer.classList.add('hidden');
          }
        });
    });

    document.getElementById('serviceForm').addEventListener('submit', function (e) {
    e.preventDefault();

    const agencyType = document.getElementById('agencyType').value;
    const selectedServices = Array.from(document.querySelectorAll('input[name="services[]"]:checked')).map(cb => cb.value);
    const otherServiceInput = document.getElementById('other_service');
    const otherService = otherServiceInput ? otherServiceInput.value.trim() : null;

    fetch("{{ route('save.agency.services') }}", {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({
        agency_type: agencyType,
        services: selectedServices,
        other_service: otherService
      })
    })
      .then(response => response.json())
      .then(data => {
        if (data.status === 'success') {
          alert(data.message || 'Saved successfully');
          window.location.href = '{{ route("about_business") }}';
        } else {
          alert(data.message || 'Save failed');
        }
      })
      .catch(() => {
        alert('Something went wrong!');
      });
    });

    document.getElementById('resetBtn').addEventListener('click', function () {
      agencyLocked = false;
      document.getElementById('agencyType').value = "";
      document.getElementById('agencyError').classList.add('hidden');
      document.getElementById('checkboxList').innerHTML = "";
      document.getElementById('servicesContainer').classList.add('hidden');
    });
  </script>

@endsection

