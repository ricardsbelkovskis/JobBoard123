@extends('layouts.app')

@section('content')
<div class="container" style="font-family:arial">
    <div class="card shadow bg-white rounded">
        <div class="card-content">
            <h5 class="ms-3 mt-2 mb-2">My Tickets</h5>
        </div>
    </div>

    <div class="card shadow bg-white rounded p-1 mt-2">
        <div class="card-content">
            <a href="/tickets/create" style="float:right" class="btn btn-dark ms-3">Create A Ticket</a>
        </div>
    </div>

    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>Pending</strong></h5>
        </div>
        <div class="card-content">
            <table id="MypendingTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                  @if (auth()->check() && auth()->id() == $ticket->creator_id)
                    @if ($ticket->status === 'pending')
                        <tr>
                            <td>{{ $ticket->title}}</td>
                            <td>{{ $ticket->type}}</td>
                            <td>{{ $ticket->created_at }}</td>
                        </tr>
                    @endif
                  @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>In Progress</strong></h5>
        </div>
        <div class="card-content">
            <table id="Myin_progressTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                  @if (auth()->check() && auth()->id() == $ticket->creator_id)
                    @if ($ticket->status === 'in_progress')
                        <tr>
                            <td>{{ $ticket->title}}</td>
                            <td>{{ $ticket->type}}</td>
                            <td>{{ $ticket->created_at }}</td>
                        </tr>
                    @endif
                  @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>Completed</strong></h5>
        </div>
        <div class="card-content">
            <table id="MycompletedTable" class="table table-striped table-hover table-bordered mt-2">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Type</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($tickets as $ticket)
                  @if (auth()->check() && auth()->id() == $ticket->creator_id)
                    @if ($ticket->status === 'completed')
                        <tr>
                            <td>{{ $ticket->title}}</td>
                            <td>{{ $ticket->type}}</td>
                            <td>{{ $ticket->created_at }}</td>
                        </tr>
                    @endif
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
        $('#Myin_progressTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#MypendingTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#MycompletedTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>
@endsection