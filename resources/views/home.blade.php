@extends('layouts.app')
@extends('layouts.js')

@section('content')

@section('content')
<div class="container" style="font-family:arial">
  <div class="row">
    <div class="col-md-3">
      <div class="card shadow bg-white rounded">
        <div class="card-content text-center">
        <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle mt-3 mb-3" width="130" height="130">
          <p><strong id="name">{{ $user->name }}</strong></p>
        </div>
      </div>
      <div class="card mt-3 card shadow bg-white rounded">
        <div class="card-content text-center">
          <ul class="list-group">
            <a href="#" onclick="openSummaryModal()" class="list-group-item list-group-item-action">Edit Profile</a>
            <a href="#Statistics" class="list-group-item list-group-item-action">Statistics</a>
            <a href="#Posts" class="list-group-item list-group-item-action">Posts</a>
            <a href="#Favorits" class="list-group-item list-group-item-action">Favorites</a>
            <a href="#Reviews" class="list-group-item list-group-item-action">Reviews</a>
            <a href="#Purchase" class="list-group-item list-group-item-action">Purchases</a>
            <a href="#YourHired" class="list-group-item list-group-item-action">Hired</a>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-md-9">
      <div class="card shadow bg-white rounded">
        <div id="Statistics" class="card-header bg-white">
          <h5>Statistics</h5>
        </div>
        <div class="card-content">
          <div class="container mt-3 mb-3">
            <div class="row">
              <div class="col-md-4">
                <div class="card card-stats mb-4 mb-xl-0 shadow bg-white rounded">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Posts</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $postCount }}</span>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm ">
                      <span class="text-success mr-2">
                        <i class="fas fa-arrow-up"></i> {{ $growthPercentage }}%
                      </span>
                      <span class="text-nowrap">Since last month</span>
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card card-stats mb-4 mb-xl-0 shadow bg-white rounded">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Favorites</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $favoritesCount }}</span>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      Saved in your Favorites
                    </p>
                  </div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="card card-stats mb-4 mb-xl-0 shadow bg-white rounded">
                  <div class="card-body">
                    <div class="row">
                      <div class="col">
                        <h5 class="card-title text-uppercase text-muted mb-0">Listings</h5>
                        <span class="h2 font-weight-bold mb-0">{{ $listingCount }}</span>
                      </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                      Total listings
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


<div class="card mt-4 shadow bg-white rounded">
  <div id="Posts"class="card-header bg-white">
    <h5>Diys</h5>
  </div>
  <div class="card-content">
    <ul id="diyList" class="list-group">
      @if ($user->diys)
        @foreach ($user->diys as $index => $diy)
          @if ($index < 5)
            <a href="{{ route('diys.show', $diy->id) }}" class="list-group-item list-group-item-action">{{ $diy->title }}</a>
          @else
            <a href="{{ route('diys.show', $diy->id) }}" class="list-group-item list-group-item-action" style="display: none;">{{ $diy->title }}</a>
          @endif
        @endforeach
      @else
        <p>No diys found.</p>
      @endif
    </ul>
  </div>
    @if (count($user->diys) > 5)
      <div class="card-footer bg-white">
        <button id="diysLoadMoreBtn" class="btn btn-dark mt-1" style="float:right;" onclick="loadMoreDiys()">Load More</button>
      </div>
    @endif
</div>

<div class="card mt-4 shadow bg-white rounded">
  <div id="Reviews" class="card-header bg-white">
    <h5>Reviews</h5>
  </div>
  <div class="card-content">
    <table id="MyReviews" class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th scope="col">Reviewer</th>
          <th scope="col">Review</th>
        </tr>
      </thead>
      <tbody>
        @foreach($reviews as $index => $review)
          @if($review->hire->user_id === auth()->id())
            <tr>
              <td>{{$review->user->name}}</td>
              <td>{{$review->content}}</td>
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>


<div class="card mt-4 shadow bg-white rounded">
  <div id="Favorits" class="card-header bg-white">
    <h5>Favorites</h5>
  </div>
  <div class="card-content">
    <ul id="favoritesList" class="list-group">
      @foreach ($user->favorites as $index => $favorite)
        @if ($index < 5)
          <a href="{{ route('diys.show', $favorite->id) }}" class="list-group-item list-group-item-action">{{ $favorite->title }}</a>
        @else
          <a href="{{ route('diys.show', $favorite->id) }}" class="list-group-item list-group-item-action" style="display: none;">{{ $favorite->title }}</a>
        @endif
      @endforeach
    </ul>
    @if (count($user->favorites) > 5)
      <button id="favoritesLoadMoreBtn" class="btn btn-dark mt-2 mb-2" style="margin-left:89%" onclick="loadMoreFavorites()">Load More</button>
    @endif
  </div>
</div>


