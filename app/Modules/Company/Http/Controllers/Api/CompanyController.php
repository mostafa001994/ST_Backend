<?php
namespace App\Modules\Company\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Company\Models\Company;

class CompanyController extends Controller
{
    public function index()
    {
        return response()->json(Company::paginate(10));
    }

    public function show($id)
    {
        return response()->json(Company::findOrFail($id));
    }
}