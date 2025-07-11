<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ConstructKaro Header</title>
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background-color: #f8fafc;
    }

    header {
      background-color: #1c2c3e;
      color: white;
      padding: 16px 32px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }

    .brand {
      font-size: 24px;
      font-weight: bold;
    }

    .brand span {
      color: #f25c05;
    }

    nav {
      display: flex;
      align-items: center;
      gap: 24px;
      position: relative;
    }

    nav a {
      color: white;
      text-decoration: none;
      font-size: 15px;
      font-weight: 500;
    }

    nav a:hover {
      color: #f25c05;
      transition: 0.3s ease;
    }

    .user-dropdown {
      cursor: pointer;
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .avatar {
      background-color: #f25c05;
      color: white;
      border-radius: 50%;
      width: 38px;
      height: 38px;
      display: flex;
      justify-content: center;
      align-items: center;
      font-weight: bold;
      font-size: 16px;
    }

    .user-info {
      text-align: left;
      font-size: 14px;
    }

    .user-info small {
      color: #cbd5e1;
      font-size: 12px;
    }

    .dropdown {
      position: absolute;
      right: 0;
      top: 100%;
      margin-top: 10px;
      background: white;
      border-radius: 6px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.1);
      min-width: 160px;
      overflow: hidden;
      z-index: 1000;
    }

    .dropdown a,
    .dropdown button {
      display: block;
      padding: 10px 16px;
      width: 100%;
      text-align: left;
      font-size: 14px;
      color: #1f2937;
      text-decoration: none;
      border: none;
      background: none;
    }

    .dropdown a:hover,
    .dropdown button:hover {
      background-color: #f3f4f6;
      color: #f25c05;
    }

    [x-cloak] {
      display: none !important;
    }

    @media (max-width: 768px) {
      header {
        flex-direction: column;
        align-items: flex-start;
        gap: 16px;
      }

      nav {
        width: 100%;
        justify-content: space-between;
      }
    }
  </style>
</head>
<body>

<header x-data="{ open: false }">
  <div class="brand">CONSTRUCT<span>KARO</span></div>

  {{-- <nav>
    <a href="{{ route('vendor_details') }}">Vendor List</a>

    <!-- User Dropdown -->
    <div class="relative" @click.away="open = false">
      <div class="user-dropdown" @click="open = !open">
        <div class="avatar">{{ strtoupper(substr($proj_data->full_name ?? 'U', 0, 1)) }}</div>
        <div class="user-info">
          <div>{{ $proj_data->full_name ?? 'Unknown' }}</div>
          <small>{{ $proj_data->email ?? '' }}</small>
        </div>
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
        </svg>
      </div>

      <!-- Dropdown Menu -->
      <div x-show="open" x-cloak class="dropdown">
        <a href="{{ route('customer.dashboard') }}">Dashboard</a>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit">Logout</button>
        </form>
      </div>
    </div>
  </nav> --}}
</header>

</body>
</html>
