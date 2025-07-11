<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Constructkaro</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to right, #e0f7fa, #fff3e0);
      min-height: 100vh;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background: linear-gradient(to right, #2196f3, #21cbf3);
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .navbar-brand img {
      width: 130px;
    }

    .main-section {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      text-align: center;
    }

    .role-grid {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 30px;
      margin-top: 30px;
    }

    .role-card {
      width: 255px;
      border-radius: 20px;
      padding: 30px 25px;
      color: white;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      text-decoration: none;
    }

    .role-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
    }

    .role-icon {
      font-size: 60px;
      margin-bottom: 20px;
    }

    .build-role {
      background: linear-gradient(to right, #42a5f5, #478ed1);
    }

    .service-role {
      background: linear-gradient(to right, #ff9800, #ffc107);
      color: #000;
    }

    .role-title {
      font-size: 1.3rem;
      font-weight: bold;
    }

    .role-desc {
      font-size: 0.9rem;
      margin-top: 10px;
      opacity: 0.9;
    }

    .footer {
      background: #263238;
      color: #ccc;
      padding: 20px 0;
      text-align: center;
      font-size: 14px;
    }

    .footer a {
      color: #90caf9;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 600px) {
      .role-card {
        width: 100%;
        max-width: 340px;
      }
    }
  </style>
</head>
<body>

  @include('layouts.customer.header')

  <main class="container my-5">
    @yield('content')
  </main>

  @include('layouts.footer')

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
