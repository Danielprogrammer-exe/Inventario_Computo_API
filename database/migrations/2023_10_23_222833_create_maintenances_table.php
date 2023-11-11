<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     */
    public function up()
    {
        Schema::create('maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('name_user');
            $table->string('code_device');
            $table->text('observations')->nullable();
            $table->boolean('status')->nullable();
            $table->boolean('soplado_general')->nullable();
            $table->boolean('ventiladores')->nullable();
            $table->boolean('disipador_del_procesador')->nullable();
            $table->boolean('ranuras_de_expansion')->nullable();
            $table->boolean('tarjetas_de_memoria')->nullable();
            $table->boolean('fuente_de_poder')->nullable();
            $table->boolean('lectora_de_CD_DVD')->nullable();
            $table->boolean('monitor')->nullable();
            $table->boolean('teclado')->nullable();
            $table->boolean('mouse')->nullable();
            $table->boolean('desfragmentado_de_disco_scandisk')->nullable();
            $table->boolean('mantenimiento_de_archivos')->nullable();
            $table->boolean('asistente_para_quitar_programas')->nullable();
            $table->boolean('eliminacion_de_archivos_temporales')->nullable();
            $table->boolean('eliminacion_de_cookies_y_archivos_temporales')->nullable();
            $table->boolean('analisis_con_antivirus')->nullable();
            $table->boolean('antiSpyware')->nullable();
            $table->boolean('analisis_de_registro')->nullable();
            $table->boolean('prueba_de_impresion_antes_del_mantenimiento')->nullable();
            $table->boolean('impresion_pagina_de_configuracion')->nullable();
            $table->boolean('verificacion_del_contador_de_paginas_impresas')->nullable();
            $table->boolean('verificacion_del_estado_de_los_consumibles')->nullable();
            $table->boolean('limpieza_de_los_consumibles')->nullable();
            $table->boolean('verificacion_de_los_mecanismos_de_impresion')->nullable();
            $table->boolean('limpieza_de_los_mecanismos_de_impresion')->nullable();
            $table->boolean('limpieza_externa_del_equipo')->nullable();
            $table->boolean('prueba_de_impresion_despues_del_mantenimiento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }

};
