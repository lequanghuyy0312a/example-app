<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;
    protected $table =  'stock';
    protected $filltable = 'id,productID,quantity,POID,createdOnUTC,note,type,createdBy';

    protected $primarykey = 'id';

    public $timestamps = false;
}
