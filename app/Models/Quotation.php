<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    protected $table =  'quotation';
    protected $filltable = 'id,phaseID,quotationCode,quotationDate,validityDate,createdOnUTC,
                            latestUpdated,partnerID,exchangeRate,contact,payment,delivery,savedBy,receivedFrom,leadTime,note,approve';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;

}
