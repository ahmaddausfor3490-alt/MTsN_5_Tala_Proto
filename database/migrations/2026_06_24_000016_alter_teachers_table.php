<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add is_principal, designation, and rename columns for the hybrid model.
     *
     * - is_principal: marks the Kepala Sekolah (principal)
     * - designation: role classification (kepala_sekolah, guru, staf, wakil_kepala_sekolah)
     * - subject_taught: replaces position for academic staff
     */
    public function up(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->boolean('is_principal')->default(false)->after('is_active');
            $table->string('designation')->default('guru')->comment('kepala_sekolah, wakil_kepala_sekolah, guru, staf');

            // Keep existing 'position' column — add subject_taught alongside it
            // (for academic staff, subject is more useful than position)
        });
    }

    public function down(): void
    {
        Schema::table('teachers', function (Blueprint $table) {
            $table->dropColumn(['is_principal', 'designation']);
        });
    }
};
