<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table =  'productDetail';
    protected $filltable = 'id, productID,importedPhase, exportedPhase, beginningInventory, endingInventory, orderCode, partnerID, createdOnUTC, latestUpdated';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;
}
