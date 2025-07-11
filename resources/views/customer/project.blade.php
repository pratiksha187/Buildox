@extends('layouts.app')
@section('title', 'Project Information')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
   .form-section {
   background-color: #f9f9fb;
   padding: 40px;
   border-radius: 10px;
   }
   .form-title-wrapper {
   text-align: center;
   margin-bottom: 30px;
   }
   .form-title-wrapper h4 {
   font-weight: 600;
   font-size: 1.75rem;
   }
   .form-switch label {
   margin-left: 0.5rem;
   }
   .select2-container--default .select2-selection--multiple {
   border: 1px solid #ced4da;
   border-radius: 0.375rem;
   padding: 0.375rem 0.75rem;
   }
   #suggestions {
   max-height: 200px; 
   overflow-y: auto;  
   box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
   z-index: 1000;
   }
   .dropdown-item {
   cursor: pointer;
   padding: 8px 12px;
   }
   .dropdown-item:hover {
   background-color: #f1f1f1;
   }
   .position-relative {
   position: relative;
   }
    body, html {
      height: 100%;
      margin: 0;
    }

    .center-page {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 28vh;
      background-color: #f8f9fa;
    }

    .form-switch.custom-switch .form-check-input {
      width: 2.5em;
      height: 1.4em;
      background-color: #ccc;
      border-radius: 2em;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }

    .form-switch.custom-switch .form-check-input:checked {
      background-color: #4caf50;
    }

    .form-switch.custom-switch .form-check-input:focus {
      box-shadow: 0 0 0 0.15rem rgba(76, 175, 80, 0.25);
    }

    .form-switch.custom-switch .form-check-label {
      margin-left: 0.75rem;
      font-weight: 500;
      font-size: 1.1rem;
      color: #333;
    }

    .custom-form-group {
      display: flex;
      align-items: center;
    }
   :root {
  --primary-color: #1b2b3b;    /* Dark Blue */
  --accent-color:  #f04e23;    /* Bright Orange */
  --bg-gradient-start: #e6f7f9;  /* Light Blue */
  --bg-gradient-end:   #fef8ed;  /* Creamy Beige */
  --text-dark: #333;
  --text-light: #fff;
  --input-border: #ced4da;
}

   body {
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(to right, var(--bg-gradient-start), var(--bg-gradient-end));
  margin: 0;
  padding: 0;
  color: var(--text-dark);
}

.navbar {
  background-color: var(--primary-color);
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.navbar a {
  color: var(--text-light);
  margin-left: 1.5rem;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.3s;
}

.navbar a:hover {
  color: var(--accent-color);
}

.logo {
  font-size: 1.5rem;
  font-weight: bold;
  color: var(--text-light);
}

.logo span {
  color: var(--accent-color);
}

/* Form Container */
.form-section {
  background-color: #fff;
  border-radius: 12px;
  padding: 40px;
  margin: 3rem auto;
  box-shadow: 0 0 25px rgba(0,0,0,0.05);
}

/* Title */
.form-title-wrapper h4 {
  font-weight: 600;
  font-size: 2rem;
  color: var(--primary-color);
}

/* Inputs */
input.form-control, select.form-select {
  border: 1px solid var(--input-border);
  border-radius: 8px;
  padding: 10px 12px;
  transition: border-color 0.3s ease;
}

input.form-control:focus, select.form-select:focus {
  border-color: var(--accent-color);
  box-shadow: 0 0 0 0.15rem rgba(240, 78, 35, 0.25);
}

/* Button */
button.btn-primary {
  background: var(--accent-color);
  border: none;
  font-size: 1.1rem;
  padding: 10px 24px;
  border-radius: 8px;
  color: white;
  transition: background-color 0.3s ease;
}

button.btn-primary:hover {
  background-color: #c9401b;
}

/* Custom Switch */
.form-switch.custom-switch .form-check-input {
  background-color: #ccc;
  width: 2.5em;
  height: 1.4em;
  border-radius: 2em;
}

.form-switch.custom-switch .form-check-input:checked {
  background-color: var(--accent-color);
}

#plotDetailsSection {
  background: #f9f9fb;
  padding: 1.5rem;
  border-left: 5px solid var(--accent-color);
  border-radius: 10px;
  margin-top: 1rem;
}

   </style>
