@extends('layouts.admin.app')
@section('title', 'Vendor Category')
@section('content')
<div class="max-w-4xl mx-auto">
  <div class="bg-white p-6 rounded shadow mt-8">
    <h2 class="text-xl font-semibold mb-4">Add New Vendor Category</h2>

    <div id="success-message" class="hidden bg-green-100 text-green-800 p-3 rounded mb-4"></div>

    <form id="categoryForm">
      @csrf
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-end">

        <!-- Category Dropdown -->
        <div>
          <label for="categories_id" class="block text-sm font-medium text-gray-700">Category</label>
          <select name="categories_id" id="categories_id" class="select2 w-full px-4 py-2 border rounded" required>
            <option value="">Select a Category</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>

        <!-- Project Type Dropdown -->
        <div>
          <label for="project_types_id" class="block text-sm font-medium text-gray-700">Project Type</label>
          <select name="project_types_id" id="project_types_id" class="select2 w-full px-4 py-2 border rounded" required>
            <option value="">Select a Project Type</option>
            @foreach($project_types as $pt)
              <option value="{{ $pt->id }}">{{ $pt->name }}</option>
            @endforeach
          </select>
        </div>

        <!-- Sub Category Dropdown -->
        <div>
          <label for="const_sub_cat_id" class="block text-sm font-medium text-gray-700">Sub Category</label>
          <select name="const_sub_cat_id" id="const_sub_cat_id" class="select2 w-full px-4 py-2 border rounded" required>
            <option value="">Select a Sub Category</option>
            @foreach($construction_sub_categories as $sub)
              <option value="{{ $sub->id }}">{{ $sub->name }}</option>
            @endforeach
          </select>
        </div>

        <!-- Submit Button -->
        <div>
          <button type="submit" class="w-full bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
            Add
          </button>
        </div>
      </div>
    </form>

    <table class="mt-6 w-full table-auto border-collapse border border-gray-200 text-sm" id="categoryTable">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-4 py-2">#</th>
          <th class="border px-4 py-2">Category</th>
          <th class="border px-4 py-2">Project Type</th>
          <th class="border px-4 py-2">Sub Category</th>
          <th class="border px-4 py-2">Action</th>
        </tr>
      </thead>
     
      <tbody id="categoryTableBody">
        @php $i = 1; @endphp
        @foreach($entries as $entry)
            <tr>
                <td class="border px-4 py-2">{{ $loop->iteration + ($entries->currentPage() - 1) * $entries->perPage() }}</td>
                <td class="border px-4 py-2">{{ $entry->category }}</td>
                <td class="border px-4 py-2">{{ $entry->project_type }}</td>
                <td class="border px-4 py-2">{{ $entry->sub_category }}</td>
                <td class="border px-4 py-2">
                    <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Delete</button>
                </td>
            </tr>
        @endforeach

      </tbody>

    </table>
    <div class="mt-4">
    {{ $entries->links() }}
</div>

  </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(document).ready(function () {
    $('.select2').select2({
      placeholder: 'Select an option',
      allowClear: true,
      width: 'resolve'
    });

    $('#categoryForm').on('submit', function (e) {
      e.preventDefault();

      $.ajax({
        url: '{{ route("project.cat.type.store") }}',
        type: 'POST',
        data: {
          _token: '{{ csrf_token() }}',
          categories_id: $('#categories_id').val(),
          project_types_id: $('#project_types_id').val(),
          const_sub_cat_id: $('#const_sub_cat_id').val(),
        },
        success: function (response) {
          $('#success-message')
            .removeClass('hidden')
            .text(response.message)
            .show();

          let index = $('#categoryTableBody tr').length + 1;

          $('#categoryTableBody').append(`
            <tr>
              <td class="border px-4 py-2">${index}</td>
              <td class="border px-4 py-2">${response.category}</td>
              <td class="border px-4 py-2">${response.project_type}</td>
              <td class="border px-4 py-2">${response.sub_category}</td>
              <td class="border px-4 py-2">
                <button class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700">Delete</button>
              </td>
            </tr>
          `);

          $('#categoryForm')[0].reset();
          $('.select2').val(null).trigger('change');
        },
        error: function (xhr) {
          let errors = xhr.responseJSON.errors;
          alert(Object.values(errors).join('\n'));
        }
      });
    });
  });
</script>
@endsection
