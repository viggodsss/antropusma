<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Queue;
use Illuminate\Http\Request;
use App\Http\Controllers\QueueController;

$queue = Queue::find(9);
$request = Request::create('/antrian/'.$queue->id, 'GET', ['token' => $queue->token]);
$controller = new QueueController();
$response = $controller->show($queue, $request);
echo $response->getContent();
