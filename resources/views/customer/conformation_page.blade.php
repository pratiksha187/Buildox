<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Request Submitted</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #f8f9fa;
    }
    .card-custom {
      max-width: 400px;
      margin: 50px auto;
      border-radius: 20px;
      overflow: hidden;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    .card-header-custom {
      background: linear-gradient(90deg, #4e54c8, #8f94fb);
      padding: 30px;
      text-align: center;
    }
    .card-header-custom img {
      width: 60px;
      height: 60px;
    }
    .highlight-box {
      background-color: #f1f5f9;
      border-radius: 12px;
      padding: 20px;
      margin: 20px 0;
    }
    .btn-custom {
      background-color: #2563eb;
      color: white;
      border-radius: 8px;
      padding: 10px 20px;
      font-weight: 600;
    }
    .btn-custom:hover {
      background-color: #1e40af;
    }
    .footer-text {
      font-size: 0.9rem;
      color: #6b7280;
    }
    .emoji-icon {
    font-size: 48px;
    background-color: white;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    line-height: 60px;
    text-align: center;
    margin: 0 auto;
    }

  </style>
</head>
<body>

<div class="card card-custom text-center">
  <div class="card-header-custom">
    <div class="emoji-icon">🎉</div>

  </div>
  <div class="card-body p-4">
    <h4 class="fw-bold mb-3">Thank you! Your request has been submitted.</h4>
    <p class="text-muted mb-4">
      Your project has been received and is now under review by the BuildXO team.
    </p>

    <div class="highlight-box text-start">
      <p><strong>⏱ Expected Response:</strong> Within 24 working hours</p>
      <p><strong>📞 Next Step:</strong> Our executive will reach out to you if needed</p>
      <p><strong>📁 Submission ID:</strong> BX-2025-001</p>
    </div>

    <!-- <a href="#" class="btn btn-custom">Go to My Dashboard</a> -->
    <a href="{{ route('customer.dashboard') }}" class="btn btn-custom">Go to My Dashboard</a>

  </div>
  <div class="card-footer bg-white border-0">
    <p class="footer-text mt-3 mb-2">Have questions? Contact our support team at<br/>
      <a href="mailto:support@buildxo.com" class="text-primary">support@buildxo.com</a>
    </p>
  </div>
</div>

</body>
</html>
