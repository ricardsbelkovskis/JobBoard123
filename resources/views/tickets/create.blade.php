@extends('layouts.app')

@section('content')
    <div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div class="row mt-5">
        <div class="col-lg-3">
        </div>
        <div class="col-lg-6">
            <div class="card mt-5 shadow p-3 mb-5 bg-white rounded">
                <div class="card-header bg-white">
                    <h5><strong>Create A Ticket</strong></h5>
                </div>
                <div class="card-content">
                <form action="{{ route('tickets.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="type">Type</label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="General">General</option>
                            <option value="Technical">Technical</option>
                            <option value="Billing">Billing</option>
                        </select>
                    </div>
                    <button type="submit" style="float:right" class="btn btn-dark mt-3">Create</button>
                </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
        </div> 
    </div>
</div>
@endsection

