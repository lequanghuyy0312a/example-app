<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table =  'category';
    protected $filltable = 'id,name';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;
}
