@extends('layouts.app')
@section('title', 'Project Submitted')
@section('content')

<!-- Bootstrap & Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
 

  .card-custom {
    max-width: 500px;
    margin: auto;
    border-radius: 20px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
    animation: fadeInUp 0.6s ease-out;
  }

  .card-header-custom {
    background: linear-gradient(90deg, #4e54c8, #8f94fb);
    padding: 32px 0;
    text-align: center;
    color: white;
  }

  .emoji-icon {
    font-size: 48px;
    background-color: white;
    color: #4e54c8;
    border-radius: 50%;
    width: 72px;
    height: 72px;
    line-height: 72px;
    text-align: center;
    margin: 0 auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.12);
  }

  .card-body {
    padding: 30px 28px;
  }

  .card-body h4 {
    font-weight: 700;
    font-size: 1.25rem;
    margin-bottom: 12px;
    color: #1f2937;
  }

  .card-body p {
    color: #6b7280;
    font-size: 0.95rem;
    margin-bottom: 1.5rem;
  }

  .highlight-box {
    background-color: #f1f5f9;
    border-left: 4px solid #4e54c8;
    padding: 18px 20px;
    border-radius: 12px;
    margin-bottom: 24px;
    font-size: 0.95rem;
    text-align: left;
  }

  .highlight-box p {
    margin-bottom: 12px;
    color: #374151;
  }

  .highlight-box i {
    color: #4e54c8;
    margin-right: 8px;
  }

  .btn-custom {
    background-color: #f97316;
    border: none;
    border-radius: 8px;
    padding: 10px 24px;
    color: white;
    font-weight: 600;
    transition: background-color 0.3s;
  }

  .btn-custom:hover {
    background-color: #c2410c;
  }

  .footer-text {
    font-size: 0.875rem;
    color: #6b7280;
    text-align: center;
    margin: 20px auto 16px;
  }

  .footer-text a {
    color: #4e54c8;
    text-decoration: none;
  }

  @keyframes fadeInUp {
    from {
      transform: translateY(40px);
      opacity: 0;
    }
    to {
      transform: translateY(0);
      opacity: 1;
    }
  }
</style>

<div class="card card-custom text-center">
  <div class="card-header-custom">
    <div class="emoji-icon">🎉</div>
    <input type="hidden" name="project_id" value="{{ $project_id }}">
  </div>

  <div class="card-body">
    <h4>Thank you! Your request has been submitted.</h4>
    <p>Your project has been received and is now under review by the <strong>Constructkaro</strong> team.</p>

    <div class="highlight-box">
      <p><i class="bi bi-stopwatch-fill"></i> <strong>Expected Response:</strong> Within 24 working hours</p>
      <p><i class="bi bi-telephone-forward-fill"></i> <strong>Next Step:</strong> Our executive will reach out to you if needed</p>
      <p><i class="bi bi-folder-check"></i> <strong>Submission ID:</strong> {{ $get_project_det->submission_id }}</p>
    </div>

    <a href="{{ route('customer.dashboard') }}" class="btn btn-custom">Go to My Dashboard</a>
  </div>

  <div class="footer-text">
    <p>Have questions? Contact our support team at <br>
      <a href="mailto:support@Constructkaro.com">support@Constructkaro.com</a>
    </p>
  </div>
</div>

@endsection
