<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repair extends Model
{
    use HasFactory;

    protected $table = 'repairs';

    protected $fillable = [
        'code_device',
        'name_user',
        'initial_state',
        'diagnosis',
        'solution',
        'final_state',
    ];
}
