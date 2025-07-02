<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title', 'Dashboard')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <script src="https://cdn.tailwindcss.com"></script>

  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="flex bg-gray-100 text-gray-800">

<body class="flex bg-gray-100 text-gray-800" x-data="{ sidebarOpen: true }">

  <aside 
    :class="sidebarOpen ? 'w-64' : 'w-16'" 
    class="h-screen bg-gray-900 text-white flex flex-col transition-all duration-300 ease-in-out relative"
    x-data="{ sections: { engineer: true } }"
  >
    <!-- Top Title and Toggle Button -->
    <div class="flex items-center justify-between px-4 py-4 border-b border-gray-700">
      <span class="text-2xl font-bold" x-show="sidebarOpen">BuildOX</span>
      
    <button 
        class="p-1 rounded hover:bg-gray-800"
        @click="sidebarOpen = !sidebarOpen">
        <span class="material-icons text-white text-base">
            <template x-if="sidebarOpen">chevron_left</template>
            <template x-if="!sidebarOpen">chevron_right</template>
        </span>
    </button>

    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-2 py-4 space-y-2">
      <!-- Dashboard Link -->
      <a href="{{ route('engineer_dashboard') }}"
         class="flex items-center px-3 py-2 bg-blue-600 rounded text-white font-semibold">
        <span class="material-icons mr-2">dashboard</span>
        <span x-show="sidebarOpen">Dashboard</span>
      </a>

      <!-- Project Dropdown -->
      <div>
        <button @click="sections.project = !sections.project"
                class="w-full flex justify-between items-center px-3 py-2 hover:bg-gray-800 rounded">
          <div class="flex items-center">
            <span class="material-icons mr-2">folder</span>
            <span x-show="sidebarOpen">Project</span>
          </div>
          <span class="material-icons text-sm" x-show="sidebarOpen"
                x-text="sections.project ? 'expand_less' : 'expand_more'"></span>
        </button>

        <!-- Dropdown links -->
        <ul x-show="sections.project && sidebarOpen" x-transition class="pl-10 mt-1 space-y-1" x-cloak>
          <li>
            <a href="{{ route('NewProject') }}"
               class="block px-2 py-1 text-sm rounded hover:bg-gray-800">New Project</a>
          </li>
        </ul>
      </div>

       <div>
        <button @click="sections.boq = !sections.boq"
                class="w-full flex justify-between items-center px-3 py-2 hover:bg-gray-800 rounded">
          <div class="flex items-center">
            <span class="material-icons mr-2">folder</span>
            <span x-show="sidebarOpen">BOQ</span>
          </div>
          <span class="material-icons text-sm" x-show="sidebarOpen"
                x-text="sections.boq ? 'expand_less' : 'expand_more'"></span>
        </button>

        <!-- Dropdown links -->
        <ul x-show="sections.boq && sidebarOpen" x-transition class="pl-10 mt-1 space-y-1" x-cloak>
          <li>
            <a href="{{ route('NewProjectBoq') }}"
               class="block px-2 py-1 text-sm rounded hover:bg-gray-800">Project BOQ</a>
          </li>
        </ul>
      </div>
    </nav>
  </aside>

    <main class="flex-1">
    
        <header class="bg-white shadow px-6 py-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">@yield('title', 'Dashboard')</h1>
            <div class="flex items-center space-x-4">
                <span class="font-medium">Engginer</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-blue-600 text-sm bg-transparent border-0 p-0 m-0">Log out</button>
                </form>
            </div>
        </header>

        <section class="p-6">
        @yield('content')
        </section>
    </main>

</body>
</html>
