@extends('layouts.app')

@section('content')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card mt-4 shadow p-3 bg-white rounded">
                <div class="card-body ">
                    <h1 class="mb-4">Thank you for your purchase!</h1>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Title:</strong> {{$hire->title}}</li>
                        <li class="list-group-item"><strong>Description:</strong> {{$hire->description}}</li>
                        <li class="list-group-item"><strong>Price:</strong> {{$hire->price}}</li>
                        <li class="list-group-item"><strong>Sessopm ID:</strong> {{$session->id}}</li>
                        <li class="list-group-item"><strong>Payment Status:</strong> {{$session->payment_status}}</li>
                    </ul>
                    <a href="/home" class="btn btn-dark" style="float:right">To Profile</a>
                </div>
            </div> 
        </div>
    </div>
</div>
@endsection
