@extends('layouts.app') {{-- or your actual layout file --}}

@section('title', 'Login')

<div class="min-h-screen flex items-center justify-center bg-gray-100">
  <div class="max-w-md w-full bg-white p-8 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-center">Login to BuildXO</h2>

    <form id="loginForm">
      @csrf

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg" />
      </div>

      <div class="mb-4">
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" required class="w-full px-4 py-2 border rounded-lg" />
      </div>

      <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">Login</button>
    </form>
  </div>
</div>

<script>
  document.getElementById('loginForm').addEventListener('submit', function (e) {
  e.preventDefault();

  const form = e.target;
  const formData = new FormData(form);

  fetch('{{ route("vender.login") }}', {
    method: 'POST',
    headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
    body: formData
  })
  .then(res => res.json())
  .then(data => {
    if (data.status === 'success') {
      if (data.role == 1) {
        window.location.href = '{{ route("admin_dashboard") }}';
      } else if (data.role == 0) {
        window.location.href = '{{ route("vendor_dashboard") }}';
      } else {
        alert('Unknown role');
      }
    } else {
      alert(data.message || 'Login failed');
    }
  })
  .catch((error) => {
    console.error('Error:', error);
    alert('Something went wrong!');
  });
});


</script>
@endsection
