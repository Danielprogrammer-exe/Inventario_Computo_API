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
            $table->string('status')->default('Operativo');
            $table->boolean('soplado_general')->default(false);
            $table->boolean('ventiladores')->default(false);
            $table->boolean('disipador_del_procesador')->default(false);
            $table->boolean('ranuras_de_expansion')->default(false);
            $table->boolean('tarjetas_de_memoria')->default(false);
            $table->boolean('fuente_de_poder')->default(false);
            $table->boolean('lectora_de_CD_DVD')->default(false);
            $table->boolean('monitor')->default(false);
            $table->boolean('teclado')->default(false);
            $table->boolean('mouse')->default(false);
            $table->boolean('desfragmentado_de_disco_scandisk')->default(false);
            $table->boolean('mantenimiento_de_archivos')->default(false);
            $table->boolean('asistente_para_quitar_programas')->default(false);
            $table->boolean('eliminacion_de_archivos_temporales')->default(false);
            $table->boolean('eliminacion_de_cookies_y_archivos_temporales')->default(false);
            $table->boolean('analisis_con_antivirus')->default(false);
            $table->boolean('antiSpyware')->default(false);
            $table->boolean('analisis_de_registro')->default(false);
            $table->boolean('prueba_de_impresion_antes_del_mantenimiento')->default(false);
            $table->boolean('impresion_pagina_de_configuracion')->default(false);
            $table->boolean('verificacion_del_contador_de_paginas_impresas')->default(false);
            $table->boolean('verificacion_del_estado_de_los_consumibles')->default(false);
            $table->boolean('limpieza_de_los_consumibles')->default(false);
            $table->boolean('verificacion_de_los_mecanismos_de_impresion')->default(false);
            $table->boolean('limpieza_de_los_mecanismos_de_impresion')->default(false);
            $table->boolean('limpieza_externa_del_equipo')->default(false);
            $table->boolean('prueba_de_impresion_despues_del_mantenimiento')->default(false);
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
