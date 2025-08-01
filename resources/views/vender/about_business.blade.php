@extends('layouts.vendor.app')
@section('title', 'Select Your Role')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Business Registration Form</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
   .form-wrapper {
   background-color: #fff;
   padding: 2rem;
   border-radius: 12px;
   box-shadow: 0 4px 12px rgba(0,0,0,0.1);
   }
    body {
        background-color: #f8f9fb;
        font-family: 'Segoe UI', sans-serif;
    }

    .form-wrapper {
        background-color: #fff;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        margin-top: 2rem;
        margin-bottom: 3rem;
    }

    h4, h5 {
        color: #1b2a3d;
        font-weight: 700;
    }

    .form-label {
        font-weight: 600;
        color: #1b2a3d;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #ced4da;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #f47c1c;
        box-shadow: 0 0 0 0.2rem rgba(244, 124, 28, 0.25);
    }

    .form-section {
        background: #ffffff;
        border: 1px solid #e3e6ea;
        border-left: 5px solid #f47c1c;
        padding: 1.5rem;
        margin-bottom: 2rem;
        border-radius: 12px;
    }

    .btn-primary {
        background-color: #f47c1c;
        border: none;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 8px;
        transition: all 0.3s ease-in-out;
    }

    .btn-primary:hover {
        background-color: #e86e12;
    }

    .form-check-label {
        color: #6c757d;
    }

    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }

    a {
        color: #f47c1c;
        text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    hr {
        border-top: 1px solid #dee2e6;
    }

    input[type="file"] {
        padding: 6px;
        border-radius: 6px;
    }
</style>
   <div class="form-wrapper">
      <h5>Tell us more about your business</h5>
      <h4>Complete your profile to start receiving project requests</h4>
      <form id="businessForm" method="POST" enctype="multipart/form-data">
         <div class="form-section">
            <h5>Basic Business Information</h5>
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">Years of Experience *</label>
                  <select class="form-select" id="experience_years" name="experience_years">
                     <option>Select years of experience</option>
                     <option value="1">0-2 Years</option>
                     <option value="2">3-5 Years</option>
                     <option value="3">6-10 Years</option>
                     <option value="4">11-15 Years</option>
                     <option value="5">16-20 Years</option>
                     <option value="6">20+ Years</option>
                  </select>
               </div>
               <div class="col-md-6">
                  <label class="form-label">Team Size *</label>
                  <select class="form-select" id="team_size" name="team_size">
                     <option>Select team size</option>
                     <option value="1">Just Me</option>
                     <option value="2">2-5 people</option>
                     <option value="3">6-10 people</option>
                     <option value="4">11-20 people</option>
                     <option value="5">21-50 people</option>
                     <option value="6">50+ people</option>
                  </select>
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">Service Coverage Area *</label>
                  <input type="text" id="service_coverage_area" name="service_coverage_area" class="form-control" placeholder="City/State (e.g., Mumbai, Maharashtra)">
               </div>
               <div class="col-md-6">
                  <label class="form-label">Accepting projects of minimum value (₹) *</label>
                  <input type="number" id="min_project_value" name="min_project_value" class="form-control" placeholder="₹ Minimum project value">
               </div>
            </div>
         </div>
         <hr>
         <!-- Company Details -->
         <div class="form-section">
            <h5>Company Details</h5>
            <!-- ... your existing fields ... -->
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">Company Name *</label>
                  <input type="text" class="form-control" id="company_name" name="company_name">
               </div>
               <div class="col-md-6">
                  <label class="form-label">Type of Entity *</label>
                  <select id="entity_type" name="entity_type" class="form-select">
                     <option value="">-- Select --</option>
                     @foreach ($entity_type as $entity)
                     <option value="{{ $entity->id }}">{{ $entity->entity_type }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="col-md-6 mt-3" id="aadhar_section" style="display: none;">
                  <label class="form-label">Aadhar Card No</label>
                  <input type="text" name="aadhar_card_no" id="aadhar_card_no" class="form-control" placeholder="Enter Aadhar number">
               </div>
               <div class="col-md-6 mt-3" id="cin_section" style="display: none;">
                  <label class="form-label">CIN No</label>
                  <input type="text" name="cin_no" id="cin_no" class="form-control" placeholder="Enter CIN number">
               </div>
               <div class="col-md-6 mt-3" id="llpin" style="display: none;">
                  <label class="form-label">LLPIN No</label>
                  <input type="text" name="llpin_no" id="llpin_no" class="form-control" placeholder="Enter LLPIN number">
               </div>
            </div>
            <div class="mb-3">
               <label class="form-label">Registered Office Address *</label>
               <textarea class="form-control" id="registered_address" name="registered_address"></textarea>
            </div>
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">Contact Person Designation *</label>
                  <input type="text" id="contact_person_designation" name="contact_person_designation" class="form-control">
               </div>
               <div class="col-md-6">
                  <label class="form-label">GST Number *</label>
                  <input type="text" id="gst_number" name="gst_number" class="form-control">
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">PAN Number *</label>
                  <input type="text" id="pan_number" name="pan_number" class="form-control">
               </div>
               <div class="col-md-6">
                  <label class="form-label">TAN Number</label>
                  <input type="text" id="tan_number" name="tan_number" class="form-control">
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">ESIC Number</label>
                  <input type="text" id="esic_number" name="esic_number" class="form-control">
               </div>
               <div class="col-md-6">
                  <label class="form-label">PF No</label>
                  <input type="text" id="pf_code" name="pf_code" class="form-control">
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">MSME/Udyam Registered *</label><br>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="msme_registered" value="yes" onclick="toggleMsmeUpload()">
                     <label class="form-check-label">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="msme_registered" value="no" onclick="toggleMsmeUpload()">
                     <label class="form-check-label">No</label>
                  </div>
                  <!-- File upload input (hidden by default) -->
                  <div id="msmeUploadSection" style="display: none; margin-top: 10px;">
                     <label for="msme_file" class="form-label">Upload MSME/Udyam Certificate:</label>
                     <input type="file" id="msme_file" name="msme_file" class="form-control">
                  </div>
               </div>
               <div class="col-md-6" id="aadhar_pan_link_section" style="display: none;">
                  <label class="form-label">PAN-Aadhar Seeded? *</label><br>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="pan_aadhar_seeded" value="yes" onclick="toggleOptions()">
                     <label class="form-check-label">Yes</label>
                  </div>
                  <div class="form-check form-check-inline">
                     <input class="form-check-input" type="radio" name="pan_aadhar_seeded" value="no" onclick="toggleOptions()">
                     <label class="form-check-label">No</label>
                  </div>
                  <!-- File Upload -->
                  <div id="uploadSection" style="display: none; margin-top: 10px;">
                     <label for="uploadadharpanFile" class="form-label">Upload link Document:</label>
                     <input type="file" id="uploadadharpanFile" name="uploadadharpanFile" class="form-control">
                  </div>
                  <!-- Link shown only if "No" is selected -->
                  <div id="linkSection" style="display: none; margin-top: 10px;">
                     <a href="https://eportal.incometax.gov.in/iec/foservices/#/pre-login/bl-link-aadhaar" target="_blank">
                     Click here to link PAN with Aadhar
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <hr>
         <!-- Bank Details -->
         <div class="form-section">
            <h5>Bank Details</h5>
            <!-- ... your existing fields ... -->
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">Bank Name *</label>
                  <input type="text"id="bank_name" name="bank_name" class="form-control">
               </div>
               <div class="col-md-6">
                  <label class="form-label">Account Number *</label>
                  <input type="text" id="account_number" name="account_number" class="form-control">
               </div>
            </div>
            <div class="row mb-3">
               <div class="col-md-6">
                  <label class="form-label">IFSC Code *</label>
                  <input type="text" id="ifsc_code" name="ifsc_code" class="form-control">
               </div>
               <div class="col-md-6">
                  <label class="form-label">Type of Account *</label>
                  <select class="form-select" id="account_type" name="account_type">
                     <option>Select account type</option>
                     <option value="1">Savings</option>
                     <option value="2">Current</option>
                  </select>
               </div>
            </div>
            <div class="mb-3">
               <label class="form-label">Upload Cancelled Cheque or Bank Passbook Copy *</label>
               <input type="file" id="cancelled_cheque_file" name="cancelled_cheque_file" class="form-control">
            </div>
         </div>
         <!-- Required Documents -->
         <div class="form-section">
            <h5>Required Documents</h5>
            <!-- ... your existing fields ... -->
            <div class="row g-3">
               <div class="col-md-6">PAN Card *<input type="file" id="pan_card_file" name="pan_card_file" class="form-control" placeholder="Upload PAN Card"></div>
               <div class="col-md-6">Aadhaar Card (Authorised Person) *<input type="file" id="aadhaar_card_file" name="aadhaar_card_file" class="form-control" placeholder="Upload Aadhaar Card"></div>
               <div class="col-md-6">Certificate of Incorporation (If company/LLP) *<input type="file" id="certificate_of_incorporation_file" name="certificate_of_incorporation_file" class="form-control" placeholder="Upload Certificate of Incorporation"></div>
               <div class="col-md-6">3 Years ITR PDF (Latest First) *<input type="file" id="itr_file" name="itr_file" class="form-control" placeholder="Upload ITR Documents"></div>
               <div class="col-md-6">Turnover Certificate (CA Certified) *<input type="file" id="turnover_certificate_file" name="turnover_certificate_file" class="form-control" placeholder="Upload Turnover Certificate"></div>
               <div class="col-md-6">Work Completion Certificates – 3 Similar Projects *<input type="file" id="work_completion_certificates_file" name="work_completion_certificates_file" class="form-control" placeholder="Upload Work Completion Certificates"></div>
               <div class="col-md-6">PF / ESIC Registration Documents *<input type="file" id="pf_esic_documents_file" name="pf_esic_documents_file" class="form-control" placeholder="Upload PF/ESIC Documents"></div>
               <div class="col-md-6">Company Profile / Work Brochure (Optional but encouraged)<input type="file" id="company_profile_file" name="company_profile_file" class="form-control" placeholder="Upload Company Profile"></div>
            </div>
         </div>
         <hr>
         <!-- Portfolio & Work Samples -->
         <div class="form-section">
            <h5>Portfolio & Work Samples</h5>
            <!-- ... your existing fields ... -->
            <div class="mb-3">
               <label class="form-label">Upload Portfolio (PDFs, images) *</label>
               <input type="file" id="portfolio_file" name="portfolio_file" class="form-control">
            </div>
            <div class="mb-3">
               <label class="form-label">Upload Past Work Photos *</label>
               <input type="file" id="past_work_photos_file" name="past_work_photos_file" class="form-control">
            </div>
            <div class="mb-3">
               <label class="form-label">License/Certification Upload</label>
               <input type="file" id="license_certificate_file" name="license_certificate_file" class="form-control">
            </div>
         </div>
         <!-- Declaration -->
         {{-- <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="agreed_declaration" name="agreed_declaration">
            <label class="form-check-label" for="agreed_declaration">
            I hereby declare that the above information is true and I am authorised to register this company.
            </label>
         </div>
         <button type="submit" class="btn btn-primary">Submit for Verification</button> --}}
         <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="agreed_declaration" name="agreed_declaration">
                <label class="form-check-label" for="agreed_declaration">
                    I hereby declare that the above information is true and I am authorised to register this company.
                </label>
            </div>

            <button type="submit" class="btn btn-primary">Submit for Verification</button>
      </form>
   </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $('#entity_type').on('change', function () {
   const value = $(this).val();
   
   if (value === '3' || value === '4' || value === '5' ) {
     $('#aadhar_pan_link_section').show();
     
     $('#aadhar_section').show();
     $('#cin_section').hide();
     $('#llpin').hide(); 
   } else if(value === '6'){
     $('#aadhar_pan_link_section').hide();
    
     $('#aadhar_section').hide();
     $('#cin_section').hide();
     $('#llpin').show(); 
   }else if (value !== '') {
     $('#aadhar_pan_link_section').hide();
    
     $('#cin_section').show();
     $('#aadhar_section').hide();
     $('#llpin').hide(); 
   } else {
     $('#llpin').hide();
     $('#aadhar_pan_link_section').hide();
     
     $('#aadhar_section').hide();
     $('#cin_section').hide();
   }
   });
   
   $(document).ready(function () {
     $('#businessForm').on('submit', function (e) {
       e.preventDefault();
   
       let formData = new FormData(this);
   
       $.ajax({
         url: "{{ route('business.store') }}", // Make sure route exists
         method: "POST",
         data: formData,
         contentType: false,
         processData: false,
         headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         },
         beforeSend: function () {
          
         },
         success: function (response) {
           alert('Form submitted successfully!');
           window.location.href = '{{ route("vendor_confiermetion") }}';
          
         },
         error: function (xhr) {
           let errors = xhr.responseJSON.errors;
           let errorText = '';
           for (const field in errors) {
             errorText += `${errors[field]}\n`;
           }
           alert('Error:\n' + errorText);
         }
       });
     });
   });
</script>
<script>
   function toggleOptions() {
     const selectedValue = document.querySelector('input[name="pan_aadhar_seeded"]:checked').value;
     const uploadSection = document.getElementById('uploadSection');
     const linkSection = document.getElementById('linkSection');
   
     if (selectedValue === 'yes') {
       uploadSection.style.display = 'block';
       linkSection.style.display = 'none';
     } else if (selectedValue === 'no') {
       uploadSection.style.display = 'block';
       linkSection.style.display = 'block';
     }
   }
</script>
<script>
   function toggleMsmeUpload() {
     const selectedValue = document.querySelector('input[name="msme_registered"]:checked').value;
     const msmeUploadSection = document.getElementById('msmeUploadSection');
   
     if (selectedValue === 'yes') {
       msmeUploadSection.style.display = 'block';
     } else {
       msmeUploadSection.style.display = 'none';
     }
   }
</script>
@endsection