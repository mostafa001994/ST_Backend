<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Setting\Http\Controllers\Api\SettingController;

Route::prefix('api/setting')->group(function () {
    Route::get('/', [SettingController::class, 'index']);
    Route::get('{id}', [SettingController::class, 'show']);
});