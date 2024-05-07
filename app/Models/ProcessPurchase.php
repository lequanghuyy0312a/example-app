<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessPurchase extends Model
{
    protected $table =  'processPurchase';
    protected $filltable = 'id,POID,materialID,quantity,date,note,approve';
    protected $primarykey = 'id';
    public $timestamps = false;
    use HasFactory;
}
