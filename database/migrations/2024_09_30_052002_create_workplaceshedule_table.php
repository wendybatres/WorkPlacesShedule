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
        Schema::create('workplaceshedule', function (Blueprint $table) {
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workplaceshedules');
    }
};
