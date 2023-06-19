@extends('layouts.app')

@section('content')
@include('admin.layouts.layout')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>Pending Hires</strong></h5>
        </div>
        <div class="card-content">
        @if ($cashoutsPending->count() > 0)
            <table id="PendingTable" class="table table-striped table-hover table-bordered mt-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col" style="width:10px;">Function</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($cashoutsPending as $cashout)
                <tr>
                    <td>{{ $cashout->id }}</td>
                    <td>{{ $cashout->title }}</td>
                    <td>{{ $cashout->amount }}</td>
                    <td>{{ $cashout->status }}</td>
                    <td>{{ $cashout->created_at }}</td>
                    <td>
                    <form action="{{ route('admin.cashouts.accept', $cashout) }}" method="POST">
                    @csrf
                        <button type="submit" class="btn btn-success">Accept</button>
                    </form>

                    <form action="{{ route('admin.cashouts.reject', $cashout) }}" method="POST">
                    @csrf
                        <button type="submit" class="btn btn-danger">Reject</button>
                    </form>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
            @else
            <p>No pending cashouts found.</p>
            @endif
        </div>
    </div>
    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>Accepted Hires</strong></h5>
        </div>
        <div class="card-content">
            <table id="AcceptedTable" class="table table-striped table-hover table-bordered mt-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Accepted Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($cashouts as $cashout)
                    @if ($cashout->status === 'accepted')
                        <tr>
                            <td>{{ $cashout->id }}</td>
                            <td>{{ $cashout->title }}</td>
                            <td>{{ $cashout->amount }}</td>
                            <td>{{ $cashout->status }}</td>
                            <td>{{ $cashout->updated_at }}</td>
                        </tr>
                    @endif
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>Rejected Hires</strong></h5>
        </div>
        <div class="card-content">
            <table id="RejectedTable" class="table table-striped table-hover table-bordered mt-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Status</th>
                        <th scope="col">Rejected Date</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($cashouts as $cashout)
                    @if ($cashout->status === 'rejected')
                        <tr>
                            <td>{{ $cashout->id }}</td>
                            <td>{{ $cashout->title }}</td>
                            <td>{{ $cashout->amount }}</td>
                            <td>{{ $cashout->status }}</td>
                            <td>{{ $cashout->updated_at }}</td>
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
        $('#PendingTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#AcceptedTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#RejectedTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>
@endsection
