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
        // Trước tiên, xóa khóa chính hiện tại
        Schema::table('favorites', function (Blueprint $table) {
            $table->dropPrimary();
        });

        // Sử dụng DB::statement để thay đổi trường id thành AUTO_INCREMENT
        DB::statement('ALTER TABLE favorites MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Xóa AUTO_INCREMENT từ trường id (nếu muốn rollback)
        DB::statement('ALTER TABLE favorites MODIFY id BIGINT UNSIGNED NOT NULL');
        
        // Thêm lại khóa chính
        Schema::table('favorites', function (Blueprint $table) {
            $table->primary('id');
        });
    }
};
