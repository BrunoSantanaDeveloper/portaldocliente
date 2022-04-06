<?php

use App\Http\Controllers\Orders;
use App\Http\Controllers\Winthor\ClientWinthorController;
use App\Http\Controllers\Winthor\ReceivementWinthorController;
use App\Mail\SendMailOrders;
use Illuminate\Support\Facades\Route;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';


// Winthor API
Route::get('/clients', [ClientWinthorController::class, 'getClients'])->name('clients.getclients');
Route::post('/client-register-validate', [ClientWinthorController::class, 'registerValidate'])->name('clients.client-register-validate');
Route::get('/ar/{page}', [ReceivementWinthorController::class, 'getReceivement'])->name('receivement.get-receivement');
Route::get('/sales-order/{nota}', [ReceivementWinthorController::class, 'getItemOrder'])->name('receivement.get-item-order');
Route::get('/approve_order/{nota}/{order}', [Orders::class, 'aproveOrder'])->name('orders.aprove-order');
Route::post('/reject_order', [Orders::class, 'rejectOrder'])->name('orders.reject-order');

Route::get('/send_mail', [SendMailOrders::class, 'build'])->name('send-mail-orders.send-send-mail');

