<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Include datatable css -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <!-- Alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Stripe -->
    <script src="https://js.stripe.com/v3/"></script>
    <!-- Include TinyMCE JavaScript -->
    <script src="https://cdn.tiny.cloud/1/2mhv7n95cs8rylg49m6csc7xi8dywdb23dncmwq0qmhdrxsq/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="path/to/your/javascript/file.js"></script>
    <script src="{{ asset('resources/js/index.js') }}"></script>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @yield('scripts')
    @yield('styles')
</head>

<body>
<div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <strong>JOB BOARD</strong>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a href="/diy" class="nav-link">LEARN</a>
                        </li>
                        <li class="nav-item">
                            <a href="/hire" class="nav-link">HIRE</a>
                        </li>
                    </ul>

                    <ul class="navbar-nav ms-auto">
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item">
                                <a style="margin-top:8px; padding-right:10px;" type="button" onclick="openPostModal()"><i class="fa-solid fa-plus fa-sm"></i></a>
                            </li>

                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="/home">Profile</a>
                                    <a class="dropdown-item" href="/cashout">Cashout</a>
                                    @if(Auth::user()->admin_role === 'admin')
                                        <a class="dropdown-item" href="/admin/dashboard">Admin-Dashboard</a>
                                    @endif
                                    <a class="dropdown-item" href="/tickets">Support</a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        
        @if(session('success'))
        <div id="success-alert" class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
        </div>
        @endif

        @if(session('error'))
        <div id="danger-alert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Error!</strong> {{ session('error') }}
        </div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <div id="postModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closePostModal()">&times;</span>
                <a class="btn btn-dark" style="width:20%;" onclick="showTab('createListing')">Create a Listing</a>
                <a class="btn btn-dark mt-1 mb-1" style="width:20%" onclick="showTab('createDIYListing')">Create a DIY Listing</a>
            <div class="tab-content">
                <div id="createListing" class="tab-pane active">
                    <div class="card shadow bg-white rounded">
                        <div class="card-content p2">
                            <h5 class="ms-2 mt-2">Create a Listing</h5>
                                <form action="{{ route('hire.create') }}" class="p-2" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea id="description" class="form-control" name="description" rows="5" placeholder="Enter the description" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter the price" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="time_to_finish" class="form-label">Time to Finish</label>
                                        <input type="text" class="form-control" id="time_to_finish" name="time_to_finish" placeholder="Enter the estimated time to finish" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="photos" class="form-label">Photos</label>
                                            <div id="photo-container">
                                                <input type="file" class="form-control" name="photos[]" required>
                                            </div>
                                        <button type="button" id="add-photo-btn" class="btn btn-secondary mt-2">+</button>
                                    </div>
                                    <button style="float:right;" type="submit" class="btn btn-dark mb-2">Submit</button>
                                </form>
                        </div>
                    </div>
                </div>
                <div id="createDIYListing" class="tab-pane">
                    <div class="card">
                        <div class="card-content p-2">
                            <h5>Create a DIY Listing</h5>
                            <form action="{{ route('diys.submit') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title</label>
                                        <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title">
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea id="description_hire" name="description" rows="5" class="form-control" placeholder="Enter the description"></textarea>
                                    </div>

                                    <button style="float:right;" type="submit" class="btn btn-dark">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openPostModal() {
            document.getElementById("postModal").style.display = "block";
        }

        function closePostModal() {
            document.getElementById("postModal").style.display = "none";
        }

        function showTab(tabName) {
            var i, tabContent;

            tabContent = document.getElementsByClassName("tab-pane");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }

            document.getElementById(tabName).style.display = "block";
        }
    </script>

    <script>
        setTimeout(function() {
            $('#success-alert').alert('close');
        }, 2000);
    </script>

    <script>
$(document).ready(function() {
  $('form[action="{{ route('hire.create') }}"]').submit(function(e) {
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

        form[0].reset();

        Swal.fire({
          icon: 'success',
          title: 'Listing Created',
          text: 'The listing has been created successfully!',
        });

        var newRow = '<tr onclick="window.location.href=\'' + response.route + '\';" style="cursor: pointer;">';
        newRow += '<td>' + response.hire.title + '</td>';
        newRow += '<td>' + response.hire.user.name + '</td>';
        newRow += '<td class="price-column">' + response.hire.price + '$</td>';
        newRow += '<td><a href="' + response.paymentRoute + '" class="checkout-icon btn btn-success">Hire</a></td>';
        newRow += '</tr>';

        $('#HiresTable2 tbody').append(newRow);
      },
      error: function(xhr, status, error) {
        console.log(xhr.responseText);

        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'An error occurred while creating the listing.',
        });
      }
    });
  });
});

</script>

<script>
    document.getElementById('add-photo-btn').addEventListener('click', function() {
        var container = document.getElementById('photo-container');
        var input = document.createElement('input');
        input.type = 'file';
        input.className = 'form-control mt-2';
        input.name = 'photos[]';
        input.required = true;
        container.appendChild(input);
    });
</script>


<script>
$(document).ready(function() {
    $('form[action="{{ route('diys.submit') }}"]').submit(function(e) {
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

                form[0].reset();

                var diyTable = $('#diyTable tbody');
                var newRow = $('<tr onclick="window.location.href=\'' + response.route + '\';" style="cursor: pointer;">' +
                    '<td>' + response.diy.title + '</td>' +
                    '<td>' + response.diy.user.name + '</td>' +
                    '<td>' + response.diy.created_at + '</td>' +
                    '</tr>');
                diyTable.append(newRow);

                Swal.fire({
                    icon: 'success',
                    title: 'DIY Listing Created',
                    text: 'The DIY listing has been created successfully!',
                });
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred while creating the DIY listing.',
                });
            }
        });
    });
});

</script>

<style>
    .block {
        padding-top: 250px;
        padding-bottom: 230px;
    }

    .header-block h1 {
        font-weight: bold;
        font-family: arial;
    }
    </style>

    <style>
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
        margin: 2% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 70%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .nav-tabs {
        margin-bottom: 20px;
    }

    .nav-link {
        cursor: pointer;
    }

    .tab-pane {
        display: none;
    }
    </style>
</body>

</html>





<style>
    .block {
        padding-top: 250px;
        padding-bottom: 230px;
    }

    .header-block h1 {
        font-weight: bold;
        font-family: arial;
    }
    </style>

    <style>
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
        margin: 5% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 70%;
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .nav-tabs {
        margin-bottom: 20px;
    }

    .nav-link {
        cursor: pointer;
    }

    .tab-pane {
        display: none;
    }
    </style>