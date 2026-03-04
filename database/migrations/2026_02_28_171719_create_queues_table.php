<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('queues', function (Blueprint $table) {
            $table->id();
            $table->string('queue_number');
            $table->string('patient_name');
            $table->string('nik', 16);
            $table->string('service_type');
            $table->enum('status', ['waiting','called','served','skipped'])->default('waiting');
            $table->timestamp('called_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('queues');
    }
};