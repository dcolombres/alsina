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
        Schema::create('cliente_proyecto', function (Blueprint $table) {
            $table->foreignId('cliente_id')->constrained()->onDelete('cascade');
            $table->foreignId('proyecto_id')->constrained()->onDelete('cascade');
            $table->primary(['cliente_id', 'proyecto_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cliente_proyecto');
    }
};
