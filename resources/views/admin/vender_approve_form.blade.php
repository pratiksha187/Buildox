@extends('layouts.admin.app')

@section('title', 'Vendor Approve')

@section('content')
<div class="max-w-6xl mx-auto px-6">
  <div class="bg-white p-6 rounded shadow-md mt-8">
    <h2 class="text-xl font-semibold mb-4">Registered Vendors</h2>

    {{-- Optional success message --}}
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
            <th class="border px-4 py-2">Company Name</th>
            <th class="border px-4 py-2">Address</th>
            <th class="border px-4 py-2">Experience Years</th>
            <th class="border px-4 py-2">Action</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          @forelse($vendors as $index => $vendor)
            <tr class="hover:bg-gray-50">
              <td class="border px-4 py-2">{{ $index + 1 }}</td>
              <td class="border px-4 py-2">{{ $vendor->company_name }}</td>
              <td class="border px-4 py-2">{{ $vendor->registered_address }}</td>
              <td class="border px-4 py-2">{{ $vendor->experience_years }}</td>
              <td class="border px-4 py-2">
               
                <select class="status-dropdown border rounded px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        data-id="{{ $vendor->id }}">
                    <option value="">-- Select --</option>
                    <option value="1">Approve</option>
                    <option value="2">Reject</option>
                </select>
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
</div>
<script src="https://cdn.tailwindcss.com"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  $(document).ready(function () {
    $('.status-dropdown').change(function () {
      var vendorId = $(this).data('id');
      var status = $(this).val();

      if (status !== '') {
        $.ajax({
          url: '/admin/vendors/' + vendorId + '/update-status', // Route URL
          type: 'POST',
          data: {
            _token: '{{ csrf_token() }}',
            status: status
          },
          success: function (response) {
            alert(response.message);
            location.reload(); // Optional: refresh table
          },
          error: function (xhr) {
            alert('Something went wrong.');
            console.error(xhr.responseText);
          }
        });
      }
    });
  });
</script>

@endsection
