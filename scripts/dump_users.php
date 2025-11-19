<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$users = $app['db']->table('users')->select('id','name','email','role')->get();
echo json_encode($users, JSON_PRETTY_PRINT);
