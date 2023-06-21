@extends('layouts.app')

@section('content')
<div class="container" stlye="font-family:arial">
  <div class="row">
    <div class="col-md-3 text-center">
      <div class="card mt-4 card shadow p-3 mb-3 bg-white rounded">
        @if ($diy->user)
          <img src="{{ asset('storage/' . $diy->user->avatar) }}" class="rounded-circle" style="width: 150px; height: 150px; margin-left:auto; margin-right:auto; margin-top:20px;">
          <h5 class="card-title mt-3"> <a style ="color:black;text-decoration:none"href="{{ route('publicProfile', $diy->user->id) }}">{{ $diy->user->name }}</a></h5>
          <p><strong></strong> {{ $diy->user->role }}</p>
        @endif
      </div>

      <div class="card mt-4 card shadow p-3 mb-5 bg-white rounded">
        <div class="card-header bg-white">
          <h5 class="card-title">Other DIYs</h5>
        </div>
        <div class="card-body">
          <ul class="list-group">
            @php
              $counter = 0;
            @endphp
            @foreach($otherDiys as $otherDiy)
              @if($counter < 10)
                <a href="{{ route('diys.show', $otherDiy->id) }}" class="list-group-item list-group-item-action">
                  <h5 class="card-title">{{ $otherDiy->title }}</h5>
                </a>
              @endif
              @php
                $counter++;
              @endphp
            @endforeach
          </ul>
        </div>
      </div>
    </div>

    <div class="col-md-9">
      <div class="card mt-4 shadow p-3 mb-4 bg-white rounded">
        <div class="card-header bg-white">
          <div class="functions" style="background-color:transparent;">
            <div class="d-flex justify-content-end">
              <div class="btn-group">
                @if ($diy->user_id === Auth::user()->id)
                  <button style="border-color:transparent; background-color:transparent"onclick="openEditModal()"><i class="fa-solid fa-pen-to-square"></i></button>
                  <form id="deleteDiyForm" action="{{ route('diys.destroy', $diy->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="margin-left:5px; border-color:transparent; background-color:transparent "><i class="fas fa-trash-alt"></i></button>
                  </form>
                @endif
              </div>
                @if (Auth::check())
                  @if (Auth::user()->favoriteDiys->contains($diy))
                    <form action="{{ route('diys.removeFromFavorites', $diy) }}" method="POST">
                      @csrf
                      @method('DELETE')
                        <button type="submit" style="border-color:transparent; background-color:transparent"><i class="fa-solid fa-star"></i></button>
                    </form>
                  @else
                    <form action="{{ route('diys.addToFavorites', $diy) }}" method="POST">
                     @csrf
                        <button type="submit" style="border-color:transparent; background-color:transparent"><i class="fa-regular fa-star"></i></button>
                    </form>
                  @endif 
                @endif
            </div>
          </div>
        </div>
        <div class="card-body">
          <h5 class="card-title"><b>{{ $diy->title }}</b></h5>
          <p class="card-text">{!! $diy->description !!}</p>
        </div>
      </div>

      @foreach($diy->comments as $index => $comment)
        @if ($index < 5)
          <div class="card mt-3 shadow p-1 bg-white rounded">
            <div class="card-body d-flex justify-content-between">
              <div>
                <strong>{{ $comment->user->name }}</strong>
                  @if ($comment->user_id === $diy->user_id)
                    <span class="creator-tag"> Creator </span>
                  @endif
              </div>
              @if (auth()->user()->id === $comment->user_id)
                <form id="deleteCommentForm{{ $comment->id }}" action="{{ route('comments.destroy', $comment) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" style="margin-left:5px; border-color:transparent; background-color:transparent " data-comment-id="{{ $comment->id }}"><i class="fas fa-times"></i></button>
                </form>
              @endif
            </div>
            <div class="card-body">
              <p>{!! $comment->content !!}</p>
            </div>
          </div>
        @else
          <div class="card mt-3 shadow p-1 bg-white rounded" style="display: none;">
            <div class="card-body d-flex justify-content-between">
              <div>
                <strong>{{ $comment->user->name }}</strong>
                  @if ($comment->user_id === $diy->user_id)
                <span class="creator-tag"> Creator</span>
        @endif
              </div>
            </div>
            <div class="card-body">
              <p>{!! $comment->content !!}</p>
            </div>
          </div>
        @endif
        @if ($index === 4 && count($diy->comments) > 5)
          <button id="commentsLoadMoreBtn" class="btn btn-dark mt-3" onclick="loadMoreComments()">Load More</button>
        @endif
      @endforeach


      <div class="card mt-4 shadow p-1 mb-5 bg-white rounded">
        <div class="card-body">
          <h4>Add a Comment</h4>
            <form action="{{ route('comments.store') }}" method="POST" class="comment-form">
              @csrf
                <input type="hidden" name="diy_id" value="{{ $diy->id }}">
                <div class="form-group">
                  <textarea name="content" class="form-control" rows="3" placeholder="Write your comment" required></textarea>
                </div>
                <button type="submit" class="btn btn-dark mt-3" style="float:right">Submit</button>
            </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="container" style="font-family:Arial, Helvetica, sans-serif">
    <div id="EditModal" class="modalMC">
        <div class="modal-contentMC card shadow p-3 mb-5 bg-white">
                <div class="card card shadow p-1 mb-3 bg-white">
                    <div class="card-content p-2">
                        <h5 class="modal-title"><strong>Edit Diy</strong><span style="margin-top:-7px;"class="closeMC" onclick="closeEditModal()">&times;</span></h5>
                    </div>
                </div>
            <div class="card shadow p-3 mb-3 bg-white rounded">
              <div class="card-content">
                <form action="{{ route('diys.update', $diy) }}" method="POST">
                  @csrf
                  @method('PUT')
                    <div class="form-group">
                      <label for="title">Title</label>
                      <input type="text" name="title" id="title" class="form-control" value="{{ $diy->title }}">
                    </div>
                    <div class="form-group">
                      <label for="description">Description</label>
                      <textarea name="description" id="description" class="form-control">{{ $diy->description }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-dark mt-2" style="float:right;">Submit</button>
                </form>
              </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
      #pagination-buttons {
      margin-top: 10px;
      text-align: center;
    }

    #pagination-buttons button {
      margin: 0 5px;
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
</style>
@endsection

