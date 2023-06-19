@extends('layouts.app')

@section('content')
<div class="container" style="font-family:arial">
    <div class="card card shadow bg-white rounded">
        <div class="card-content">
            <h5 class="ms-3 mt-2 mb-2">My Cashouts <button style="margin-left:80%" class="btn btn-dark" onclick="openCashoutModal()">Create a Cashout</button></h5>
        </div>
    </div>

    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>Pending Cashouts</strong></h5>
        </div>
        <div class="card-content">
        @if ($cashoutsPending->count() > 0)
            <table id="MyPending" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total</th>
                        <th scope="col">Cashout Created At</th>
                        <th scope="col" style="width:10px;">Function</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cashoutsPending as $cashout)
                        <tr>
                            <td>{{ $cashout->title }}</td>
                            <td>{{ $cashout->status }}</td>
                            <td>{{ $cashout->total }}</td>
                            <td>{{ $cashout->created_at }}</td>
                            <td>
                                <form action="{{ route('cashout.delete', $cashout->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Cancel</button>
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
            <h5><strong>Accepted Cashouts</strong></h5>
        </div>
        <div class="card-content">
        @if ($cashoutsCompleted->count() > 0)
            <table id="MyAccepted" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cashoutsCompleted as $cashout)
                        <tr>
                            <td>{{ $cashout->title }}</td>
                            <td>{{ $cashout->status }}</td>
                            <td>{{ $cashout->total }}</td>
                            <td>{{ $cashout->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No completed cashouts found.</p>
        @endif
        </div>
    </div>

    <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
            <h5><strong>Rejected Cashouts</strong></h5>
        </div>
        <div class="card-content">
        @if ($cashoutsRejected->count() > 0)
            <table id="MyRejected" class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cashoutsRejected as $cashout)
                        <tr>
                            <td>{{ $cashout->title }}</td>
                            <td>{{ $cashout->status }}</td>
                            <td>{{ $cashout->total }}</td>
                            <td>{{ $cashout->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No rejected cashouts found.</p>
        @endif
        </div>
    </div>
</div>

<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div id="cashoutModal" class="modalMC">
        <div class="modal-contentMC card shadow p-3 mb-5 bg-white rounded">
                <div class="card card shadow p-1 mb-3 bg-white rounded">
                    <div class="card-content p-1">
                        <h5 class="modal-title"><strong>Issue a Cashout </strong><span style="margin-top:-7px;"class="closeMC" onclick="closeCashoutModal()">&times;</span></h5>
                    </div>
                </div>
            <div class="card shadow p-3 mb-3 bg-white rounded">
             <div class="card-content">
                <form action="{{ route('cashout.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="title">Cashout Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="purchase">Select a Purchase</label>
                        <select class="form-control" id="purchase" name="purchase" required>
                            @foreach ($purchases as $purchase)
                                <option value="{{ $purchase->id }}" data-amount="{{ $purchase->hire->price }}">{{ $purchase->hire->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="bank_account">Bank Account</label>
                        <input type="text" name="account_number" class="form-control" required>
                    </div>

                    <div class="form-group d-none">
                        <label for="amount">Amount</label>
                        <input type="text" name="amount" class="form-control" value="{{ $amount }}" readonly>
                    </div>

                    <div class="form-group d-none">
                        <label for="fee">Fee (10%)</label>
                        <input type="text" name="fee" class="form-control" value="{{ $siteFee }}" readonly>
                    </div>

                    <div class="form-group d-none">
                        <label for="total">Total</label>
                        <input type="text" name="total" class="form-control" value="" readonly>
                    </div>

                    <button type="submit" style="float:right" class="btn btn-dark mt-2">Request Cashout</button>
                </form>
             </div>
            </div>
                <div class="card shadow p-3 mb-2 bg-white rounded">
                    <div class="card-content">
                        <h5>Summary</h5>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>ID:</strong> <span id="amountSummary"></span></li>
                            <li class="list-group-item"><strong>Title:</strong><span id="feeSummary"></span></li>
                            <li class="list-group-item"><strong>Type:</strong><span id="totalSummary"></span></li>
                        </ul>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#MyPending').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#MyAccepted').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#MyRejected').DataTable({
            "paging": true,
            "searching": true,
            "info": false
        });
    });
</script>
<script>
    function openCashoutModal() {
      document.getElementById("cashoutModal").style.display = "block";
    }

    function closeCashoutModal() {
      document.getElementById("cashoutModal").style.display = "none";
    }
</script>

<script>
    $(document).ready(function() {
        $('#purchase').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var amount = selectedOption.data('amount');
            var fee = amount * 0.1;
            var total = amount - fee;

            // Hide or show the form fields based on the selected option
            if (amount !== '') {
                $('#amount').val(amount);
                $('#fee').val(fee);
                $('#total').val(total);
                $('.form-fields').show(); // Show the form fields
            } else {
                $('.form-fields').hide(); // Hide the form fields
            }

            $('#amountSummary').text(amount);
            $('#feeSummary').text(fee);
            $('#totalSummary').text(total);
        });
    });
</script>
@endsection

@section('styles')
<style>
    .modalMC {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-contentMC {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 20px;
        width: 50%;
    }

    .closeMC {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .closeMC:hover,
    .closeMC:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
@endsection