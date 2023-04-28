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
        Schema::create('hourly_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('day_id');
            $table->string('hour');
            $table->string('time_slot');
            $table->float('pcb', 3, 2);
            $table->float('cym', 3, 2)->nullable();
            $table->timestamps();

            $table->unique(['day_id', 'hour']);
            $table->foreign('day_id')
              ->references('id')->on('days')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hourly_prices');
    }
};
