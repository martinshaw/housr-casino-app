<?php

use App\Http\Middleware\CreateAnonymousUserOnNewSession;
use App\Livewire\Pages\Slots;
use App\Livewire\Pages\SlotsCashout;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware([CreateAnonymousUserOnNewSession::class])->group(function () {
    Route::get('/', fn () => redirect()->to(route('slots')))->name('welcome');

    Route::get('/slots', Slots::class)->name('slots');
    Route::get('/slots/cashout', SlotsCashout::class)->name('slots.cashout');
});
