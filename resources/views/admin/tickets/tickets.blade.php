@extends('layouts.app')

@section('content')
@include('admin.layouts.layout')
<div class="container" syle="font-family:arial">
    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            Pending
        </div>
        <div class="card-content">
            <table id="pendingTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Issuer</th>
                        <th scope="col">Date</th>
                        <th scope="col" style="width:10px;">Function</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                    @if ($ticket->status === 'pending')
                        <tr>
                            <td>{{ $ticket->id}}</td>
                            <td>{{ $ticket->title}}</td>
                            <td>{{ $ticket->type}}</td>
                            <td>{{ $ticket->creator->name }}</td>
                            <td>{{ $ticket->created_at }}</td>
                            <td><a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-dark">View</a></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            In Progress
        </div>
        <div class="card-content">
            <table id="in_progressTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Issuer</th>
                        <th scope="col">Date</th>
                        <th scope="col" style="width:10px;">Function</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                    @if ($ticket->status === 'in_progress')
                        <tr>
                            <td>{{ $ticket->id}}</td>
                            <td>{{ $ticket->title}}</td>
                            <td>{{ $ticket->type}}</td>
                            <td>{{ $ticket->creator->name }}</td>
                            <td>{{ $ticket->created_at }}</td>
                            <td><a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-dark">View</a></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            Completed
        </div>
        <div class="card-content">
            <table id="completedTable" class="table table-striped table-hover table-bordered mt-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Issuer</th>
                        <th scope="col">Date</th>
                        <th scope="col" style="width:10px;">Function</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                    @if ($ticket->status === 'completed')
                        <tr>
                            <td>{{ $ticket->id}}</td>
                            <td>{{ $ticket->title}}</td>
                            <td>{{ $ticket->type}}</td>
                            <td>{{ $ticket->creator->name }}</td>
                            <td>{{ $ticket->created_at }}</td>
                            <td><a href="{{ route('admin.tickets.show', $ticket->id) }}" class="btn btn-dark">View</a></td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#in_progressTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#pendingTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#completedTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>

@endsection