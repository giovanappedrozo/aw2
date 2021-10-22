<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgendamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agendamentos', function (Blueprint $table) {
            $table->id();
            $table->enum('espaco', ['Laboratório', 'Anfiteatro', 'Sala de aula']);
            $table->enum('periodo', ['M1', 'M2', 'M3', 'M4', 'M5', 'M6', 'V0', 'V1', 'V2', 'V3', 'V4', 'V5', 'V6', 'N0', 'N1', 'N2', 'N3', 'N4', 'N5', 'N6']);
            $table->date('data');
            $table->integer('solicitante');
            $table->foreign('solicitante')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agendamentos');
    }
}
