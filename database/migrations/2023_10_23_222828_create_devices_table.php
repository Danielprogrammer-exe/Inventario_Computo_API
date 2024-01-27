<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->String('code')->unique();
            $table->String('brand');
            $table->String('model');
            $table->String('serie');
            $table->String('type_device');
            $table->String('status');
//            $table->String('company');
//            $table->String('campus');
//            $table->String('windows_license')->nullable();
//            $table->String('microsoft_office_license')->nullable();
//            $table->String('corel_draw_license')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
