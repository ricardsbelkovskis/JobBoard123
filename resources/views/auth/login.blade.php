@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:8%; font-family:arial">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg">
        <div class="card-body">
          <h5 style="color:gray">Login</h5>
          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">{{ __('Email Address') }}</label>
              <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">{{ __('Password') }}</label>
              <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
              @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
              @enderror
            </div>
            <div class="mb-3 form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label class="form-check-label" for="remember">
                {{ __('Remember Me') }}
              </label>
            </div>
            <div class="d-grid">
              <button type="submit" class="btn btn-dark">{{ __('Login') }}</button>
            </div>
            <div class="text-center mt-3">
              @if (Route::has('password.request'))
                <a class="link-dark" href="{{ route('password.request') }}">
                  Forgot Your Password ?
                </a>
              @endif
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
