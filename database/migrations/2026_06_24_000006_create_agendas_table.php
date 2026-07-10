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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('event_date');
            $table->time('event_time')->nullable();
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->string('category')->default('umum')->comment('akademik, ekstrakurikuler, kegiatan, seremonial, umum');
            $table->string('image')->nullable();
            $table->boolean('is_recurring')->default(false);
            $table->string('recurrence_pattern')->nullable()->comment('Harian, Mingguan, Bulanan, Tahunan');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agendas');
    }
};
