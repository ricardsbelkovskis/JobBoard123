@extends('layouts.app')

@section('content')
@if(Auth::check())
<div class="container">
    <h1>Welcome, {{ Auth::user()->name }}!</h1>
    <p>You are now logged in.</p>
</div>
@else
<!-- Welcome Block -->
<div class="row my-5">
  <div class="col-md-8 offset-md-2 text-center">
    <h1 class="display-4 font-weight-bold">SkillMarket</h1>
    <p class="lead">Unlock Knowledge, Empower Talent: Learn and Hire with Ease!</p>
    <a href="/register" class="btn btn-primary mt-3">Get Started</a>
  </div>
</div>

<!-- About Our Site Block -->
<div class="row my-5">
  <div class="col-md-8 offset-md-2 text-center">
    <h2 class="font-weight-bold">About Our Site</h2>
    <p class="mx-auto" style="max-width: 600px;">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Omnis accusantium quae at fugiat illo, culpa asperiores eaque impedit commodi optio facilis neque veritatis earum. Maiores eos ipsam quia veritatis quae?
    </p>
  </div>
</div>

<!-- How Does It Work Block -->
<div class="row my-5">
  <div class="col-md-8 offset-md-2">
    <h2 class="text-center font-weight-bold">How Does It Work</h2>
    <div class="row mt-4">
      <div class="col-md-4">
        <h4>Step 1</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
      </div>
      <div class="col-md-4">
        <h4>Step 2</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
      </div>
      <div class="col-md-4">
        <h4>Step 3</h4>
        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
      </div>
    </div>
  </div>
</div>

<div class="container mx-auto">
  <div class="row my-5">
  <div class="col-md-2">
    </div>
    <div class="col-md-4">
      <h2>Ask us a question</h2>
      <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec euismod, sem in vehicula dictum, ex quam vehicula tortor, at dignissim lacus nulla ut mi. Duis ut ipsum vitae mi congue eleifend. Proin gravida, nibh ac lobortis elementum, ex nisl lobortis lacus, vel pulvinar metus enim in felis. Fusce vel felis sed massa bibendum feugiat. Duis eu purus mi. Donec eget est dolor.</p>
    </div>
    <div class="col-md-4">
      <form>
        <div class="mb-3">
          <label for="name" class="form-label">Your Name</label>
          <input type="text" class="form-control form-control-sm" id="name" />
        </div>
        <div class="mb-3">
          <label for="email" class="form-label">Your Email</label>
          <input type="email" class="form-control form-control-sm" id="email" />
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Your Message</label>
          <textarea class="form-control form-control-sm" id="message" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
    </div>
  </div>
</div>

@endif
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection