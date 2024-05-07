<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $table =  'purchaseOrder';
    protected $filltable = 'id,phaseID,ATTN,purchaseOrderNo,POOnUTC,currency,rate,acceptedBy, acceptedOnUTC,note,productID, status,createdBy';
    protected $primarykey = 'id';
    public $timestamps = false;
    use HasFactory;
}