<div class="container my-5">
   <div class="form-section shadow-sm">
      <div class="form-title-wrapper">
         <h4>Tell us about your project</h4>
      </div>
      <form id="projectForm" method="POST" enctype="multipart/form-data">
         <div class="row mb-3">
            <div class="col-md-6">
               <label class="form-label">Full Name</label>
               <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Enter full name">
            </div>
            <div class="col-md-6">
               <label class="form-label">Phone Number</label>
               <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Enter phone number">
            </div>
         </div>
         
         <div class="row mb-3">
            <div class="col-md-6 position-relative">
               <label class="form-label">Email</label>
               <input type="email" name="email" id="email" class="form-control" placeholder="Enter email" autocomplete="off">
               <div id="suggestions" class="dropdown-menu show w-100" style="display: none;"></div>
            </div>
            <div class="col-md-6">
               <label class="form-label">Password</label>
               <input type="password" name="password" id="password" class="form-control" placeholder="Enter password">
            </div>
         </div>
      
         <div class="row mb-3">
            <div class="col-md-6">
               <label for="profile_image" class="form-label">Select Profile Image</label>
               <input type="file" class="form-control" id="profile_image" name="profile_image" accept="image/*">
            </div>
            <div class="col-md-6">
               <label for="role" class="form-label">Select Your Role</label>
               <select id="role" name="role" class="form-select">
                  <option value="">Select Role</option>
                  @foreach($role_types as $role)
                  <option value="{{ $role->id }}">{{ $role->role }}</option>
                  @endforeach
               </select>
            </div>
         </div>
         
         <div class="row mb-3">
            <div class="col-md-6">
               <label for="construction_type" class="form-label">Type of Vendor Needed</label>
               <select id="construction_type" name="construction_type" class="form-select">
                  <option value="">Select Construction Type</option>
                  @foreach($construction_types as $type)
                  <option value="{{ $type->id }}">{{ $type->name }}</option>
                  @endforeach
               </select>
            </div>
            <div class="col-md-6">
               <label for="project_type" class="form-label">Select Project Type</label>
               <select id="project_type" name="project_type" class="form-select mt-3">
                  <option value="">Select Project Type</option>
               </select>
            </div>

            <div class="col-md-6 mt-3" id="other_project_type_wrapper" style="display: none;">
               <label class="form-label">Enter Project Type</label>
               <input type="text" name="other_project_type" id="other_project_type" class="form-control" placeholder="Specify other project type">
            </div>
         </div>
         <div class="row mb-3">
            <div id="sub_categories_container" class="col-md-6" style="display: none;">
               <label class="form-label fw-bold" id="sub_category_title"></label>
               Select Sub-Categories
               <div id="sub_categories" name="sub_categories" class="form-check d-flex flex-column gap-2 mt-2"></div>
            </div>
         </div>
         
         <div class="center-page">
            <div class="form-check form-switch custom-switch custom-form-group">
               <input class="form-check-input" type="checkbox" id="plot_ready" name="plot_ready">
               <label class="form-check-label" for="plot_ready">Do you have your plot/site ready?</label>
            </div>
         </div>

         <div id="plotDetailsSection" style="display: none;">
            <div class="row mb-3">
               <div class="col-md-12">
                  <label class="form-label">Land location</label>
                  <input type="text" name="land_location" id="land_location" class="form-control" placeholder="Enter land location">
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">Land type</label>
                  <select name="land_type" id="land_type" class="form-select">
                     <option value="">Select land type</option>
                     <option value="1">Residential</option>
                     <option value="2">Commercial</option>
                     <option value="3">Industrial</option>
                  
                  </select>
               </div>
               <div class="col-md-6">
                  <label class="form-label">Survey No. (optional)</label>
                  <input type="text" name="survey_no" id="survey_no" class="form-control" placeholder="Enter survey number">
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-6 d-flex">
                  <input type="number" name="area" id="area" class="form-control" placeholder="Area">
                  <select name="area_unit" id="area_unit" class="form-select ms-2" style="max-width: 100px;">
                     <option value="1">sq.ft</option>
                     <option value="2">sq.m</option>
                     <option value="3">Acre</option>
                  </select>
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-6 d-flex align-items-center">
                  <label class="form-check-label me-2">Do you have architectural drawing?</label>
                  <div class="form-check form-switch">
                     <input class="form-check-input" type="checkbox" name="has_arch_drawing" id="has_arch_drawing">
                  </div>
               </div>
               <div class="col-md-6 d-flex align-items-center">
                  <label class="form-check-label me-2">Do you have structural drawing?</label>
                  <div class="form-check form-switch">
                     <input class="form-check-input" type="checkbox" name="has_structural_drawing" id="has_structural_drawing">
                  </div>
               </div>
            </div>
            <div class="form-check mb-3">
               <input class="form-check-input" type="checkbox" value="1" id="boqCheckbox" name="boqCheckbox">
               <label class="form-check-label" for="boqCheckbox">
               BOQ
               </label>
            </div>
            <div class="mb-3" id="excelUpload" style="display: none;">
               <label for="boqFile" class="form-label">Upload BOQ (Excel only)</label>
               <input class="form-control" type="file" id="boqFile" name="boqFile" accept=".xls,.xlsx">
            </div>
         </div>
       
         <div class="text-center mt-4">
            <button class="btn btn-primary" type="submit">Next</button>
         </div>

      </form>
   </div>
