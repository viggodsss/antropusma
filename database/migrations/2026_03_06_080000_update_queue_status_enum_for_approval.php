<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::statement("ALTER TABLE queues MODIFY status ENUM('pending','waiting','called','served','skipped','rejected') NOT NULL DEFAULT 'pending'");
    }

    public function down(): void
    {
        DB::statement("UPDATE queues SET status = 'waiting' WHERE status IN ('pending','rejected')");
        DB::statement("ALTER TABLE queues MODIFY status ENUM('waiting','called','served','skipped') NOT NULL DEFAULT 'waiting'");
    }
};
