<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $table =  'quotationDetail';
    protected $filltable = 'id,quotationID,productID,orderCode,unit,quantity,unitPrice,description,orderProductName,VAT';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;

}
