<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OauthController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\WorkgroupsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\NoticeInvoiceCreated;
use App\Models\User;

Auth::routes();

Route::middleware(['auth'])->group(function () {
  Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
  Route::get('/home', [HomeController::class, 'index'])->name('home');
  Route::get('callback/{order:uuid}', [OrderController::class, 'callback'])->name('config');

  Route::post('add-to-cart/{product}', [ShoppingCartController::class, 'store']);
  Route::get('checkout', [ShoppingCartController::class, 'index'])->name('checkout');

  Route::get('download/{order}', [InvoiceController::class, 'download'])->name('invoice.download');
  Route::resource('invoices', InvoiceController::class)->only(['index', 'store']);
  Route::resource('products', ProductController::class);
  Route::resource('orders', OrderController::class)->only('store');

  //BOOTCAMP
  Route::resource('roles', RolesController::class);
  Route::resource('users', UsersController::class);
  Route::resource('workgroups', WorkgroupsController::class);

});

Route::get('redirect/github', [OauthController::class, 'redirectGithub']);
Route::get('auth/callback', [OauthController::class, 'callback']);

Route::post('webhook', function () {
  return response()->json(['status' => 'ok']);
});;

Route::get('send-mail/{user}', function (User $user) {
  Mail::to($user)->send(new NoticeInvoiceCreated($user));
  return 'Mail sent';
});


Route::post('webhook', function () {

  $request = request();

  $request->file('image')->store('profile_pictures', 'avatars');

  return response()->json([
    'status' => [
      'code' => 'ok'
    ]
  ]);
});;
