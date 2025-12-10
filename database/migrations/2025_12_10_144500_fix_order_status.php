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
        // Memperbaiki kolom status agar menyertakan 'unpaid' yang menyebabkan error 'Data truncated'.
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM('unpaid', 'paid', 'pending', 'processing', 'shipped', 'delivered', 'cancelled') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu rollback karena akan menghapus data 'unpaid' yang valid
    }
};
