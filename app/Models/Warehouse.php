<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    protected $table =  'warehouse';
    protected $filltable = 'id,name';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;
}
