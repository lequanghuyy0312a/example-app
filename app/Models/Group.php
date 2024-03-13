<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $table =  'groupProduct';
    protected $filltable = 'id,name';
    protected $primarykey = 'id';

    public $timestamps = false;
}
