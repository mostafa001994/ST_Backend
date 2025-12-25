<?php
use Illuminate\Support\Facades\Route;
use App\Modules\User\Http\Controllers\Api\UserController;

Route::prefix('api/user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('{id}', [UserController::class, 'show']);
});