<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $table = 'books';
    public $timestamps = false;
    protected $fillable = ['ISBN', 'title', 'author_id', 'description', 'thumbnail'];

    public function booksCategories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany( Category::class, 'book_category')->withPivot('book_id', 'category_id');

    }

    public function authors()
    {
        return $this->belongsTo(Author::class, 'author_id','id');
    }
}
