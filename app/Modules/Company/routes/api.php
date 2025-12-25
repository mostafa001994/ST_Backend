<?php
use Illuminate\Support\Facades\Route;
use App\Modules\Company\Http\Controllers\Api\CompanyController;

Route::prefix('api/company')->group(function () {
    Route::get('/', [CompanyController::class, 'index']);
    Route::get('{id}', [CompanyController::class, 'show']);
});