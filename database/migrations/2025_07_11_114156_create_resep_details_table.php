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
        Schema::create('resep_details', function (Blueprint $table) {
            $table->id();

            $table->foreignId('resep_id')->constrained('reseps')->onDelete('cascade');

            // Non-racikan
            $table->integer('obatalkes_id')->nullable();


            // Racikan
            $table->string('nama_racikan')->nullable();
            $table->boolean('is_racikan')->default(false);

            $table->unsignedInteger('qty')->default(1);

            $table->integer('signa_id')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('obatalkes_id')->references('obatalkes_id')->on('obatalkes_m');
            $table->foreign('signa_id')->references('signa_id')->on('signa_m');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resep_details');
    }
};
