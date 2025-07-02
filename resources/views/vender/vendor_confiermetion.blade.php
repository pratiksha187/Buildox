
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>BuildXO Vendor Network</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f4ff;
    }
    .header-section {
      background-color: #2563eb;
      padding: 60px 20px 30px;
      color: white;
      text-align: center;
    }
    .card-box {
      background: white;
      border-radius: 10px;
      padding: 40px;
      margin-top: -50px;
      box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    }
    .card-item {
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      padding: 20px;
      text-align: center;
      height: 100%;
    }
    .card-item h5 {
      margin-top: 10px;
    }
    .info-box {
      background-color: #e0f2fe;
      padding: 10px 15px;
      border-radius: 6px;
      font-size: 14px;
    }
    .icon-wrapper {
      background: #e5e7eb;
      width: 60px;
      height: 60px;
      border-radius: 50%;
      margin: 0 auto;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 24px;
      color: #2563eb;
    }
  </style>
</head>
<body>
  <input type="hidden" name="vendor_id" value="{{ $vendor_id }}">


  <div class="header-section">
    <div class="icon-wrapper bg-white text-dark mb-3">
      <span>&#10005;</span>
    </div>
    <h2>🎉 Welcome to BuildXO Vendor Network!</h2>
    <p>Your profile is under verification. You'll be notified once your profile is visible to project owners.</p>
    <br>
  </div>

  <div class="container card-box">
  
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('vendor_likes_project') }}" class="btn btn-outline-success">
            ❤️ Like Projects
        </a>
    </div>


    <div class="row text-center mb-4">
      <h5>Meanwhile, you can:</h5>
    </div>
    <div class="row g-4 mb-4 justify-content-center">
      <div class="col-md-5 me-md-4">
        <div class="card-item">
          <div class="icon-wrapper">
            🔍
          </div>
          <h5>Explore Projects</h5>
          <p>Browse available projects with limited view until verification</p>
           <a href="{{ route('projects.list.page') }}" class="btn btn-primary">
              Browse Projects
          </a>
        </div>
      </div>
      <div class="col-md-5">
        <div class="card-item">
          <div class="icon-wrapper">
            👤
          </div>
          <h5>Complete Profile</h5>
          <p>Add more details to enhance your vendor profile</p>
          <a href="{{ route('vendor_dashboard') }}" class="btn btn-primary">Edit Profile</a>
        </div>
      </div>
     
    </div>

    <div class="info-box text-center mb-4">
      <i class="bi bi-info-circle"></i>
      Verification typically takes 1–2 business days. You’ll receive an email notification once your profile is approved.
    </div>

    {{-- <div class="d-flex justify-content-between align-items-center">
      <a href="#" class="text-primary">Contact support</a>
      <div>
        <a href="#" class="btn btn-outline-secondary me-2">Go to Dashboard</a>
        <a href="#" class="btn btn-dark">Log Out</a>
      </div>
    </div>  --}}
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
