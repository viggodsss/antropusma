<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
use App\Models\Queue;
$q=Queue::find(1);
$ticketUrl = route('queue.show',$q);
echo "ticket url: $ticketUrl\n";
$src = "https://chart.googleapis.com/chart?chs=200x200&cht=qr&chl=".urlencode($ticketUrl)."&choe=UTF-8";
echo "src: $src\n";
