@extends('layouts.admin.app')

@section('title', 'Costomer role')

@section('content')
<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-md">
  <h2 class="text-2xl font-bold text-gray-800 mb-6">Add New Roles</h2>

  <div id="success-message" class="hidden bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-sm"></div>

  <form id="roleForm" class="mb-6">
    @csrf
    <div class="flex flex-col sm:flex-row gap-4">
      <div class="w-full sm:flex-1">
        <input type="text" name="role" id="role" placeholder="Enter Vendor role"
               class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-blue-400" required>
        <p id="error-message" class="text-red-500 text-sm mt-1 hidden"></p>
      </div>
      <button type="submit"
              class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
        Add
      </button>
    </div>
  </form>

  <div class="overflow-x-auto">
    <table class="w-full table-auto text-sm border border-gray-200">
      <thead class="bg-gray-100 text-left">
        <tr>
          <th class="px-4 py-2 border">#</th>
          <th class="px-4 py-2 border">Role</th>
          <th class="px-4 py-2 border">Action</th>
        </tr>
      </thead>
      <tbody id="roleTableBody">
        @foreach ($role as $index => $roles)
          <tr id="row-{{ $roles->id }}">
            <td class="px-4 py-2 border">{{ ($role->currentPage() - 1) * $role->perPage() + $loop->iteration }}</td>
            <td class="px-4 py-2 border">{{ $roles->role }}</td>
            <td class="px-4 py-2 border">
              <button data-id="{{ $roles->id }}" class="delete-btn bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                Delete
              </button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $role->links() }}
  </div>
</div>
@endsection


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#roleForm').on('submit', function (e) {
      e.preventDefault();

      let role = $('#role').val();
      let token = $('input[name="_token"]').val();

      $.ajax({
        url: '{{ route("rolestore") }}', // Make sure this matches your route name
        method: 'POST',
        data: {
          _token: token,
          role: role
        },
      success: function (response) {
        // Show success message
        $('#success-message')
            .removeClass('hidden')
            .text(response.message);

        // Clear input and error
        $('#role').val('');
        $('#error-message').addClass('hidden').text('');

        // Append new row to table
        let newIndex = $('#roleTableBody tr').length + 1;
        $('#roleTableBody').append(`
            <tr id="row-${response.role.id}">
            <td class="border px-4 py-2">${newIndex}</td>
            <td class="border px-4 py-2">${response.role.role}</td>
            <td class="border px-4 py-2">
                <button data-id="${response.role.id}" class="delete-btn bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">
                Delete
                </button>
            </td>
            </tr>
        `);
        },

        error: function (xhr) {
          let error = xhr.responseJSON?.message || 'Something went wrong.';
          $('#error-message')
            .removeClass('hidden')
            .text(error);
          $('#success-message').addClass('hidden');
        }
      });
    });
  });
</script>
<script>
  $(document).on('click', '.delete-btn', function () {
    let id = $(this).data('id');
    let token = $('input[name="_token"]').val();

    if (confirm('Are you sure you want to delete this role?')) {
      $.ajax({
        url: '/role/delete/' + id, // or use route if named
        method: 'POST',
        data: {
          _token: token
        },
        success: function (response) {
          $('#row-' + id).remove();
          $('#success-message')
            .removeClass('hidden')
            .text('role deleted successfully!');
        },
        error: function () {
          alert('Failed to delete. Try again.');
        }
      });
    }
  });
</script>

