@extends('layouts.app')

@section('content')
    <div class="container" style="margin-top:9%;font-family:arial">
        <div class="row">
            <h4><b>Select A Category You Would Like To Work On.</b></h4>
        </div>
        <div class="row">
            <div class="col-sm mt-3 ">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <div class="card-content">
                        <h5 class="mt-3 ms-3"><b>Tickets</b></h5>
                        <p class="ms-3">
                            Admin managing and resolving 
                            tickets efficiently to provide excellent customer support
                            and ensure satisfaction
                        </p>
                        <a href="{{ route('admin.tickets.index') }}" class="btn btn-dark btn-sm ms-3 mb-3" style="margin-top:-10px;">Tickets</a>
                    </div>
                </div>
            </div>
            <div class="col-sm mt-3">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <div class="card-content">
                        <h5 class="mt-3 ms-3"><b>Users</b></h5>
                        <p class="ms-3">
                            Admin managing and resolving 
                            tickets efficiently to provide excellent customer support
                            and ensure satisfaction
                        </p>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-dark btn-sm ms-3 mb-3" style="margin-top:-10px;">Users</a>
                    </div>
                </div>
            </div>            
            <div class="col-sm mt-3">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <div class="card-content">
                        <h5 class="mt-3 ms-3"><b>Hires</b></h5>
                        <p class="ms-3">
                            Admin managing and resolving 
                            tickets efficiently to provide excellent customer support
                            and ensure satisfaction
                        </p>
                        <a href="{{ route('admin.hires.index') }}" class="btn btn-dark btn-sm ms-3 mb-3" style="margin-top:-10px;">Hires</a>
                    </div>
                </div>
            </div>            
            <div class="col-sm mt-3">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <div class="card-content">
                        <h5 class="mt-3 ms-3"><b>DIY</b></h5>
                        <p class="ms-3">
                            Admin managing and resolving 
                            tickets efficiently to provide excellent customer support
                            and ensure satisfaction
                        </p>
                        <a href="{{ route('admin.diy.index') }}" class="btn btn-dark btn-sm ms-3 mb-3" style="margin-top:-10px;">DIY's</a>
                    </div>
                </div>
            </div>            
            <div class="col-sm mt-3 mb-5">
                <div class="card shadow p-3 mb-5 bg-white rounded">
                    <div class="card-content">
                        <h5 class="mt-3 ms-3"><b>Payouts</b></h5>
                        <p class="ms-3">
                            Admin managing and resolving 
                            tickets efficiently to provide excellent customer support
                            and ensure satisfaction
                        </p>
                        <a href="{{ route('admin.payout.index') }}" class="btn btn-dark btn-sm ms-3 mb-3" style="margin-top:-10px;">Payout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

