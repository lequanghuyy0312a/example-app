<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;
    protected $table =  'partner';
    protected $filltable = 'id,name,tax, address, email, phone, type, note, latestUpdated';
    protected $primarykey = 'id';

    public $timestamps = false;
}
