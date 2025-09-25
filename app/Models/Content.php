<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'category_id'];

    public function images()
    {
        return $this->hasMany(ContentImage::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
