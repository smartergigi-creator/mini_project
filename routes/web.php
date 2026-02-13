<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\EbookController;
use App\Http\Controllers\EbookShareController;
use App\Http\Controllers\SerpAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Root
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/home', [HomeController::class, 'userHome']);



/*
|--------------------------------------------------------------------------
| Auth
|--------------------------------------------------------------------------
*/

Route::get('/login', function () {
    if (auth()->check()) {
        return redirect()->route('admin.ebooks');
    }
    return view('auth.login');
})->name('login');

Route::post('/serp-login', [SerpAuthController::class, 'login'])
    ->name('serp.login');

Route::post('/logout', [SerpAuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Protected (All Logged Users)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','serp.auth','nocache'])->group(function () {

    /* ---------------- Dashboard ---------------- */

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
        ->middleware('admin')
        ->name('admin.dashboard');


    /* ---------------- Ebooks ---------------- */

    Route::get('/admin/ebooks', [EbookController::class, 'index'])
        ->name('admin.ebooks');

    Route::get('/ebook/view/{id}', [EbookController::class, 'view']);


    /* ---------------- Upload ---------------- */

    Route::post('/ebooks/upload',
        [EbookController::class, 'store']
    )->middleware('can.upload');


    /* ---------------- Share ---------------- */

    Route::post('/ebooks/share/{id}',
        [EbookShareController::class, 'generate']
    )->middleware('can.share');


    /* ---------------- Delete ---------------- */

    Route::delete('/ebook/delete/{id}',
        [EbookController::class, 'delete']
    );

});


/*
|--------------------------------------------------------------------------
| Admin Only
|--------------------------------------------------------------------------
*/

Route::middleware(['auth','admin'])->group(function () {

    Route::post('/admin/users/{id}/update',
        [UserController::class, 'update']
    )->name('admin.users.update');

    Route::post('/admin/users/{id}/reset-uploads',
        [AdminController::class, 'resetUserUploads']
    )->name('admin.users.resetUploads');

});


/*
|--------------------------------------------------------------------------
| Public Share View (No Login)
|--------------------------------------------------------------------------
*/

Route::get('/flip-book/{token}',
    [EbookShareController::class, 'view']
)->name('ebook.share');
