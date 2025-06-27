
<div class="max-w-3xl mx-auto p-6 bg-white rounded-xl shadow mt-10">
  <h2 class="text-2xl font-bold mb-2">Tell Us About Your Project</h2>
  <p class="text-gray-600 mb-6">Don't worry if you don't have all the details. Our team will call you to discuss your project and help finalize the details.</p>

  <!-- Message container -->
  <div id="message" class="mb-4 text-sm font-medium hidden"></div>

  <form id="inquiryForm" class="space-y-6">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block mb-1 font-medium">Your Name</label>
        <input type="text" name="name" id="name" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
      </div>
      <div>
        <label class="block mb-1 font-medium">Phone Number</label>
        <input type="tel" name="phone" id="phone" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
      </div>
    </div>

    <div>
      <label class="block mb-1 font-medium">Email Address</label>
      <input type="email" name="email" id="email" class="w-full border border-gray-300 rounded-lg px-4 py-2" />
    </div>

    <div>
      <label class="block mb-1 font-medium">Project Type</label>
      <select name="project_type" id="project_type" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white">
        <option>Select project type</option>
        <option>Residential</option>
        <option>Commercial</option>
        <option>Renovation</option>
      </select>
    </div>

    <div>
      <label class="block mb-1 font-medium">Project Brief</label>
      <textarea name="project_brief" id="project_brief" class="w-full border border-gray-300 rounded-lg px-4 py-2 h-32 resize-none"></textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block mb-1 font-medium">Best Time to Call You</label>
        <select name="preferred_day" id="preferred_day" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white">
          <option>Select day</option>
          <option>Monday</option>
          <option>Tuesday</option>
          <option>Wednesday</option>
          <option>Thursday</option>
          <option>Friday</option>
        </select>
      </div>
      <div>
        <label class="block mb-1 font-medium">Select Time</label>
        <select name="preferred_time" id="preferred_time" class="w-full border border-gray-300 rounded-lg px-4 py-2 bg-white">
          <option>Select time</option>
          <option>10:00 AM</option>
          <option>12:00 PM</option>
          <option>3:00 PM</option>
          <option>5:00 PM</option>
        </select>
      </div>
    </div>

    <div class="flex justify-between mt-6">
      <button type="button" class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">Back</button>
      <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700">Submit Request</button>
    </div>
  </form>
</div>

<!-- AJAX Script -->
<script>
  document.getElementById("inquiryForm").addEventListener("submit", function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const messageBox = document.getElementById("message");

    fetch("{{ route('project.inquiry.store') }}", {
      method: "POST",
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
      },
      body: formData
    })
    .then(res => res.json())
    .then(data => {
      messageBox.classList.remove("hidden");
      if (data.success) {
        form.reset();
        messageBox.classList.add("text-green-600", "bg-green-100", "p-3");
        messageBox.textContent = data.message;
      } else {
        messageBox.classList.add("text-red-600", "bg-red-100", "p-3");
        messageBox.innerHTML = Object.values(data.errors).map(e => `<div>${e}</div>`).join('');
      }
    })
    .catch(error => {
      messageBox.classList.remove("hidden");
      messageBox.classList.add("text-red-600", "bg-red-100", "p-3");
      messageBox.textContent = "Something went wrong. Please try again.";
    });
  });
</script>
