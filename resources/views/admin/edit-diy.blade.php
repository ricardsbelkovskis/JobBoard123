@extends('layouts.app')

@section('content')
    <div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="row mt-5">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-6">
            <div class="card mt-5 shadow p-3 mb-5 bg-white rounded">
                <div class="card-header bg-white">
                    <h5><strong>Edit "{{$diy->title}}" DIY</strong></h5>
                </div>
                <div class="card-content">
                <form action="{{ route('admin.diy.update', $diy->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input type="text" name="title" class="form-control" value="{{ $diy->title }}" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description:</label>
                            <textarea name="description" class="form-control" required>{{ $diy->description }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-dark mt-2">Update DIY Item</button>
                        <a href="/admin/diy" style="margin-left:5px;" class="btn btn-dark mt-2">Dashboard</a>
                </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
        </div> 
    </div>
</div>
@endsection