</div>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
   $('#plot_ready').on('change', function () {
     if ($(this).is(':checked')) {
       $('#plotDetailsSection').slideDown();
     } else {
       $('#plotDetailsSection').slideUp();
     }
   });
   
  

   $(document).ready(function () {
      $('#projectForm').on('submit', function (e) {
         e.preventDefault();

         let form = this;
         let formData = new FormData(form);

         // Set checkbox value
         formData.set('plot_ready', $('#plot_ready').is(':checked') ? 1 : 0);

         // Set sub-categories
         formData.delete('sub_categories[]');
         $('input[name="sub_categories[]"]:checked').each(function () {
               formData.append('sub_categories[]', $(this).val());
         });

         $.ajax({
               url: '{{ route("projectinfostore") }}',
               method: 'POST',
               data: formData,
               processData: false,
               contentType: false,
               headers: {
                  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               success: function (response) {
                  if (response.status === 'payment_required') {
                     alert(response.message);
                     window.location.href = response.payment_url;
                     return;
                  }

                  if (response.status === 'success') {
                     alert(response.message);
                     $('#projectForm')[0].reset();
                     $('#construction_type').val(null).trigger('change');
                     $('#project_type').empty().append('<option value="">Select Project Type</option>');
                     $('#sub_categories').empty();
                     $('#sub_categories_container').hide();
                     $('#project_id').val(response.project_id);
                     window.location.href = '/project-details/' + response.project_id;
                  }
               },
               error: function (xhr) {
                  if (xhr.status === 409 && xhr.responseJSON.status === 'exists') {
                     alert(xhr.responseJSON.message);
                     return;
                  }

                  const errors = xhr.responseJSON.errors;
                  if (errors) {
                     $('.is-invalid').removeClass('is-invalid');
                     $('.invalid-feedback').remove();

                     $.each(errors, function (field, messages) {
                           const inputField = $('#' + field);
                           inputField.addClass('is-invalid');
                           inputField.after('<div class="invalid-feedback">' + messages.join('<br>') + '</div>');
                     });
                  } else {
                     alert('An unexpected error occurred. Please try again.');
                  }
               }
         });
      });
   });

</script>
<script>
   const boqCheckbox = document.getElementById('boqCheckbox');
   const excelUpload = document.getElementById('excelUpload');
   
   boqCheckbox.addEventListener('change', function () {
     excelUpload.style.display = this.checked ? 'block' : 'none';
   });
</script>
<script>
   const emailInput = document.getElementById('email');
   const suggestionsBox = document.getElementById('suggestions');
   
   const domains = [
     'gmail.com', 'yahoo.com', 'rediffmail.com', 'outlook.com', 'hotmail.com',
     'live.com', 'aol.com', 'icloud.com', 'protonmail.com', 'mail.com',
     'zoho.com', 'gmx.com', 'yandex.com', 'msn.com', 'inbox.com', 'me.com'
   ];
   
   emailInput.addEventListener('input', function () {
     const value = this.value;
     const atIndex = value.indexOf('@');
   
     if (atIndex !== -1 && !value.includes('.', atIndex)) {
       const username = value.slice(0, atIndex + 1); // include @
       suggestionsBox.innerHTML = '';
       domains.forEach(domain => {
         const item = document.createElement('a');
         item.className = 'dropdown-item';
         item.textContent = username + domain;
         item.onclick = () => {
           emailInput.value = item.textContent;
           suggestionsBox.style.display = 'none';
         };
         suggestionsBox.appendChild(item);
       });
       suggestionsBox.style.display = 'block';
     } else {
       suggestionsBox.style.display = 'none';
     }
   });
   
   document.addEventListener('click', (e) => {
     if (!suggestionsBox.contains(e.target) && e.target !== emailInput) {
       suggestionsBox.style.display = 'none';
     }
   });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Fetch Project Types when Construction Type changes
    $('#construction_type').on('change', function () {
        const typeId = $(this).val();
        $('#project_type').html('<option value="">Loading...</option>');
        $('#sub_categories_container').hide();
         $('#other_project_type_wrapper').hide();
        if (typeId) {
            $.ajax({
                url: '/get-project-types',
                type: 'GET',
                data: { construction_type_id: typeId },
                success: function (data) {
                    $('#project_type').empty().append('<option value="">Select Project Type</option>');
                    $.each(data, function (index, item) {
                        $('#project_type').append('<option value="' + item.id + '">' + item.name + '</option>');
                    });

                     // $('#project_type').append('<option value="other">Other</option>');
                }
            });

            $('#project_type').on('change', function () {
               const selected = $(this).val();
               if (selected === '6') {
                     $('#other_project_type_wrapper').slideDown();
               } else {
                     $('#other_project_type_wrapper').slideUp();
               }
            });
               }
            });

    // Fetch Subcategories when Project Type changes
    $('#project_type').on('change', function () {
        const projectTypeId = $(this).val();
        const constructionTypeId = $('#construction_type').val();

        $('#sub_categories').empty();
        $('#sub_categories_container').hide();

        if (projectTypeId && constructionTypeId) {
            $.ajax({
                url: '/get-sub-categories',
                type: 'GET',
                data: {
                    construction_type_id: constructionTypeId,
                    project_type_id: projectTypeId
                },
                success: function (data) {
                    if (data.length > 0) {
                        $('#sub_category_title').text();
                        $('#sub_categories_container').show();

                        $.each(data, function (index, subcat) {
                           const checkbox = `
                              <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sub_categories[]" value="${subcat.const_sub_cat_id}" id="subcat_${subcat.const_sub_cat_id}">
                                    <label class="form-check-label" for="subcat_${subcat.const_sub_cat_id}">
                                       ${subcat.sub_category_name}
                                    </label>
                              </div>`;
                           $('#sub_categories').append(checkbox);
                        });

                    }
                }
            });
        }
    });
});
</script>

@endsection