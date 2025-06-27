<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>BuildXO Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800 font-sans">

  <!-- Header -->
  <header class="bg-white shadow">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
      <h1 class="text-2xl font-bold text-blue-600">BuildXO</h1>
      <nav class="flex items-center space-x-4">
        <!-- <a href="#" class="text-gray-600 hover:text-blue-600 text-sm font-medium">Dashboard</a>
        <a href="#" class="text-gray-600 hover:text-blue-600 text-sm font-medium">Projects</a>
        <a href="#" class="text-gray-600 hover:text-blue-600 text-sm font-medium">Help</a> -->
        <div class="flex items-center space-x-2">
          <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">JD</div>
          <div class="text-sm">
            <div class="font-medium">John Doe</div>
            <div class="text-gray-500">john@example.com</div>
          </div>
        </div>
      </nav>
    </div>
  </header>

  <!-- Main Content -->
  <main class="max-w-6xl mx-auto px-6 py-8">
    
    <!-- Welcome Banner -->
    <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white rounded-xl p-6 mb-6">
      <h2 class="text-2xl font-semibold">👋 Welcome back, John Doe!</h2>
      <p class="mt-1 text-sm">Here's an overview of your projects and notifications.</p>
    </div>

    <!-- My Projects Section -->
    <section class="mb-8">
      <h3 class="text-xl font-semibold mb-4">📂 My Projects</h3>
      <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="min-w-full text-sm text-left">
          <thead class="bg-gray-100 text-gray-600 uppercase">
            <tr>
              <th class="px-6 py-3">Project Name</th>
              <th class="px-6 py-3">Status</th>
              <th class="px-6 py-3">Submitted On</th>
              <th class="px-6 py-3">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr class="border-b">
              <td class="px-6 py-4">
                <div class="flex items-center space-x-2">
                  <div class="bg-blue-100 p-2 rounded-full text-blue-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M10 2L2 7v11h6v-5h4v5h6V7l-8-5z"/>
                    </svg>
                  </div>
                  <div>
                    <div class="font-medium">Karjat Bungalow</div>
                    <div class="text-gray-500 text-xs">Residential Project</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <span class="bg-orange-100 text-orange-600 text-xs px-3 py-1 rounded-full">Under Review</span>
              </td>
              <td class="px-6 py-4">10 June 2025</td>
              <td class="px-6 py-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">View Details</button>
              </td>
            </tr>
            <tr>
              <td class="px-6 py-4">
                <div class="flex items-center space-x-2">
                  <div class="bg-purple-100 p-2 rounded-full text-purple-600">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                      <path d="M3 3h14v14H3V3z"/>
                    </svg>
                  </div>
                  <div>
                    <div class="font-medium">Pune Rowhouses</div>
                    <div class="text-gray-500 text-xs">Residential Project</div>
                  </div>
                </div>
              </td>
              <td class="px-6 py-4">
                <span class="bg-gray-200 text-gray-600 text-xs px-3 py-1 rounded-full">Draft</span>
              </td>
              <td class="px-6 py-4">—</td>
              <td class="px-6 py-4">
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Complete Now</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>

    <!-- Notifications Section -->
    <section class="mb-8">
      <h3 class="text-xl font-semibold mb-4">🔔 Notifications</h3>
      <div class="space-y-3">
        <div class="bg-white border-l-4 border-red-500 p-4 rounded shadow-sm">
          <div class="text-sm text-gray-700">
            📞 We tried calling you for your Karjat project.
            <a href="#" class="text-blue-600 font-semibold">Reschedule call.</a>
          </div>
          <div class="text-xs text-gray-500 mt-1">2 hours ago</div>
        </div>
        <div class="bg-white border-l-4 border-green-500 p-4 rounded shadow-sm">
          <div class="text-sm text-gray-700">
            📄 Your project documents have been verified.
          </div>
          <div class="text-xs text-gray-500 mt-1">Yesterday</div>
        </div>
      </div>
    </section>

    <!-- Start New Project CTA -->
    <section class="mt-8 bg-blue-50 border border-blue-100 rounded-lg flex justify-between items-center px-6 py-4">
      <div>
        <h4 class="text-lg font-semibold text-gray-800">Ready to start a new project?</h4>
        <p class="text-gray-600 text-sm">Let us help you bring your vision to life.</p>
      </div>
      <button class="text-blue-600 border border-blue-500 hover:bg-blue-100 font-medium px-4 py-2 rounded">
        + Add Another Project
      </button>
    </section>
  </main>

  <!-- Footer -->
  <footer class="bg-white shadow-inner mt-12">
    <div class="max-w-6xl mx-auto px-6 py-4 flex justify-between items-center text-sm text-gray-500">
      <p>&copy; 2025 BuildXO. All rights reserved.</p>
      <div class="space-x-4">
        <a href="#" class="hover:text-blue-600">Privacy Policy</a>
        <a href="#" class="hover:text-blue-600">Terms of Service</a>
      </div>
    </div>
  </footer>

</body>
</html>
