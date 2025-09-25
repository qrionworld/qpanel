<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettingImage extends Model
{
    use HasFactory;

    protected $fillable = ['setting_id', 'path'];

    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }
}
