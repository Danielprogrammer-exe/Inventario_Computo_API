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
        'status',
        'company'
        /*'campus'(sede)
        'invoice code'(codigo de factura)
        'windows_license'
        'micrsoft_office_license'
        'corel_draw_license'
        'area'(donde se usa, logistica, call center, etc)*/
    ];
}
