<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->char('nim', 13)->unique();
            $table->string('nama', 100);
            $table->foreignId('program_studi_id')
                ->constrained('program_studis');
            $table->string('email', 100)->unique();
            $table->string('nomor_hp', 15)->unique();
            $table->boolean('jenis_kelamin')->default(true);
            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->char('golongan_darah', 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};