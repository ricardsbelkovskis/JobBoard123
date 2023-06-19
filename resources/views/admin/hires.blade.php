@extends('layouts.app')

@section('content')
@include('admin.layouts.layout')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>Hires</strong></h5>
        </div>
        <div class="card-content">
            <table id="HiresTable" class="table table-striped table-hover table-bordered mt-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th>Date</th>
                        <th scope="col" style="width:10px;">Function</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($hires as $hire)
                    <tr>
                        <td>{{ $hire->id }}</td>
                        <td>{{ $hire->title }}</td>
                        <td>{{ $hire->user->name }}</td>
                        <td>{{ $hire->price }}</td>
                        <td>{{ $hire->created_at }}</td>
                        <td>
                            <form action="{{ route('admin.hires.delete', $hire->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-dark">Delete</button>
                            </form>
                        </td>
                    </tr>
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
        $('#HiresTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>
@endsection