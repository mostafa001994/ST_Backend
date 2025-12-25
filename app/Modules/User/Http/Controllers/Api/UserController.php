<?php
namespace App\Modules\User\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\User\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(User::paginate(10));
    }

    public function show($id)
    {
        return response()->json(User::findOrFail($id));
    }
}