<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix the id column to be auto-increment
        Schema::table('contacts', function (Blueprint $table) {
            // Drop the primary key first if it exists
            $table->dropPrimary('id');
        });
        
        // Use raw SQL to modify the id column to auto_increment
        DB::statement('ALTER TABLE contacts MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This is a fix, so no need to undo
    }
};
