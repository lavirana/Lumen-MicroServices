<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'body', 'author_id' , 'content'];
}
