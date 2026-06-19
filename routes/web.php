<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AdController;
use App\Http\Controllers\AdminController;




//inscription et send email
    //inscription
        Route::get('/register', [AuthController::class, 'showRegister']);
        Route::post('/register', [AuthController::class, 'register']);
    //email page
        Route::get('/email/verify', function(){
            return view('auth.verify-email');
        })->middleware('auth')->name('verification.notice');
    //verification de l'email
        Route::get('/email/verify/{id}/{hash}', function(EmailVerificationRequest $request){
            $request->fulfill();
            return redirect('/login');
        })->middleware(['auth', 'signed'])->name('verification.verify');
    //renvoie de l'email
        Route::post('/email/resend', function(Request $request){
            $request->user()->sendEmailVerificationNotification();
            return back()->with('message', 'email reenvoyer !');
        })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

//connexion
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);


//deconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


//profile user
    Route::middleware('auth')->group(function(){
        Route::get('/profile', [UserController::class, 'show']);
        Route::get('/profile/edit', [UserController::class, 'edit']);
        Route::put('/profile', [UserController::class, 'update']);
        Route::delete('/profile', [UserController::class, 'destroy']);
    });



//route des annonces
    Route::middleware(['auth', 'verified'])->group(function(){
        //ad une ad
            Route::get('/ads/create', [AdController::class, 'create']);
            Route::post('/ads', [AdController::class, 'store']);

        //modifier une ad
            Route::get('/ads/{id}/edit', [AdController::class, 'edit']);
            Route::put('/ads/{id}', [AdController::class, 'update']);
        //suprimer un ad
            Route::delete('/ads/{id}', [AdController::class, 'destroy']);
    });

    //homme page
        Route::get('/', [AdController::class, 'index']);
    //voir une ad speci
        Route::get('ads/{id}', [AdController::class, 'show']);

// admin root
    Route::middleware(['auth', 'verified'])->group(function(){
        // user
        Route::get('/admin/users', [AdminController::class, 'users']);
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'editUsers']);
        Route::put('/admin/users/{id}', [AdminController::class, 'updateUser']);
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroyUser']);

        //ad ad ad
        Route::get('/admin/ads', [AdminController::class, 'ads']);
        Route::get('/admin/ads/{id}/edit', [AdminController::class, 'editAd']);
        Route::delete('/admin/ads/{id}', [AdminController::class, 'destroyAd'])->name('destroy');
        Route::put('/admin/ads/{id}', [AdminController::class, 'updateAd']);

        Route::get('/cat', [AdminController::class, 'showCat']);
        Route::post('/cat', [AdminController::class, 'adCategory']);

    });



//



