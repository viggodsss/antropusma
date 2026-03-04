<?php
require 'vendor/autoload.php';
use BaconQrCode\Writer;
use BaconQrCode\Renderer\Image\Png;

$renderer = new Png();
$writer = new Writer($renderer);
$data = $writer->writeString('hello world');
file_put_contents('d:\\laragon\\www\\sistem-antrian\\hello.png', $data);
echo "created\n";