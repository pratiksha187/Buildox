@extends('layouts.vendor.app')

@section('title', 'Verification Pending | ConstructKaro')

@section('content')
<!-- Styles -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    background: linear-gradient(to bottom right, #f7f7f7, #ffffff);
    font-family: 'Segoe UI', sans-serif;
    color: #111827; /* Dark black from logo */
  }

  .main-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 40px;
    max-width: 900px;
    margin: 80px auto 40px;
    box-shadow: 0 10px 40px rgba(17, 24, 39, 0.1); /* subtle black shadow */
  }

  .card-option {
    background: #fff7f1; /* very light orange background */
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    border: 1px solid #ffb085; /* lighter orange border */
    transition: all 0.3s ease;
    height: 100%;
  }

  .card-option:hover {
    transform: translateY(-6px);
    box-shadow: 0 8px 20px rgba(255, 92, 0, 0.3); /* orange shadow on hover */
  }

  .card-option .icon {
    background: #ff5c00; /* orange from logo */
    color: #ffffff;
    font-size: 28px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 15px;
  }

  .info-message {
    background: #fff4e6; /* light orange background */
    color: #ff5c00; /* orange text */
    padding: 15px 20px;
    border-radius: 8px;
    text-align: center;
    margin-top: 40px;
    font-size: 15px;
  }

  .logout-btn {
    position: absolute;
    top: 20px;
    right: 30px;
  }

  .logout-btn button {
    border-color: #ff5c00;
    color: #ff5c00;
  }
  .logout-btn button:hover {
    background-color: #ff5c00;
    color: #fff;
    border-color: #ff5c00;
  }

  footer {
    text-align: center;
    padding: 30px 0;
    font-size: 14px;
    color: #6b7280;
  }

  footer a {
    color: #ff5c00;
    margin: 0 10px;
    text-decoration: none;
  }

  footer a:hover {
    text-decoration: underline;
  }

  .btn-primary {
    background-color: #ff5c00;
    border-color: #ff5c00;
  }
  .btn-primary:hover {
    background-color: #cc4900;
    border-color: #cc4900;
  }

  .btn-outline-success {
    color: #ff5c00;
    border-color: #ff5c00;
  }
  .btn-outline-success:hover {
    background-color: #ff5c00;
    color: #fff;
    border-color: #ff5c00;
  }
</style>

<!-- Logout Button -->
<form method="POST" action="{{ route('logout') }}" class="logout-btn">
  @csrf
  <button type="submit" class="btn btn-sm btn-outline-light">
    <i class="bi bi-box-arrow-right me-1"></i> Log out
  </button>
</form>

<!-- Main Content Card -->
<div class="container main-card">
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h4 class="fw-semibold mb-1">Welcome to ConstructKaro Vendor Network!</h4>
      <p class="mb-0">Your profile is under verification. You’ll be notified once it becomes visible to project owners.</p>
    </div>
    <a href="{{ route('vendor_likes_project') }}" class="btn btn-outline-success">
      <i class="bi bi-heart-fill me-1"></i> Like Projects
    </a>
  </div>

  <div class="text-center mb-4">
    <h5 class="text-muted">In the meantime, you can:</h5>
  </div>

  <div class="row g-4 justify-content-center">
    <!-- Explore Projects Card -->
    <div class="col-md-6 col-lg-5">
      <div class="card-option">
        <div class="icon">
          <i class="bi bi-search"></i>
        </div>
        <h5>Explore Projects</h5>
        <p class="text-muted">Browse available projects with limited access until your profile is verified.</p>
        <a href="{{ route('projects.list.page') }}" class="btn btn-primary mt-3">Browse Projects</a>
      </div>
    </div>

    <!-- Complete Profile Card -->
    <div class="col-md-6 col-lg-5">
      <div class="card-option">
        <div class="icon">
          <i class="bi bi-person-lines-fill"></i>
        </div>
        <h5>Complete Your Profile</h5>
        <p class="text-muted">Add more information to enhance your vendor profile and speed up verification.</p>
        <a href="{{ route('vendor_dashboard') }}" class="btn btn-primary mt-3">Edit Profile</a>
      </div>
    </div>
  </div>

  <!-- Info Message -->
  <div class="info-message mt-5">
    <i class="bi bi-info-circle-fill me-2"></i>
    Verification usually takes 1–2 business days. We’ll email you once it’s approved.
  </div>
</div>

<!-- Footer -->

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
