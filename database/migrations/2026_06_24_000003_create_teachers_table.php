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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nip')->nullable()->comment('Nomor Induk Pegawai');
            $table->string('position')->comment('Jabatan / mata pelajaran yang diampu');
            $table->string('photo')->nullable();
            $table->text('bio')->nullable();
            $table->string('education')->nullable()->comment('Pendidikan tertinggi');
            $table->string('contact')->nullable()->comment('Nomor telepon / email');
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
