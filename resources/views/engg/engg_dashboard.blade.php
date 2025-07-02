@extends('layouts.engg.app')

@section('title', 'Dashboard')

@section('content')

<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
  <div class="bg-cyan-500 text-white rounded-lg shadow p-6">
    <div class="text-3xl font-bold">6</div>
    <div class="text-xl mt-2">Total Engineer</div>
    
  </div>
  <div class="bg-green-500 text-white rounded-lg shadow p-6">
    <div class="text-3xl font-bold">30</div>
    <div class="text-xl mt-2">Total Customer</div>
   
  </div>
  
</div>

@endsection