<div id="Purchase" class="card mt-4 shadow bg-white rounded">
  <div class="card-header bg-white">
    <h5>Purchases</h5>
  </div>
  <div class="card-content">
    <table id="MyPurchases" class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th scope="col">Title</th>
          <th scope="col">ListedBY</th>
          <th scope="col">Date</th>
          <th scope="col" style="width:20px;">Function</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($user->purchases as $index => $purchase)
          @if ($purchase->user_id === $user->id)
            <tr>
              <td>{{$purchase->hire->title}}</td>
              <td>{{ $purchase->hire->user->name }}</td>
              <td>{{$purchase->created_at }}</td>
              <td><a href="{{ route('invoice.show', ['purchase' => $purchase]) }}" class="btn btn-dark">View</a></td>
            </tr>
          @endif
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div id="" class="card mt-4 shadow bg-white rounded">
  <div class="card-header bg-white">
    <h5>Hired For</h5>
  </div>
  <div class="card-content">
  <table id="YourHired" class="table table-striped table-hover table-bordered">
      <thead>
        <tr>
          <th scope="col">Title</th>
          <th scope="col">Price</th>
          <th scope="col">Hired By</th>
          <th scope="col">Date</th>
          <th scope="col" style="width:20px;">Function</th>
        </tr>
      </thead>
      <tbody>
      @foreach ($hiredForPurchases as $index => $purchase)
            <tr>
              <td>{{$purchase->hire->title}}</td>
              <td>{{ $purchase->hire->price }}$</td>
              <td>{{ $purchase->user->name }}</td>
              <td>{{ $purchase->created_at}}</td>
              <td><a href="{{ route('invoice.hire.show', ['purchase' => $purchase]) }}" class="btn btn-dark">View</a></td>
            </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div id="EditProfile" class="modalMC">
        <div class="modal-contentMC card shadow p-3 mb-5 bg-white">
            <div class="card card shadow p-1 mb-3 bg-white">
              <div class="card-content p-2">
                <h5 class="modal-title"><strong>Edit Profile</strong><span style="margin-top:-7px;" class="close">&times;</span></h5>
              </div>
            </div>
            <div class="card shadow p-3 mb-3 bg-white rounded">
              <div class="card-content">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label for="name">Username</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                  </div>

                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                  </div>

                  <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password">
                  </div>

                  <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                  </div>

                  <div class="form-group">
                    <label for="avatar">Avatar</label>
                    <input type="file" class="form-control" id="avatar" name="avatar">
                  </div>

                  <div class="form-group">
                    <label for="description">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $user->description) }}</textarea>
                  </div>

                  <button type="submit" class="btn btn-dark mt-2" style="float:right;">Save Changes</button>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
.saturs {
    margin-top:50px;
}
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
        margin: 10% auto;
        padding: 20px;
        width: 40%;
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

.prof-btn button{
    margin-top:5px;
    margin-left:5px;
    margin-right:5px;
}
</style>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#MyReviews').DataTable({
            "paging": true,
            "searching": true,
            "info": false,
            "lengthMenu": [5, 10, 25, 50],
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#MyPurchases').DataTable({
            "paging": true,
            "searching": true,
            "info": false,
            "lengthMenu": [5, 10, 25, 50],
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#YourHired').DataTable({
            "paging": true,
            "searching": true,
            "info": false,
            "lengthMenu": [5, 10, 25, 50],
        });
    });
</script>

<script>
function openSummaryModal() {
  var modal = document.getElementById("EditProfile");
  var closeButton = modal.querySelector(".close");
  modal.style.display = "block";
  closeButton.onclick = function() {
    modal.style.display = "none";
  }
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
}
</script>

<script>
$(document).ready(function() {
    $('form[action="{{ route('profile.update') }}"]').submit(function(e) {
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

                // Update the form elements
                $('#name').val(response.name);

                Swal.fire({
                    icon: 'success',
                    title: 'Profile Updated',
                    text: 'Your profile has been updated successfully!',
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while updating the profile.',
                });
            }
        });
    });
});
</script>

<script>
  function loadMoreDiys() {
    var hiddenPosts = document.querySelectorAll('#diyList .list-group-item[style="display: none;"]');
    var visibleCount = 0;
    
    hiddenPosts.forEach(function(post, index) {
      if (visibleCount < 5) {
        post.style.display = 'block';
        visibleCount++;
      }
    });
    
    if (visibleCount === hiddenPosts.length) {
      document.getElementById('diysLoadMoreBtn').style.display = 'none';
    }
  }
</script>

<script>
  function loadMoreFavorites() {
    var hiddenPosts = document.querySelectorAll('#favoritesList .list-group-item[style="display: none;"]');
    var visibleCount = 0;

    hiddenPosts.forEach(function(post, index) {
      if (visibleCount < 5) {
        post.style.display = 'block';
        visibleCount++;
      }
    });

    if (visibleCount === hiddenPosts.length) {
      document.getElementById('favoritesLoadMoreBtn').style.display = 'none';
    }
  }
</script>
@endsection