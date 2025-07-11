@extends('layouts.app')

@section('content')

<title>Pricing Packages</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

<style>
  * {
    box-sizing: border-box;
    font-family: 'Inter', sans-serif;
  }

  h2 {
    font-size: 28px;
    margin-bottom: 10px;
  }

  p.subtext {
    color: #666;
    margin-bottom: 40px;
  }

  .card-wrapper {
    background: #ffffff;
    padding: 40px 20px;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
    max-width: 1100px;
    margin: 0 auto;
  }

  .packages {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px;
  }

  .card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    width: 280px;
    padding: 30px 20px;
    text-align: left;
    position: relative;
    transition: transform 0.2s;
  }

  .card:hover {
    transform: translateY(-5px);
  }

  .card h3 {
    color: #5a39d5;
    font-size: 20px;
    margin: 0;
  }

  .card small {
    color: #666;
    display: block;
    margin-bottom: 16px;
  }

  .card .price {
    font-size: 28px;
    font-weight: 700;
    margin-bottom: 10px;
  }

  .card .price span {
    font-size: 16px;
    font-weight: 400;
    color: #777;
  }

  .features {
    list-style: none;
    padding: 0;
    margin: 20px 0;
  }

  .features li {
    padding: 6px 0;
    color: #2d2d2d;
  }

  .features li::before {
    content: "✔";
    color: #3ac96c;
    margin-right: 8px;
  }

  .select-btn {
    background-color: #5a39d5;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    width: 100%;
    font-size: 14px;
  }

  .select-btn:hover {
    background-color: #472cb2;
  }

  .badge {
    position: absolute;
    top: -12px;
    right: -12px;
    background-color: #ffc107;
    color: black;
    padding: 4px 10px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 600;
  }

  @media (max-width: 900px) {
    .packages {
      flex-direction: column;
      align-items: center;
    }
  }
</style>

<div class="card-wrapper">
  <p>Please select the option that best describes your current situation:</p>
  <h2>Our Ready-Made Packages</h2>
  <p class="subtext">Select a package that best fits your project needs. All packages can be customized further.</p>
<form method="POST" action={{ route('razorpaypayment') }}>
    @csrf
  <div class="packages">
<div class="card-wrapper">
  <p>Please select the option that best describes your current situation:</p>
  <h2>Our Ready-Made Packages</h2>
  <p class="subtext">Select a package that best fits your project needs. All packages can be customized further.</p>

  <div class="packages">

    <!-- Essential Package -->
    <form method="POST" action="{{ route('razorpaypayment') }}">
      @csrf
      <div class="card">
        <h3>Essential</h3>
        <small>For smaller projects</small>
        <div class="price">Rs. 1<span>starting at</span></div>
        <ul class="features">
          <li>Basic design consultation</li>
          <li>Standard materials</li>
          <li>3-month timeline</li>
          <li>1-year warranty</li>
        </ul>
        <input type="hidden" name="amount" value="1"> {{-- Rs. 1 = 100 paise --}}
        <input type="hidden" name="package" value="Essential">
        <button class="select-btn" type="submit">Select Package</button>
      </div>
    </form>

    <!-- Premium Package -->
    <form method="POST" action="{{ route('razorpaypayment') }}">
      @csrf
      <div class="card">
        <div class="badge">POPULAR</div>
        <h3>Premium</h3>
        <small>For medium-sized projects</small>
        <div class="price">Rs. 1<span>starting at</span></div>
        <ul class="features">
          <li>Advanced design consultation</li>
          <li>Premium materials</li>
          <li>6-month timeline</li>
          <li>3-year warranty</li>
          <li>Project management included</li>
        </ul>
        <input type="hidden" name="amount" value="1">
        <input type="hidden" name="package" value="Premium">
        <button class="select-btn" type="submit">Select Package</button>
      </div>
    </form>

    <!-- Luxury Package -->
    <form method="POST" action="{{ route('razorpaypayment') }}">
      @csrf
      <div class="card">
        <h3>Luxury</h3>
        <small>For high-end projects</small>
        <div class="price">Rs. 1<span>starting at</span></div>
        <ul class="features">
          <li>Full architectural services</li>
          <li>Luxury materials</li>
          <li>Custom timeline</li>
          <li>5-year warranty</li>
          <li>Dedicated project manager</li>
          <li>Interior design services</li>
        </ul>
        <input type="hidden" name="amount" value="1">
        <input type="hidden" name="package" value="Luxury">
        <button class="select-btn" type="submit">Select Package</button>
      </div>
    </form>

  </div>
</div>

  </div>
</form>
</div>


<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

@endsection
