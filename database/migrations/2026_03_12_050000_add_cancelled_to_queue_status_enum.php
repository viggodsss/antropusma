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
        DB::statement("ALTER TABLE queues MODIFY COLUMN status ENUM('pending', 'approved', 'waiting', 'called', 'served', 'skipped', 'rejected', 'cancelled') NOT NULL DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Keep enum valid before removing cancelled from allowed values.
        DB::statement("UPDATE queues SET status = 'rejected' WHERE status = 'cancelled'");
        DB::statement("ALTER TABLE queues MODIFY COLUMN status ENUM('pending', 'approved', 'waiting', 'called', 'served', 'skipped', 'rejected') NOT NULL DEFAULT 'pending'");
    }
};
