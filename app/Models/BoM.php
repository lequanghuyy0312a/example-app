<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BoM extends Model
{

    protected $table =  'BoM';
    protected $filltable = 'id,productID, materialID, productCode, materialCode, quantity, latestUpdated';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;
}
