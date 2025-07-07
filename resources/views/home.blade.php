
@extends('layouts.app')

@section('title', 'Select Your Role')

@section('content')
<!-- Main -->
  <div class="main-section">
    <h2 class="fw-bold text-dark">Who are you?</h2>
    <p class="text-muted">Select your role to proceed with Constructkaro</p>

    <div class="role-grid">
      <a href="{{ route('project') }}" class="role-card build-role">
        <div class="role-icon">🏗️</div>
        <div class="role-title">I want to build/develop</div>
        <div class="role-desc">Find experts, get quotes, manage construction</div>
      </a>

      <a href="{{ route('service_provider') }}" class="role-card service-role">
        <div class="role-icon">👷</div>
        <div class="role-title">I’m a service provider</div>
        <div class="role-desc">Get leads, bid on projects, grow your business</div>
      </a>
    </div>
  </div>

@endsection