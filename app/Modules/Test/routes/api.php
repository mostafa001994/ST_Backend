<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Test\Http\Controllers\Api\TestController;

Route::prefix('api/test')->group(function () {
    Route::get('/', [TestController::class, 'index']);
    Route::get('{id}', [TestController::class, 'show']);
});