<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Constructkaro Vendor Network</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f4ff;
      font-family: 'Segoe UI', sans-serif;
    }
    .header-section {
      background-color: #2563eb;
      padding: 60px 20px 30px;
      color: white;
      text-align: center;
    }
    .card-box {
      background: white;
      border-radius: 12px;
      padding: 40px 30px;
      margin-top: -50px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }
    .card-item {
      transition: transform 0.2s ease;
      border: 1px solid #e5e7eb;
      border-radius: 14px;
      padding: 30px 20px;
      text-align: center;
      height: 100%;
    }
    .card-item:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
    }
    .card-item h5 {
      margin-top: 15px;
      font-weight: 600;
    }
    .info-box {
      background-color: #e0f2fe;
      padding: 14px 20px;
      border-radius: 8px;
      font-size: 15px;
      color: #0c4a6e;
    }
    .icon-wrapper {
      background: #e5e7eb;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      margin: 0 auto 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 26px;
      color: #2563eb;
    }
    .logout-btn {
      position: absolute;
      top: 20px;
      right: 30px;
    }
  </style>
</head>
<body>
  <input type="text" name="vendor_id" value="{{ $vendor_id }}">
  <form method="POST" action="{{ route('logout') }}" class="logout-btn">
    @csrf
    <button type="submit" class="btn btn-sm btn-outline-light">
      <i class="bi bi-box-arrow-right me-1"></i> Log out
    </button>
  </form>

  <div class="header-section">
    <div class="icon-wrapper bg-white text-danger mb-3">
      <i class="bi bi-x-lg"></i>
    </div>
    <h2 class="fw-bold">🎉 Welcome to Constructkaro Vendor Network!</h2>
    <p>Your profile is under verification. You'll be notified once your profile is visible to project owners.</p>
  </div>
  <br>

  <div class="container card-box">
    <div class="d-flex justify-content-end mb-4">
      <a href="{{ route('vendor_likes_project') }}" class="btn btn-outline-success">
        <i class="bi bi-heart-fill me-1"></i> Like Projects
      </a>
    </div>

    <div class="text-center mb-4">
      <h5 class="text-muted">Meanwhile, you can:</h5>
    </div>

    <div class="row g-4 justify-content-center">
      <div class="col-md-5">
        <div class="card-item">
          <div class="icon-wrapper">
            <i class="bi bi-search"></i>
          </div>
          <h5>Explore Projects</h5>
          <p class="text-muted">Browse available projects with limited view until verification</p>
          <a href="{{ route('projects.list.page') }}" class="btn btn-primary mt-2">
            Browse Projects
          </a>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card-item">
          <div class="icon-wrapper">
            <i class="bi bi-person-lines-fill"></i>
          </div>
          <h5>Complete Profile</h5>
          <p class="text-muted">Add more details to enhance your vendor profile</p>
          <a href="{{ route('vendor_dashboard') }}" class="btn btn-primary mt-2">Edit Profile</a>
        </div>
      </div>
    </div>

    <div class="info-box text-center mt-5">
      <i class="bi bi-info-circle-fill me-2"></i>
      Verification typically takes 1–2 business days. You’ll receive an email once approved.
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
