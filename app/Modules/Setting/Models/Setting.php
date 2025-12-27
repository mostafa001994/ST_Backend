<?php
namespace App\Modules\Setting\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = strtolower('Settings');
    protected $fillable = [];
}