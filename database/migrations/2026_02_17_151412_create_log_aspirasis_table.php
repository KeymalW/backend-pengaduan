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
        Schema::create('log_aspirasis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aspirasi');
            $table->string('status_lama')->nullable();
            $table->string('status_baru');
            $table->text('keterangan')->nullable();
            $table->string('perubah_role'); // 'admin' atau 'siswa'
            $table->unsignedBigInteger('perubah_id');
            $table->timestamps();

            $table->foreign('id_aspirasi')->references('id_pelaporan')->on('input_aspirasis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_aspirasis');
    }
};
