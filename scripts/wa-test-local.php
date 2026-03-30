<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$queue = App\Models\Queue::whereHas('user.profile', function ($q) {
    $q->where(function ($sub) {
        $sub->whereNotNull('no_hp')->where('no_hp', '<>', '');
    })->orWhere(function ($sub) {
        $sub->whereNotNull('no_telepon')->where('no_telepon', '<>', '');
    });
})->latest('id')->first();

if (!$queue) {
    echo "NO_QUEUE_WITH_PHONE\n";
    exit(0);
}

$ok = app(App\Services\WhatsAppQueueNotifier::class)->sendQueueEvent($queue, 'waiting');
echo 'QUEUE_ID=' . $queue->id . ';RESULT=' . ($ok ? 'SENT' : 'FAILED') . PHP_EOL;
