<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Dashboard')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Alpine.js -->
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="flex bg-gray-100 text-gray-800">

  <!-- Sidebar with Alpine.js state -->
  <aside class="w-64 h-screen bg-gray-900 text-white flex flex-col" 
         x-data="{ sections: { admin: true, masters: false, category: false, users: false } }">
    <div class="text-2xl font-bold px-6 py-4 border-b border-gray-700">BuildOX</div>

    <nav class="flex-1 px-4 py-6">
      <!-- Dashboard Link -->
      <a href="{{ route('admin_dashboard') }}" 
         class="flex items-center px-3 py-2 mb-2 bg-blue-600 rounded text-white font-semibold">
        <span class="material-icons mr-2">dashboard</span> Dashboard
      </a>

      <!-- Vendor Dropdown -->
      <div class="mt-4">
        <button @click="sections.admin = !sections.admin" 
                class="w-full flex justify-between items-center px-3 py-2 text-left hover:bg-gray-800 rounded">
          <span class="text-sm text-gray-300">Vendor</span>
          <span class="material-icons" x-text="sections.admin ? 'expand_less' : 'expand_more'"></span>
        </button>
        <ul x-show="sections.admin" x-transition class="pl-3 mt-2 space-y-2" x-cloak>
          <li><a href="{{ route('vender_approve_form') }}" class="block px-3 py-2 hover:bg-gray-800 rounded">Register</a></li>
          <li><a href="{{ route('vender_approve_data') }}" class="block px-3 py-2 hover:bg-gray-800 rounded">Approve Vendor</a></li>
          <li><a href="{{ route('vender_reject_data') }}" class="block px-3 py-2 hover:bg-gray-800 rounded">Reject Vendor</a></li>
        </ul>
      </div>

      <!-- Masters Dropdown -->
      <div class="mt-4">
        <button @click="sections.masters = !sections.masters" 
                class="w-full flex justify-between items-center px-3 py-2 text-left hover:bg-gray-800 rounded">
          <span class="text-sm text-gray-300">Masters</span>
          <span class="material-icons" x-text="sections.masters ? 'expand_less' : 'expand_more'"></span>
        </button>

        <!-- Nested Category inside Masters -->
        <ul x-show="sections.masters" x-transition class="pl-3 mt-2 space-y-2" x-cloak>
          <li>
            <button @click="sections.category = !sections.category" 
                    class="w-full flex justify-between items-center px-3 py-2 text-left hover:bg-gray-800 rounded">
              <span class="text-sm text-gray-300">Category</span>
              <span class="material-icons" x-text="sections.category ? 'expand_less' : 'expand_more'"></span>
            </button>

            <ul x-show="sections.category" x-transition class="pl-4 mt-2 space-y-2" x-cloak>
              <li><a href="{{ route('construction_type') }}" class="block px-3 py-2 hover:bg-gray-800 rounded text-sm text-gray-300">Construction Type</a></li>
              <li><a href="{{ route('project_type') }}" class="block px-3 py-2 hover:bg-gray-800 rounded text-sm text-gray-300">Project Type</a></li>
              <li><a href="{{ route('const_sub_cat') }}" class="block px-3 py-2 hover:bg-gray-800 rounded text-sm text-gray-300">Construction Sub-Category</a></li>
            </ul>
          </li>
        </ul>
        
      </div>

      <!-- Users Dropdown -->
      <div class="mt-6">
        <button @click="sections.users = !sections.users" 
                class="w-full flex justify-between items-center px-3 py-2 text-left hover:bg-gray-800 rounded">
          <span class="text-sm text-gray-300 uppercase">Users</span>
          <span class="material-icons" x-text="sections.users ? 'expand_less' : 'expand_more'"></span>
        </button>
        <ul x-show="sections.users" x-transition class="pl-3 mt-2 space-y-2" x-cloak>
          <li><a href="{{ route('logout') }}"  class="block px-3 py-2 hover:bg-gray-800 rounded">Log out</a></li>
        </ul>
      </div>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1">
    <!-- Topbar -->
    <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
      <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
      <div class="flex items-center space-x-4">
        <span class="font-medium">ADMIN</span>
        <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button type="submit" class="text-blue-600 text-sm bg-transparent border-0 p-0 m-0">Log out</button>
</form>

        {{-- <a href="{{ route('logout') }}" class="text-blue-600 text-sm">Log out</a> --}}
      </div>
    </header>

    <!-- Page Content -->
    <section class="p-6">
      @yield('content')
    </section>
  </main>

</body>
</html>
