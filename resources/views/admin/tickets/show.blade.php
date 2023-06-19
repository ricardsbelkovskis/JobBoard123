@extends('layouts.app')

@section('content')
@include('admin.layouts.layout')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="row mt-4">
        <div class="col-lg-3">
            <div class="card shadow p-3 mb-5 bg-white rounded">
                <div class="card-content text-center">
                    <img src="{{ asset('storage/' . $ticket->creator->avatar) }}" class="rounded-circle mt-3 mb-3" width="130" height="130">
                    <p><strong><a style="text-decoration:none; color:black" href="{{ route('publicProfile', $ticket->creator->id) }}">{{$ticket->creator->name}}</a></strong></p>
                    <p style="margin-top:-5%">{{$ticket->creator->admin_role}}</p>
                </div>
            </div>
        </div>
        <div class="col-sm">
            <div class="card shadow p-3 bg-white rounded">
                <div class="card-content">
                    <div class="card shadow bg-white rounded">
                        <h5 class="mt-2 mb-2 ms-3" style="font-weight:bold;">Ticket Info: #{{$ticket->id}}</h5>
                    </div>
                    <div class="row mt-3">
                            <div class="col-sm-4">
                                <div class="card shadow p-3 bg-white rounded">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Title:</strong> {{$ticket->title}}</li>
                                        <li class="list-group-item"><strong>Type:</strong> {{$ticket->type}}</li>
                                        <li class="list-group-item"><strong>Issuer ID:</strong> {{$ticket->creator->id}}</li>
                                        <li class="list-group-item"><strong>Issuer Name:</strong> {{$ticket->creator->name}}</li>
                                        <li class="list-group-item"><strong>Email:</strong> {{$ticket->creator->email}}</li>
                                        <li class="list-group-item"><strong>Issued At:</strong> {{$ticket->created_at}}</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm">
                                <div class="card shadow p-3 bg-white rounded">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>Description:</strong><br> {{$ticket->description}}</li>
                                        <li class="list-group-item"><strong>Status:</strong>
                                        <form method="POST" action="{{ route('admin.ticket.status.update', $ticket->id) }}">
                                        @csrf
                                        @method('PUT')
                                            <div class="form-group">
                                                <select name="status" id="status" class="form-control">
                                                    <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                                    <option value="completed" {{ $ticket->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                                </select>
                                            </div>
                                            <button type="submit" style="float:right;" class="btn btn-dark mt-2">Update</button>
                                        </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
