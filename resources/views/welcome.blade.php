@extends('layouts.app')

@section('content')
  <div class="container py-5" style="font-family:Arial, Helvetica, sans-serif">
    <h1 class="text-center mb-4">Welcome to Our Platform</h1>
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card mb-4" style="margin-top:30%">
          <div class="card-body">
            <h5 class="card-title">Hire</h5>
            <p class="card-text">Find the perfect talent for your projects.</p>
            <a href="/hire" class="btn btn-dark">HIRE</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4" style="margin-top:30%">
          <div class="card-body">
            <h5 class="card-title">Learn</h5>
            <p class="card-text">Enhance your skills with our educational resources.</p>
            <a href="/diy" class="btn btn-dark">LEARN</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('styles')
<style>
</style>
@endsection

@section('scripts')
@endsection
