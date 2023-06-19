@extends('layouts.app')

@section('content')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="row mt-5">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-6">
            <div class="card mt-5 shadow p-3 mb-5 bg-white rounded">
                <div class="card-header bg-white">
                    <h5><strong>Create A New User</strong></h5>
                </div>
                <div class="card-content">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password:</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="admin_role">User Role:</label>
                            <select name="admin_role" class="form-control" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <button type="submit" style="float:right" class="btn btn-dark mt-3">Create User</button>
                    </form>
                        <a href="/admin/users" style="float:right; margin-right:5px;" class="btn btn-dark mt-3">Dashboard</a>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
        </div> 
    </div>
</div>
@endsection

