<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_apellido');
            $table->string('email')->unique();
            $table->string('celular')->nullable();
            $table->string('rol');
            $table->string('tipo');
            $table->string('seniority');
            $table->json('tecnologia')->nullable();
            $table->string('contrato');
            $table->decimal('remuneracion', 10, 2)->nullable();
            $table->string('urgencia')->nullable();
            $table->text('extras')->nullable();
            $table->string('modalidad');
            $table->integer('dias_presencial')->default(0);
            $table->integer('dias_remoto')->default(0);
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
        Schema::dropIfExists('staff');
    }
};
