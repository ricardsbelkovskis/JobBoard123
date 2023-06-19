@extends('layouts.app')

@section('content')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="card shadow p-3 mb-5 bg-white rounded" style="margin-top:5%">
        <div class="card-header bg-white">
            <h5><strong>DIY Blogs</strong></h5>
        </div>
        <div class="card-content">
            <table id="diyTable" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Posted</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($diys as $diy)
                        <tr onclick="window.location.href='{{ route('diys.show', $diy)}}';" style="cursor: pointer;">
                            <td>{{ $diy->title }}</td>
                            <td>{{ $diy->user->name }}</td>
                            <td>{{ $diy->created_at->diffForHumans() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('styles')
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#diyTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>

@endsection