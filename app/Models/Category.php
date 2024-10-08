<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // protected $primaryKey = 'id';

    protected $fillable = [
        'cat_name', 'status', 'cat_image',
    ];

    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id', 'id');
    }
}
