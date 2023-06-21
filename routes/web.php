<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\HireController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// User profile
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware('auth')
    ->name('home');

Route::get('/profile', [App\Http\Controllers\HomeController::class, 'index'])
    ->middleware('auth')
    ->name('profile');

Route::post('/profile/update', [App\Http\Controllers\HomeController::class, 'update'])
    ->middleware('auth')
    ->name('profile.update');

// DIY CONTROLLER

Route::get('/diy', [App\Http\Controllers\DiyController::class, 'index'])
    ->middleware('auth')
    ->name('diy');

Route::post('/diy', [App\Http\Controllers\DiyController::class, 'submit'])
    ->middleware('auth')
    ->name('diys.submit');

Route::get('/diys/{diy}', [App\Http\Controllers\DiyController::class, 'show'])
    ->middleware('auth')
    ->name('diys.show');

Route::put('/diys/{diy}', [App\Http\Controllers\DiyController::class, 'update'])
    ->middleware('auth')
    ->name('diys.update');

Route::delete('/diys/{diy}', [App\Http\Controllers\DiyController::class, 'delete'])
    ->middleware('auth')
    ->name('diys.destroy');

// Favourits

Route::post('/diys/{diy}/favorites', [App\Http\Controllers\DiyController::class, 'addToFavorites'])
    ->middleware('auth')
    ->name('diys.addToFavorites');

Route::delete('/diys/{diy}/favorites', [App\Http\Controllers\DiyController::class, 'removeFromFavorites'])
    ->middleware('auth')
    ->name('diys.removeFromFavorites');

// COMMENT CONTROLLER

Route::post('/comments', [App\Http\Controllers\CommentController::class, 'store'])
    ->middleware('auth')
    ->name('comments.store');

Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])
    ->middleware('auth')
    ->name('comments.destroy');

// HIRE CONTROLLER

Route::get('/hire', [App\Http\Controllers\HireController::class, 'index'])
    ->middleware('auth')
    ->name('hire.index');

Route::get('/hire/make-listing', [App\Http\Controllers\HireController::class, 'createForm'])
    ->middleware('auth')
    ->name('hire.create');

Route::post('hire/make-listing', [App\Http\Controllers\HireController::class, 'store'])
    ->middleware('auth')
    ->name('hire.store');

Route::get('/hires/{hire}', [App\Http\Controllers\HireController::class, 'show'])
    ->middleware('auth')
    ->name('hire.show');

Route::get('/hire/{hire}/show-link', [App\Http\Controllers\HireController::class, 'showLink'])
    ->middleware('auth')
    ->name('hire.showLink');

Route::get('/hire/{hire}/payment', [App\Http\Controllers\HireController::class, 'payment'])
    ->middleware('auth')
    ->name('hire.payment');


Route::get('/hire/{hire}/success', [App\Http\Controllers\HireController::class, 'success'])
    ->middleware('auth')
    ->name('hire.success');

Route::get('/invoice/{purchase}', [App\Http\Controllers\HomeController::class, 'showInvoice'])
    ->middleware('auth')
    ->name('invoice.show');

Route::put('/invoice/{purchase}', [App\Http\Controllers\HomeController::class, 'StatusUpdate'])
    ->middleware('auth')
    ->name('status.update');

Route::get('/hire/{purchase}', [App\Http\Controllers\HomeController::class, 'showHire'])
    ->middleware('auth')
    ->name('invoice.hire.show');

Route::post('/reviews', [App\Http\Controllers\ReviewController::class, 'ReviewStore'])
    ->middleware('auth')
    ->name('reviews.store');

Route::post('/messages', [App\Http\Controllers\MessageController::class, 'store'])
    ->middleware('auth')
    ->name('messages.store');

Route::get('/public-profile/{userId}', [App\Http\Controllers\PublicProfileController::class, 'index'])
    ->middleware('auth')
    ->name('publicProfile');

Route::delete('/hire/{hire}', [App\Http\Controllers\HireController::class, 'delete'])
    ->middleware('auth')
    ->name('hire.delete');


Route::get('/cashout', [App\Http\Controllers\CashoutController::class, 'index'])
    ->middleware('auth');

Route::post('/cashout', [App\Http\Controllers\CashoutController::class, 'store'])
    ->middleware('auth')
    ->name('cashout.store');

