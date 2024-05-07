<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrderDetail extends Model
{
    protected $table =  'purchaseOrderDetail';
    protected $filltable = 'id,purchaseOrderID,productID,MOQ,unitPrice,description,unit,vat,deliveryDate,note';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;
}
