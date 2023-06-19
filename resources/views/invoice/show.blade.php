@extends('layouts.app')

@section('content')
    <div class="container" style="font-family:Arial, Helvetica, sans-serif">
        <div class="card shadow bg-white rounded">
            <div class="card-header bg-white">
                <h5><strong>Status</strong></h5>
            </div>
            <div class="card-body">
                <p><strong>Your ticket is {{$purchase->status}}</strong></p>
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


        @if($purchase->status === 'completed')
            <div class="card mt-4 shadow bg-white rounded">
                <div class="card-header bg-white">
                    <h5><strong>Leave a Review</strong></h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('reviews.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <textarea class="form-control" id="content" name="content" rows="3" placeholder="Type your review here"></textarea>
                    </div>

                    <button type="submit" class="btn btn-dark mt-2" style="float:right;">Submit Review</button>
                    </form>
                </div>
            </div>
        @endif

        <div class="card mt-4 shadow bg-white rounded">
            <div class="card-body">
                <h5 class="ms-3 mt-2"><strong>Conversation</strong></h5>
                @if ($purchase->conversation)
                    <div class="conversation ms-3">
                        @foreach ($purchase->conversation->messages as $message)
                            <p><strong>{{ $message->sender->name }}:</strong> {{ $message->message }}</p>
                        @endforeach
                    </div>

                    <form action="{{ route('messages.store') }}" class="ms-3" method="POST">
                        @csrf
                        <input type="hidden" name="purchase_id" value="{{ $purchase->id }}">
                        <input type="hidden" name="receiver_id" value="{{ $purchase->hire->user->id }}">
                        <div class="form-group">
                            <textarea name="message" class="form-control" placeholder="Type your message here"></textarea>
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
        $('form[action="{{ route('reviews.store') }}"]').submit(function(e) {
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
                        title: 'Review Submitted',
                        text: 'Your review has been submitted successfully!',
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while submitting your review.',
                    });
                }
            });
        });
    });
</script>

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