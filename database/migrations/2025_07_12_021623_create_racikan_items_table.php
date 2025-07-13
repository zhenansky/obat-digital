<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('racikan_items', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resep_detail_id')->constrained('resep_details')->onDelete('cascade');
            $table->integer('obatalkes_id')->nullable();
            $table->unsignedInteger('qty');

            $table->timestamps();

            $table->foreign('obatalkes_id')->references('obatalkes_id')->on('obatalkes_m');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('racikan_items');
    }
};
