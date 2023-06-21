@extends('layouts.app')

@section('content')
<div class="container mt-5" style="font-family:Arial, Helvetica, sans-serif">
    <div class="card shadow bg-white rounded">
        <div class="card-header bg-white">
            <h5>Update Order Status</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('status.update', $purchase->id) }}" method="POST">
                @csrf
                @method('PUT')
                <label for="status">Status:</label>
                <select class="form-select" name="status" id="status">
                    <option value="pending" {{ $purchase->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $purchase->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $purchase->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button class="btn btn-dark mt-2" style="float:right;" type="submit">Update Status</button>
            </form>
        </div>
    </div>

    <div class="card mt-4 shadow bg-white rounded">
        <div class="card-body">
            <h5 class="ms-3"><strong>Purchase ID: {{ $purchase->id }}</strong></h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Hired user: {{$purchase->hire->user->name}}</li>
                <li class="list-group-item">Hired by:{{$purchase->user->name}}</li>
                <li class="list-group-item">Purchased on: {{ $purchase->created_at }}</li>
            </ul>
        </div>
    </div>

    <div class="card mt-4 shadow bg-white rounded">
        <div class="card-body">
            <h5 class="ms-3 mt-2"><strong>Conversation</strong></h5>
                @if ($purchase->conversation)
                    <div class="conversation ms-3">
                        @foreach ($purchase->conversation->messages as $message)
                            <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                        @endforeach
                    </div>

                    <form class="ms-3" action="{{ route('messages.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                        <input type="hidden" name="receiver_id" value="{{ $purchase->user->id }}">
                        <div class="form-group">
                            <textarea name="message" class="form-control" placeholder="Type your message here" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-dark mt-2" style="float:right">Send Message</button>
                    </form>
                @else
                    <p>No conversation available.</p>
                @endif
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
    $(document).ready(function() {
        $('form[action="{{ route('messages.store') }}"]').submit(function(e) {
            e.preventDefault();

            var formData = new FormData($(this)[0]);

            var form = $(this);

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log(response);

                    Swal.fire({
                        icon: 'success',
                        title: 'Message Sent',
                        text: 'Your message has been sent successfully!',
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while sending your message.',
                    });
                }
            });
        });
    });
</script>
@endsection