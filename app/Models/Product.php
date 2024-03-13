<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table =  'product';
    protected $filltable = 'id,
    categoryID,
    typeID,
    groupID,
    phaseID,
    code,
    name,
    image,
    warehouseID,
    sellingPrice,
    costPrice,
    orderCode,
    orderCode,
    latestUpdated,
    unit,  ';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;
}


