@extends('layouts.admin.app')

@section('title', 'Vendor Category')

@section('content')
<div class="max-w-4xl mx-auto ">
  <div class="bg-white p-6 rounded shadow mt-8">
    <h2 class="text-xl font-semibold mb-4">Add New Vendor Category</h2>

    <div id="success-message" class="hidden bg-green-100 text-green-800 p-3 rounded mb-4"></div>

    <form id="categoryForm">
      @csrf
      <div class="flex flex-col sm:flex-row gap-4">
        <div class="w-full sm:w-2/3">
          <input type="text" name="category" id="category" placeholder="Enter Vendor category"
                 class="w-full px-4 py-2 border rounded" required>
          <p id="error-message" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>
        <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
          Add
        </button>
      </div>
    </form>
    <table class="mt-6 w-full table-auto border-collapse border border-gray-200 text-sm" id="categoryTable">
        <thead class="bg-gray-100">
            <tr>
            <th class="border px-4 py-2">#</th>
            <th class="border px-4 py-2">Category</th>
            <th class="border px-4 py-2">Action</th>
            </tr>
        </thead>
        <tbody id="categoryTableBody">
            @foreach ($categories as $index => $category)
                <tr id="row-{{ $category->id }}">
                <td class="border px-4 py-2">{{ $index + 1 }}</td>
                <td class="border px-4 py-2">{{ $category->name }}</td>
                <td class="border px-4 py-2">
                    <button data-id="{{ $category->id }}" class="delete-btn bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">
                    Delete
                    </button>
                </td>
                </tr>
            @endforeach
        </tbody>


    </table>
    
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function () {
    $('#categoryForm').on('submit', function (e) {
      e.preventDefault();

      let category = $('#category').val();
      let token = $('input[name="_token"]').val();

      $.ajax({
        url: '{{ route("categorystore") }}', // Make sure this matches your route name
        method: 'POST',
        data: {
          _token: token,
          category: category
        },
      success: function (response) {
        // Show success message
        $('#success-message')
            .removeClass('hidden')
            .text(response.message);

        // Clear input and error
        $('#category').val('');
        $('#error-message').addClass('hidden').text('');

        // Append new row to table
        let newIndex = $('#categoryTableBody tr').length + 1;
        $('#categoryTableBody').append(`
            <tr id="row-${response.category.id}">
            <td class="border px-4 py-2">${newIndex}</td>
            <td class="border px-4 py-2">${response.category.name}</td>
            <td class="border px-4 py-2">
                <button data-id="${response.category.id}" class="delete-btn bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">
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

    if (confirm('Are you sure you want to delete this category?')) {
      $.ajax({
        url: '/category/delete/' + id, // or use route if named
        method: 'POST',
        data: {
          _token: token
        },
        success: function (response) {
          $('#row-' + id).remove();
          $('#success-message')
            .removeClass('hidden')
            .text('Category deleted successfully!');
        },
        error: function () {
          alert('Failed to delete. Try again.');
        }
      });
    }
  });
</script>


@endsection
