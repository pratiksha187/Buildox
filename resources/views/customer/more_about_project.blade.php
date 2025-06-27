<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Project Step Options</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
  <div class="max-w-7xl mx-auto px-4 py-16">
    <div class="text-center mb-10">
      <h1 class="text-3xl md:text-4xl font-bold">Tell us more about your project</h1>
      <p class="text-gray-600 mt-2 text-lg">Please select the option that best describes your current situation:</p>
    </div>

    <div class="grid md:grid-cols-3 gap-6">
      
      <!-- Option 1 -->
    <a href="{{ url('/project-details') }}">
      <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition-all border-2 border-green-100">
        <div class="flex items-center justify-between mb-4">
          <div class="text-green-600 text-3xl">✅</div>
          <div class="text-green-600 text-xl">✔️</div>
        </div>
        <h3 class="text-xl font-semibold mb-2">I'm ready to proceed</h3>
        <p class="text-gray-600 mb-4">I have all the project details, documents, and budget information ready.</p>
        <ul class="text-green-600 space-y-2">
          <li>✔ Upload project documents</li>
          <li>✔ Specify your budget</li>
          <li>✔ 24-hour verification process</li>
        </ul>
      </div>
    </a>

      <!-- Option 2 -->
      <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition-all border-2 border-orange-100">
        <div class="flex items-center justify-between mb-4">
          <div class="text-orange-400 text-3xl">📋</div>
          <div class="text-orange-400 text-xl">✔️</div>
        </div>
        <h3 class="text-xl font-semibold mb-2">I'd like to see options</h3>
        <p class="text-gray-600 mb-4">I have a general idea but would like to see ready-made packages.</p>
        <ul class="text-orange-500 space-y-2">
          <li>✔ Browse pre-designed packages</li>
          <li>✔ Compare features and pricing</li>
          <li>✔ Customize to your needs</li>
        </ul>
      </div>

      <!-- Option 3 -->
      <div class="bg-white rounded-xl p-6 shadow hover:shadow-lg transition-all border-2 border-yellow-100">
        <div class="flex items-center justify-between mb-4">
          <div class="text-yellow-400 text-3xl">👤</div>
          <div class="text-yellow-400 text-xl">✔️</div>
        </div>
        <h3 class="text-xl font-semibold mb-2">I need guidance</h3>
        <p class="text-gray-600 mb-4">I'm not sure about the details and would like professional help.</p>
        <ul class="text-yellow-500 space-y-2">
          <li>✔ Submit a simple brief</li>
          <li>✔ Get a call from our team</li>
          <li>✔ Personalized project plan</li>
        </ul>
      </div>

    </div>
  </div>
</body>
</html>
