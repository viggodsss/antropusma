<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_notification_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('queue_id')->nullable()->constrained('queues')->nullOnDelete();
            $table->string('provider_name', 50)->default('primary');
            $table->string('event', 50);
            $table->string('phone_number', 25)->nullable();
            $table->unsignedInteger('attempt')->default(1);
            $table->string('status', 20)->default('failed'); // sent|failed|skipped
            $table->unsignedSmallInteger('http_status')->nullable();
            $table->string('endpoint')->nullable();
            $table->json('request_payload')->nullable();
            $table->text('response_body')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->index(['event', 'status']);
            $table->index(['queue_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_notification_logs');
    }
};
