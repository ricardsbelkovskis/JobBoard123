@extends('layouts.app')

@section('content')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="row mt-5">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-6">
            <div class="card mt-5 shadow p-3 mb-5 bg-white rounded">
                <div class="card-header bg-white">
                    <h5><strong>Edit "{{$user->name}}" Profile</strong></h5>
                </div>
                <div class="card-content">
                    <form id="userEditForm" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="admin_role">User Role:</label>
                            <select name="admin_role" class="form-control" required>
                                <option value="admin" {{ $user->admin_role === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="user" {{ $user->admin_role === 'user' ? 'selected' : '' }}>User</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-dark mt-2">Update User</button>
                    </form>
                    <a href="/admin/users" class="btn btn-dark mt-2">Dashboard</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
        </div> 
    </div>
</div>
@endsection
