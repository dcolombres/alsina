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
        Schema::table('proyectos', function (Blueprint $table) {
            // Drop old columns
            $table->dropColumn(['stack_tecnologico', 'tecnologias_backend', 'tecnologias_frontend', 'base_datos', 'alojamiento']);

            // Add Backend columns
            $table->string('lenguaje_principal_backend')->nullable();
            $table->string('version_backend')->nullable();
            $table->string('otro_lenguaje_backend')->nullable();
            $table->text('librerias_backend')->nullable();
            $table->string('framework_backend')->nullable();

            // Add Frontend columns
            $table->enum('lenguaje_principal_frontend', ['React', 'Angular', 'VUE js', 'Otro'])->nullable();
            $table->string('version_frontend')->nullable();
            $table->string('otro_lenguaje_frontend')->nullable();
            $table->text('librerias_frontend')->nullable();
            $table->string('framework_frontend')->nullable();

            // Add Database columns
            $table->string('tecnologia_bd')->nullable();
            $table->string('version_bd')->nullable();
            $table->string('bd_2')->nullable();
            $table->string('tamaño_bd')->nullable();
            $table->string('servidor_bd')->nullable();
            $table->boolean('backup_bd')->nullable();

            // Add Infrastructure columns
            $table->enum('repositorio', ['git.produccion.gob.ar', 'Otro Gitlab', 'Github', 'BitBucket', 'Subversion', 'Otro'])->nullable();
            $table->string('url_repositorio')->nullable();
            $table->boolean('instrucciones_stack')->nullable();
            $table->string('alojamiento_productivo')->nullable();
            $table->string('alojamiento_hml')->nullable();
            $table->string('alojamiento_tst')->nullable();
            $table->boolean('contenedor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proyectos', function (Blueprint $table) {
            // Re-add old columns
            $table->json('stack_tecnologico')->nullable();
            $table->json('tecnologias_backend')->nullable();
            $table->json('tecnologias_frontend')->nullable();
            $table->string('base_datos')->nullable();
            $table->string('alojamiento')->nullable();

            // Drop new columns
            $table->dropColumn([
                'lenguaje_principal_backend', 'version_backend', 'otro_lenguaje_backend', 'librerias_backend', 'framework_backend',
                'lenguaje_principal_frontend', 'version_frontend', 'otro_lenguaje_frontend', 'librerias_frontend', 'framework_frontend',
                'tecnologia_bd', 'version_bd', 'bd_2', 'tamaño_bd', 'servidor_bd', 'backup_bd',
                'repositorio', 'url_repositorio', 'instrucciones_stack',
                'alojamiento_productivo', 'alojamiento_hml', 'alojamiento_tst', 'contenedor'
            ]);
        });
    }
};