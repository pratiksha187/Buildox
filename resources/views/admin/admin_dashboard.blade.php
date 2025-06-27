@extends('layouts.admin.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-6">
  <div class="bg-cyan-500 text-white rounded-lg shadow p-6">
    <div class="text-3xl font-bold">6</div>
    <div class="text-xl mt-2">Murid</div>
    <a href="#" class="text-sm underline mt-4 inline-block">More info</a>
  </div>
  <div class="bg-green-500 text-white rounded-lg shadow p-6">
    <div class="text-3xl font-bold">30</div>
    <div class="text-xl mt-2">Tes</div>
    <a href="#" class="text-sm underline mt-4 inline-block">More info</a>
  </div>
  <div class="bg-yellow-500 text-white rounded-lg shadow p-6">
    <div class="text-3xl font-bold">8</div>
    <div class="text-xl mt-2">Administrator</div>
    <a href="#" class="text-sm underline mt-4 inline-block">More info</a>
  </div>
  <div class="bg-red-500 text-white rounded-lg shadow p-6">
    <div class="text-3xl font-bold">1</div>
    <div class="text-xl mt-2">Super Administrator</div>
    <a href="#" class="text-sm underline mt-4 inline-block">More info</a>
  </div>
</div>
@endsection
