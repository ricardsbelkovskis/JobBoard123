@extends('layouts.app')

@section('content')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
  <div class="row">
    <div class="col-md-3 text-center">
      <div class="card mt-4 shadow p-3 bg-white rounded">
        @if ($hire->user)
        <img src="{{ asset('storage/' . $hire->user->avatar) }}" class="rounded-circle" style="width: 150px; height: 150px; margin-left:auto; margin-right:auto; margin-top:20px;">
            <h5 class="card-title mt-3"> <a style ="color:black;text-decoration:none"href="{{ route('publicProfile', $hire->user->id) }}">{{ $hire->user->name }}</a></h5>
            <p><strong></strong> {{ $hire->user->role }}</p>
        @endif
      </div>
    </div>
    <div class="col-md-9">
      <div class="card mt-4 shadow p-3 bg-white rounded">
        <div class="card-container">
          <div class="row">
            <div class="col-md-5">
              <div id="photo-carousel" class="carousel slide p-4" data-bs-ride="carousel">
                <div id="photo-carousel" class="carousel slide shadow p-3  bg-white rounded" data-bs-ride="carousel" style="max-width: 500px;">
                  <div class="carousel-inner">
                    @foreach ($photos as $key => $photo)
                      <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                        <img src="{{ asset('storage/' . $photo->path) }}" class="d-block w-100" style="object-fit: cover; width: 500px; height: 500px;" alt="Photo">
                      </div>
                    @endforeach
                  </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#photo-carousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#photo-carousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
              </div>
            </div>
            <div class="col-md-7">
              <div class="card shadow p-3 mt-4 bg-white rounded">
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item"><strong>Title:</strong> {{$hire->title}}</li>
                    <li class="list-group-item"><strong>Lister:</strong> {{$hire->user->name}}</li>
                    <li class="list-group-item"><strong>Finishing time:</strong> {{$hire->time_to_finish}} days</li>
                    <li class="list-group-item"><strong>Description:</strong> {{$hire->description}}</li>
                    <li class="list-group-item"><strong>Contact Email:</strong> {{$hire->user->email}}</li>
                    <li class="list-group-item"><strong>Price:</strong> {{$hire->price}}</li>
                  </ul>
              </div>

              <div class="card shadow p- mt-4 bg-white rounded">
                 <p class="mt-3 ms-2"><strong>Listing Listed:</strong> {{$hire->created_at}}</p>
              </div>

              <a href="{{ route('hire.payment', ['hire' => $hire->id]) }}" class="checkout-icon btn btn-success" style="float:right; margin-top:27%"><strong>Hire</strong></a>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
@endsection

<!-- 




<div class="card mt-4">
        <div class="card-header">
        <div class="functions" style="background-color:transparent;">
            <div class="d-flex justify-content-end">
                <div class="btn-group">
                @if ($hire->user_id === Auth::user()->id)
                    <form id="deleteDiyForm" action="{{ route('hire.delete', ['hire' => $hire->id]) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="margin-left:5px; border-color:transparent; background-color:transparent ">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                @endif
                </div>
            </div>
        </div>
        </div>
        <div class="card-body">
            <h5>{{$hire->title}}</h5>
            <p>{{$hire->description}}</p>
            <p>Price: {{$hire->price}}$</p>
            <a href="{{ route('hire.payment', ['hire' => $hire->id]) }}" class="checkout-icon btn btn-success" style="float:right;"><i class="fas fa-shopping-cart"></i></a>
      </div> -->