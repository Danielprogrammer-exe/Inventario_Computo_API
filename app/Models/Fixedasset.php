<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fixedasset extends Model
{
    use HasFactory;

    protected $table='inv_fixedasset';

    protected $fillable=[
        'var_codigo',
        'var_marca',
        'var_modelo',
        'var_serie',
    ];
}
