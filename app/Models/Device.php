<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';

    protected $fillable=[
        'code',
        'brand',
        'model',
        'serie',
        'type_device',
        'status'
    ];
}
