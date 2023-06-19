@extends('layouts.app')

@section('content')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
  <div class="row">
    <div class="col-md-5">
      <h5 class="p-1" style="color:gray">Why tantalize yourself, let someone help you?</h5>
    </div>
  </div>
</div>
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
  <div class="row">
      <div class="card mt-4 shadow p-3 mb-5 bg-white rounded">
        <div class="card-content">
            <table id="HiresTable2" class="table table-hover table-bordered mt-2">
                <thead>
                  
                    <tr>
                        <th>Title</th>
                        <th style="width:100px">User</th>
                        <th style="width:100px;">Price</th>
                        <th style="width:10px;">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($hires as $hire)
                <tr onclick="window.location.href='{{ route('hire.show', $hire->id)}}';" style="cursor: pointer;">
                    <td>{{ $hire->title }}</td>
                    <td>{{ $hire->user->name }}</td>
                    <td class="price-column">{{ $hire->price }}$</td>
                    <td>
                      <a href="{{ route('hire.payment', ['hire' => $hire->id]) }}" class="checkout-icon btn btn-success">Hire</a>
                    </td>
                  </tr>
                @endforeach

                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function () {
  var table = $('#HiresTable2').DataTable({
    "paging": true,
    "searching": true,
    "info": false
  });
});
</script>
@endsection
