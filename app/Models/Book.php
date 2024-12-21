<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'author', 'image', 'barcode'];


    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            $slug = Str::slug($model->title);
            $model->slug = $slug;

            // Check if the slug is already used by another model
            $i = 2;
            while (static::whereSlug($model->slug)->exists()) {
                $model->slug = $slug.'-'.$i++;
            }
        });
    }
}
