<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('ALTER TABLE queues MODIFY COLUMN queue_number VARCHAR(255) NULL');
    }

    public function down(): void
    {
        DB::statement("UPDATE queues SET queue_number = CONCAT('N', LPAD(id, 3, '0')) WHERE queue_number IS NULL");
        DB::statement('ALTER TABLE queues MODIFY COLUMN queue_number VARCHAR(255) NOT NULL');
    }
};
