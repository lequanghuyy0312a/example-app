<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    protected $table =  'process';
    protected $filltable = 'id,name, warehouseImport,warehouseExport';
    protected $primarykey = 'id';

    public $timestamps = false;
    use HasFactory;
}
