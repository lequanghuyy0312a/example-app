<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phase extends Model
{
    protected $table =  'phase';
    protected $filltable = 'id,name, USDtoVND, USDtoJPY, JPYtoVND, Al';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;

}
