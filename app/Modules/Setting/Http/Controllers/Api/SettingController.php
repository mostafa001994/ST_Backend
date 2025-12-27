<?php
namespace App\Modules\Setting\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Modules\Setting\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return response()->json(Setting::paginate(10));
    }

    public function show($id)
    {
        return response()->json(Setting::findOrFail($id));
    }
}