@extends('layouts.admin.app')

@section('title', 'Project Type')

@section('content')
<div class="max-w-4xl mx-auto ">
  <div class="bg-white p-6 rounded shadow mt-8">
    <h2 class="text-xl font-semibold mb-4">Add New Construction Sub Category</h2>

    <div id="success-message" class="hidden bg-green-100 text-green-800 p-3 rounded mb-4"></div>

    <form id="projecttypeForm">
      @csrf
      <div class="flex flex-col sm:flex-row gap-4">


        <div class="w-full sm:w-2/3">
          <input type="text" name="name" id="name" placeholder="Enter Project type"
                 class="w-full px-4 py-2 border rounded" required>
          <p id="error-message" class="text-red-500 text-sm mt-1 hidden"></p>
        </div>
        <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
          Add
        </button>
      </div>
    </form>
    <table class="mt-6 w-full table-auto border-collapse border border-gray-200 text-sm" id="projectTypeTable">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2">Category</th>
                <th class="border px-4 py-2">Action</th>

            </tr>
        </thead>
        <tbody id="projectTypeTableBody">
            @foreach($subcategories as $index => $sub)
            <tr id="row-{{ $sub->id }}">
               <td class="border px-4 py-2">{{ $subcategories->firstItem() + $index }}</td>
                <td class="border px-4 py-2">{{ $sub->name }}</td>
                <td class="border px-4 py-2">
                    <button data-id="{{ $sub->id }}" class="delete-btn bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>


    </table>
    <!-- Add this after the table -->
    <div class="mt-4">
        {{ $subcategories->links('pagination::tailwind') }}
    </div>

  </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function () {
 
    $('#projecttypeForm').on('submit', function (e) {
        e.preventDefault();

        let name = $('#name').val();
        let projectTypeId = $('#project_type').val();
        let categoryId = $('#category').data('id');
        let token = $('input[name="_token"]').val();

        $.ajax({
            url: '{{ route("subcategory.store") }}',
            method: 'POST',
            data: {
                _token: token,
                name: name,
                project_type: projectTypeId,
                category_id: categoryId
            },
            success: function (response) {
                $('#success-message').removeClass('hidden').text(response.message);
                $('#name').val('');
                $('#project_type').val('');
                $('#category').val('');

                let newIndex = $('#projectTypeTableBody tr').length + 1;
                $('#projectTypeTableBody').append(`
                    <tr id="row-${response.id}">
                        <td class="border px-4 py-2">${newIndex}</td>
                        <td class="border px-4 py-2">${response.category}</td>
                        <td class="border px-4 py-2">${response.project_type}</td>
                        <td class="border px-4 py-2">${response.name}</td>
                        <td class="border px-4 py-2">
                            <button data-id="${response.id}" class="delete-btn bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Delete</button>
                        </td>
                    </tr>
                `);
            },
            error: function (xhr) {
                let error = xhr.responseJSON?.message || 'Something went wrong.';
                $('#error-message').removeClass('hidden').text(error);
                $('#success-message').addClass('hidden');
            }
        });
    });

    // Delete row
    $(document).on('click', '.delete-btn', function () {
        let id = $(this).data('id');
        let token = $('input[name="_token"]').val();

        if (confirm('Are you sure you want to delete this subcategory?')) {
            $.ajax({
                url: '/subcategory/delete/' + id,
                method: 'POST',
                data: { _token: token },
                success: function (response) {
                    $('#row-' + id).remove();
                    $('#success-message').removeClass('hidden').text(response.message);
                },
                error: function () {
                    alert('Failed to delete. Try again.');
                }
            });
        }
    });
});
</script>


@endsection