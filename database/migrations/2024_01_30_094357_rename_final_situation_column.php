<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameFinalSituationColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repairs', function (Blueprint $table) {
            // Renombrar el campo "final_situation" a "final_state"
            $table->renameColumn('final_situation', 'final_state');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repairs', function (Blueprint $table) {
            // Revertir el cambio en caso de hacer un rollback
            $table->renameColumn('final_state', 'final_situation');
        });
    }
}
