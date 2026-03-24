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
        Schema::table('queues', function (Blueprint $table) {
            $table->date('queue_date')->nullable()->after('service_type');
        });

        // Update existing queues to set queue_date from created_at
        \DB::statement('UPDATE queues SET queue_date = DATE(created_at) WHERE queue_date IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('queues', function (Blueprint $table) {
            $table->dropColumn('queue_date');
        });
    }
};
