<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background: #f2f6fc;
      font-family: 'Segoe UI', sans-serif;
    }
    .card {
      border: none;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }
    .form-control:focus {
      box-shadow: none;
      border-color: #4a90e2;
    }
    .btn-primary {
      background-color: #4a90e2;
      border: none;
    }
  </style>
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="col-md-6 col-lg-5">
    <div class="card p-4 rounded">
      <h4 class="text-center mb-4">🚀 Create an Account</h4>

      <!-- Flash messages -->
      @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
      @endif

      @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      <form method="POST" action="/register">
        @csrf

        <div class="mb-3">
          <label for="name" class="form-label">Full Name</label>
          <input type="text" name="name" class="form-control" id="name" required placeholder="John Doe" />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <input type="email" name="email" class="form-control" id="email" required placeholder="you@example.com" />
        </div>

        <div class="mb-3">
          <label for="password" class="form-label">Create Password</label>
          <input type="password" name="password" class="form-control" id="password" required placeholder="••••••••" />
        </div>

        <!-- New dropdown for role -->
        <div class="mb-3">
          <label for="login_as" class="form-label">Select Role</label>
          <select name="login_as" id="login_as" class="form-select" required>
            <option value="" disabled selected>Choose role</option>
            <option value="1">Admin</option>
            <option value="2">Engineer</option>
          </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>

        <p class="mt-3 text-center text-muted">
          Already have an account? <a href="/login">Login</a>
        </p>
      </form>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
