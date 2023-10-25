<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenances';

    protected $fillable = [
        'name_user',
        'code_device',
        'observations',
        'status',
        'soplado_general',
        'ventiladores',
        'disipador_del_procesador',
        'ranuras_de_expansion',
        'tarjetas_de_memoria',
        'fuente_de_poder',
        'lectora_de_CD_DVD',
        'monitor',
        'teclado',
        'mouse',
        'desfragmentado_de_disco',
        'scandisk',
        'mantenimiento_de_archivos',
        'asistente_para_quitar_programas',
        'eliminacion_de_archivos_temporales',
        'eliminacion_de_cookies_y_archivos_temporales',
        'analisis_con_antivirus_antiSpyware',
        'analisis_de_registro',
        'prueba_de_impresion_antes_del_mantenimiento',
        'impresion_pagina_de_configuracion',
        'verificacion_del_contador_de_paginas_impresas',
        'verificacion_del_estado_de_los_consumibles',
        'limpieza_de_los_consumibles',
        'verificacion_de_los_mecanismos_de_impresion',
        'limpieza_de_los_mecanismos_de_impresion',
        'limpieza_externa_del_equipo',
        'prueba_de_impresion_despues_del_mantenimiento'
    ];
}