Route::get('/cashout', [App\Http\Controllers\CashoutController::class, 'create'])
    ->middleware('auth')
    ->name('cashout.create');

Route::delete('/cashout/{id}', [App\Http\Controllers\CashoutController::class, 'delete'])
    ->middleware('auth')
    ->name('cashout.delete');

// Admin Routes

Route::get('/admin/dashboard', [App\Http\Controllers\AdminDashboardController::class, 'dashboard'])
    ->middleware('admin');

Route::get('/admin/users', [App\Http\Controllers\AdminUsersDashboardController::class, 'users_dashboard'])
    ->middleware('admin')
    ->name('admin.users.index');

Route::get('/admin/payout', [App\Http\Controllers\AdminPayoutDashboardController::class, 'dashboard'])
    ->middleware('admin')
    ->name('admin.payout.index');

Route::post('/cashouts/{cashout}/accept', [App\Http\Controllers\AdminPayoutDashboardController::class, 'accept'])
    ->middleware('admin')
    ->name('admin.cashouts.accept');

Route::post('/cashouts/{cashout}/reject', [App\Http\Controllers\AdminPayoutDashboardController::class, 'reject'])
    ->middleware('admin')
    ->name('admin.cashouts.reject');

Route::get('/admin/users/create', [App\Http\Controllers\AdminUsersDashboardController::class, 'createUser'])
    ->middleware('admin');

Route::post('/admin/users', [App\Http\Controllers\AdminUsersDashboardController::class, 'storeUser'])
    ->middleware('admin')
    ->name('admin.users.store');

Route::delete('/admin/users/{user}', [App\Http\Controllers\AdminUsersDashboardController::class, 'destroyUser'])
    ->middleware('admin')
    ->name('admin.users.destroy');

Route::get('/admin/users/{user}/edit', [App\Http\Controllers\AdminUsersDashboardController::class, 'editUser'])
    ->middleware('admin')
    ->name('admin.users.edit');

Route::put('/admin/users/{user}', [App\Http\Controllers\AdminUsersDashboardController::class, 'updateUser'])
    ->middleware('admin')
    ->name('admin.users.update');

Route::get('/admin/hires', [App\Http\Controllers\AdminHireDashnoardController::class, 'hire_dashboard'])
    ->middleware('admin')
    ->name('admin.hires.index');

Route::delete('/admin/hires/{hire}', [App\Http\Controllers\AdminHireDashnoardController::class, 'deleteHire'])
    ->middleware('admin')
    ->name('admin.hires.delete');

Route::get('/admin/diy', [App\Http\Controllers\AdminDiyDashnoardController::class, 'diy_dashboard'])
    ->middleware('admin')
    ->name('admin.diy.index');

    Route::delete('/admin/diy/{diy}', [App\Http\Controllers\AdminDiyDashnoardController::class, 'deleteDiy'])
    ->middleware('admin')
    ->name('admin.diy.delete');

Route::get('/admin/diy/{diy}/edit', [App\Http\Controllers\AdminDiyDashnoardController::class, 'editDiy'])
    ->middleware('admin')
    ->name('admin.diy.edit');

Route::put('/admin/diy/{diy}', [App\Http\Controllers\AdminDiyDashnoardController::class, 'updateDiy'])
    ->middleware('admin')
    ->name('admin.diy.update');

// Ticket controller

Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'index'])
    ->middleware('auth')
    ->name('tickets.index');

Route::get('/tickets/create', [App\Http\Controllers\TicketController::class, 'create'])
    ->middleware('auth')
    ->name('tickets.create');

Route::post('/tickets', [App\Http\Controllers\TicketController::class, 'store'])
    ->middleware('auth')
    ->name('tickets.store');

Route::get('/admin/tickets', [App\Http\Controllers\TicketController::class, 'admin_index'])
    ->middleware('admin')
    ->name('admin.tickets.index');

Route::get('/admin/tickets/{ticket}', [App\Http\Controllers\TicketController::class, 'show'])
    ->middleware('admin')
    ->name('admin.tickets.show');

Route::put('/admin/tickets/{ticket}', [App\Http\Controllers\TicketController::class, 'update_status'])
    ->middleware('admin')
    ->name('admin.ticket.status.update');

Route::get('/tickets/success/{ticket}', [App\Http\Controllers\TicketController::class, 'success'])
    ->name('tickets.success');


