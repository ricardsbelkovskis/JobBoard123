@extends('layouts.app')

@section('content')
@include('admin.layouts.layout')

<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>User Diys</strong></h5>
        </div>
        <div class="card-content">
            <table id="DiysTable" class="table table-striped table-hover table-bordered mt-2">
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
                @foreach ($diy as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->user->name }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td class='text-center'>
                            <form action="{{ route('admin.diy.delete', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-dark">Delete</button>
                            </form>
                            <a href="{{ route('admin.diy.edit', $item->id) }}" class="btn btn-dark mt-2">Edit</a>
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
        $('#DiysTable').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>
@endsection