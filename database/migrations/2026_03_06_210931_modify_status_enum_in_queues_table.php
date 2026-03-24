<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Modify ENUM to include all status values
        DB::statement("ALTER TABLE queues MODIFY COLUMN status ENUM('pending', 'approved', 'waiting', 'called', 'served', 'skipped', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE queues MODIFY COLUMN status ENUM('waiting', 'called', 'served', 'skipped') DEFAULT 'waiting'");
    }
};
