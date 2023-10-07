<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;

    protected $table='devices';

    protected $fillable=[
        'id_device',
        'name',
        'id_estado',
];
}
