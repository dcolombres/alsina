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
        Schema::table('staff', function (Blueprint $table) {
            // 1. Add new columns
            $table->string('nombres')->after('id')->nullable();
            $table->string('apellidos')->after('nombres')->nullable();
            $table->boolean('ur')->after('remuneracion')->default(false);

            // 2. Change existing columns
            $table->string('remuneracion')->nullable()->change();
            $table->boolean('extras')->default(false)->change();
            $table->string('tecnologia')->nullable()->change();

            // 3. Drop the old column
            $table->dropColumn('nombre_apellido');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('staff', function (Blueprint $table) {
            // 1. Add back the old column
            $table->string('nombre_apellido')->after('id');

            // 2. Revert changed columns
            $table->decimal('remuneracion', 10, 2)->nullable()->change();
            $table->text('extras')->nullable()->change();
            $table->json('tecnologia')->nullable()->change();

            // 3. Drop the new columns
            $table->dropColumn(['nombres', 'apellidos', 'ur']);
        });
    }
};