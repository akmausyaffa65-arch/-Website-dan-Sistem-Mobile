<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->id();

            $table->string('nidn', 10)
                ->unique()
                ->nullable();

            $table->string('nip', 18)
                ->unique()
                ->nullable();

            $table->date('tmt')
                ->nullable();

            $table->string('nama_lengkap', 100);

            $table->foreignId('pangkat_id')
                ->nullable()
                ->constrained('pangkats');

            $table->boolean('jenis_kelamin')
                ->default(1);

            $table->string('foto', 255)
                ->default('https://www.gravatar.com/avatar/?d=identicon');

            $table->foreignId('kelompok_bidang_keahlian_id')
                ->nullable()
                ->constrained('kelompok_bidang_keahlians');

            $table->text('bidang_keilmuan')
                ->nullable();

            $table->enum('fungsi_fungsional', [
                'tenaga pengajar',
                'asisten ahli',
                'lektor',
                'lektor kepala',
                'guru besar'
            ])->default('tenaga pengajar');

            $table->enum('status', [
                'aktif',
                'cuti',
                'ijin belajar',
                'tugas di instansi lain',
                'tugas belajar'
            ])->default('aktif');

            $table->foreignId('user_id')
                ->nullable()
                ->constrained('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('program_studi_id')
                ->nullable()
                ->constrained('program_studis')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};