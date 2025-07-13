<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('racikan_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('resep_detail_id')->constrained('resep_details')->onDelete('cascade');


            $table->integer('obatalkes_id');

            $table->decimal('qty', 10, 2); // Quantity obat dalam racikan
            $table->string('satuan', 50); // mg, ml, tablet, dll
            $table->text('keterangan')->nullable(); // Keterangan khusus
            $table->timestamps();

            // Foreign key constraint ke tabel obatalkes_m
            $table->foreign('obatalkes_id')->references('obatalkes_id')->on('obatalkes_m')->onDelete('cascade');

            // Index untuk performa query
            $table->index(['resep_detail_id', 'obatalkes_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('racikan_details');
    }
};