<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('workplacesshedule', function (Blueprint $table) {
            $table->id(); // Campo ID autoincremental
            $table->integer('userid');
            $table->dateTime('shedule');
            $table->boolean('isactive')->default(true);
            $table->dateTime('created_at')->useCurrent();
            $table->dateTime('updated_at')->nullable();

            // Agrega índices si es necesario
            $table->index('userid');

            $table->unique(['userid', 'shedule']);

        });
    }

    public function down()
    {
        Schema::dropIfExists('workplacesshedule');
    }
};
