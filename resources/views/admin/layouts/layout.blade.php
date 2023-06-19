<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="card shadow bg-white rounded">
            <div class="card-content">
                <a href="{{ route('admin.tickets.index') }}" class="btn btn-dark ms-2 mt-2 mb-2">Tickets</a>
                <a href="{{ route('admin.users.index') }}" class="btn btn-dark ms-2 mt-2 mb-2">Users</a>
                <a href="{{ route('admin.hires.index') }}" class="btn btn-dark ms-2 mt-2 mb-2">Hires</a>
                <a href="{{ route('admin.diy.index') }}" class="btn btn-dark ms-2 mt-2 mb-2">DIY</a>
                <a href="{{ route('admin.payout.index') }}" class="btn btn-dark ms-2 mt-2 mb-2">Payouts</a>
            </div>
        </div>
    </div>
</body>
</html>