@section('scripts')
<script>
    function openEditModal() {
        document.getElementById("EditModal").style.display = "block";
    }

    function closeEditModal() {
        document.getElementById("EditModal").style.display = "none";
    }
</script>

<script>
    $(document).ready(function() {
      var currentPage = 0;
      var chunkSize = 5;
      var totalChunks = $(".comment-chunk").length;

      $("#previous-button").click(function() {
        if (currentPage > 0) {
          currentPage--;
          showComments();
        }
      });

      $("#next-button").click(function() {
        if (currentPage < totalChunks - 1) {
          currentPage++;
          showComments();
        }
      });

      function showComments() {
        $(".comment-chunk").hide();
        $(".comment-chunk").eq(currentPage).show();
      }

      showComments();
    });
  </script>

<script>
    $(document).ready(function() {
        $('form[action="{{ route('diys.update', $diy) }}"]').submit(function(e) {
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
                        title: 'DIY Updated',
                        text: 'The DIY has been updated successfully!',
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while updating the DIY.',
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('form.comment-form').submit(function(e) {
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
                        title: 'Comment Submitted',
                        text: 'Your comment has been submitted successfully!',
                    });
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while submitting your comment.',
                    });
                }
            });
        });
    });
</script>

<script>
  function loadMoreComments() {
    var hiddenComments = document.querySelectorAll('.card.mt-3.shadow.p-1.bg-white.rounded[style="display: none;"]');
    var visibleCount = 0;
    
    hiddenComments.forEach(function(comment, index) {
      if (visibleCount < 5) {
        comment.style.display = 'block';
        visibleCount++;
      }
    });
    
    if (visibleCount === hiddenComments.length) {
      document.getElementById('commentsLoadMoreBtn').style.display = 'none';
    }
  }
</script>

@endsection