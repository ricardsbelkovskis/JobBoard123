@extends('layouts.app')

@section('content')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="row justify-content-center mt-4">
        <div class="col-md-8">
            <div class="card card mt-5 shadow p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h4 class="mb-4"><strong>Your support ticket has been submitted successfully</strong></h4>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>ID:</strong> {{$ticket->id}}</li>
                            <li class="list-group-item"><strong>Title:</strong> {{$ticket->title}}</li>
                            <li class="list-group-item"><strong>Type:</strong> {{$ticket->type}}</li>
                            <li class="list-group-item"><strong>Type:</strong> {{$ticket->status}}</li>
                            <li class="list-group-item"><strong>Submit Date:</strong> {{$ticket->created_at}}</li>
                        </ul>
                    <p class="mt-4 ms-3">An admin will be in contact with you shortly.</p>
                    <a href="/tickets" class="btn btn-dark ms-3">My Tickets</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
