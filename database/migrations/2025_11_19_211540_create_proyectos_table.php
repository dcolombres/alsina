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
        Schema::create('proyectos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('origen')->nullable();
            $table->string('dependencia')->nullable();
            $table->string('tier')->nullable();
            $table->foreignId('cliente_id')->nullable()->constrained()->onDelete('set null');
            $table->json('stack_tecnologico')->nullable();
            $table->string('estado')->default('activo');
            $table->string('categoria')->nullable();
            $table->string('subcategoria')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('staff')->onDelete('set null');
            $table->text('observacion')->nullable();
            $table->json('urls')->nullable();
            $table->string('captura')->nullable();
            $table->string('nube')->nullable();
            $table->string('ticketera_interna')->nullable();
            $table->string('ticketera_externa')->nullable();
            $table->text('changelog')->nullable();
            $table->integer('ano')->nullable();
            $table->integer('usuarios_internos')->nullable();
            $table->integer('usuarios_externos')->nullable();
            $table->json('tecnologias_backend')->nullable();
            $table->json('tecnologias_frontend')->nullable();
            $table->string('base_datos')->nullable();
            $table->string('versionado')->nullable();
            $table->string('alojamiento')->nullable();
            $table->string('vms')->nullable();
            $table->text('instrucciones_deploy')->nullable();
            $table->string('referente')->nullable();
            $table->text('notas_infraestructura')->nullable();
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
        Schema::dropIfExists('proyectos');
    }
};
