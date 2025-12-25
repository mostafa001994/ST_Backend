<?php
namespace App\Modules\Test\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Test\Models\Test;

class TestController extends Controller
{
    public function index()
    {
        return response()->json(Test::paginate(10));
    }

    public function show($id)
    {
        return response()->json(Test::findOrFail($id));
    }
}