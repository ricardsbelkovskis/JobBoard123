@extends('layouts.app')

@section('content')
<div class="container" style="font-family:Arial, Helvetica, sans-serif">
  <div class="row">
    <div class="col-md-3">
      <div class="card shadow mt-4 bg-white rounded">
        <div class="card-content text-center">
          <img src="{{ asset('storage/' . $user->avatar) }}" class="rounded-circle mt-3 mb-3" width="130" height="130">
          <p><strong>{{$user->name}}</strong></p>
        </div>
      </div>
      <div class="card mt-3 shadow bg-white rounded">
        <div class="card-content text-center">
          <ul class="list-group">
            <a href="#About" class="list-group-item list-group-item-action">About</a>
            <a href="#Diys" class="list-group-item list-group-item-action">Diys</a>
            <a href="#Favorites" class="list-group-item list-group-item-action">Favorites</a>
            <a href="#Reviews" class="list-group-item list-group-item-action">Reviews</a>
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-9">
      <div class="card mt-4 shadow bg-white rounded">
        <div id="About" class="card-header bg-white">
          <h5><strong>About "{{$user->name}}"</strong></h5>
        </div>
        <div class="card-content ms-3 mt-3">
            <p>{{$user->description}}</p>
        </div>
      </div>
      <div class="card mt-4 shadow bg-white rounded">
        <div id="Diys" class="card-header bg-white">
            <h5><strong>Diys</strong></h5>
        </div>
        <div class="card-content bg-white">
          <ul id="diysList" class="list-group">
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
              <button id="diysLoadMoreBtn" class="btn btn-dark" style="float:right;" onclick="loadMoreDiys()">Load More</button>
            </div>
          @endif
      </div>
      <div class="card mt-4 shadow bg-white rounded">
        <div id="Favorites" class="card-header bg-white">
          <h5><strong>Favorites</strong></h5>
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
        </div>
        <div class="card-footer bg-white">
          @if (count($user->favorites) > 5)
            <button id="favoritesLoadMoreBtn" class="btn btn-dark" style="float:right;" onclick="loadMoreFavorites()">Load More</button>
          @endif
        </div>
      </div>
      <div class="card mt-4 shadow bg-white rounded">
        <div id="Reviews" class="card-header bg-white">
          <h5><strong>Reviews</strong></h5>
        </div>
        <div class="card-content">
          <ul id="reviewsList" class="list-group">
            @php
              $reviewCount = 0;
            @endphp
            @foreach($reviews as $index => $review)
             @if($review->hire->user_id === $user->id)
              <li class="list-group-item list-group-item-action" @if($index >= 5) style="display: none;" @endif>
                <a href="{{ route('publicProfile', $review->user->id) }}" style="text-decoration: none; color: inherit;">
                  <img src="{{ asset('storage/' . $review->user->avatar) }}" alt="{{ $review->user->name }}'s avatar" class="img-fluid rounded-circle mr-3" style="width:40px; height:40px;">
                  <div>
                    <p class="mb-0">{{ $review->user->name }}</p>
                    <p class="mb-0">{{ $review->content }}</p>
                  </div>
                </a>
              </li>
              @php
                $reviewCount++;
              @endphp
             @endif
            @endforeach
          </ul>
        </div>
        <div class="card-footer bg-white">
          @if($reviewCount > 5)
            <button id="reviewsLoadMoreBtn" class="btn btn-dark" style="float:right" onclick="loadMoreReviews()">Load More</button>
          @endif
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
.modal {
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
.modal-content {
  background-color: #fefefe;
  margin: 10% auto;
  padding: 20px;
  border: 1px solid #888;
  width: 50%;
}
.close {
  color: #aaa;
  float: right;
  font-size: 20px;
  font-weight: bold;
}
.close:hover,
.close:focus {
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
  function loadMoreDiys() {
    var hiddenPosts = document.querySelectorAll('#diysList a[style="display: none;"]');
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
    var hiddenPosts = document.querySelectorAll('#favoritesList a[style="display: none;"]');
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

<script>
  function loadMoreReviews() {
    var hiddenReviews = document.querySelectorAll('#reviewsList li[style="display: none;"]');
    var visibleCount = 0;

    hiddenReviews.forEach(function(review, index) {
      if (visibleCount < 5) {
        review.style.display = 'list-item';
        visibleCount++;
      }
    });

    if (visibleCount === hiddenReviews.length) {
      document.getElementById('reviewsLoadMoreBtn').style.display = 'none';
    }
  }
</script>

@endsection