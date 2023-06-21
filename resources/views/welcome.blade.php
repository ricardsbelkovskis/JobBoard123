@extends('layouts.app')

@section('content')
  <div class="container py-5" style="font-family:Arial, Helvetica, sans-serif">
    <h1 class="text-center">Learn new things, and sell your skills!</h1>
    <div class="row justify-content-center py-5">
      <div class="col-md-4">
        <div class="card" style="margin-top:30%">
          <div class="card-body">
            <h5 class="card-title">Hire</h5>
            <p class="card-text">Find your talent and start earning.</p>
            <a href="/hire" class="btn btn-dark">HIRE</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card" style="margin-top:30%">
          <div class="card-body">
            <h5 class="card-title">Learn</h5>
            <p class="card-text">Enhance your skills with our educational resources.</p>
            <a href="/diy" class="btn btn-dark">LEARN</a>
          </div>
        </div>
      </div>
    </div>
    <h5 class="text-center mt-4" style="font-weight:bold;">Chose what is your goal, and let's get started!</h5>
  </div>
@endsection

@section('styles')
<style>
</style>
@endsection

@section('scripts')
@endsection
