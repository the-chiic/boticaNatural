<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;

$password = 'password';
$hash = Hash::make($password);

echo "Password: $password\n";
echo "Hash: $hash\n";
