<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - BuildXO</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
  <div class="card shadow rounded-4 p-4 w-100" style="max-width: 400px;">
    <h2 class="text-center mb-4">Login to BuildXO</h2>

    <form id="loginForm">
      @csrf

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

</body>
</html>
