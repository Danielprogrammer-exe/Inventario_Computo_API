<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'inv_maintenance';

    protected $fillable = [
        'name_user',
        'var_codigo_fixedasset',
        'Observations',
        'Status',
        //date created y dated updated
        'flg_soplado_general',
        'flg_Ventiladores',
        'flg_Disipador_del_Procesador',
        'flg_Ranuras_de_Expansion',
        'flg_Tarjetas_de_Memoria',
        'flg_Fuente_de_Poder',
        'flg_Lectora_de_CD_DVD',
        'flg_Monitor',
        'flg_Teclado',
        'flg_Mouse',
        'flg_Desfragmentado_de_Disco',
        'flg_Scandisk',
        'flg_Mantenimiento_de_archivos',
        'flg_Asistente_para_quitar_Programas',
        'flg_Eliminacion_de_Archivos_Temporales',
        'flg_Eliminacion_de_Cookies_y_Archivos_Temporales',
        'flg_Analisis_con_Antivirus_AntiSpyware',
        'flg_Analisis_de_Registro',
        'flg_Prueba_de_impresion_antes_del_mantenimiento',
        'flg_Impresion_pagina_de_configuracion',
        'flg_Verificacion_del_contador_de_paginas_impresas',
        'flg_Verificacion_del_estado_de_los_consumibles',
        'flg_Limpieza_de_los_consumibles',
        'flg_Verificacion_de_los_mecanismos_de_impresion',
        'flg_Limpieza_de_los_mecanismos_de_impresion',
        'flg_Limpieza_externa_del_equipo',
        'flg_Prueba_de_impresion_despues_del_mantenimiento'
    ];
}
