<?php

declare(strict_types=1);

$dbPath = __DIR__ . '/../database/database.sqlite';
$schemaPath = __DIR__ . '/../database/schema.sql';
$seedPath = __DIR__ . '/../database/seed.sql';

if (file_exists($dbPath)) {
    unlink($dbPath);
}

$pdo = new PDO('sqlite:' . $dbPath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$schema = file_get_contents($schemaPath);
$pdo->exec($schema);

if (file_exists($seedPath)) {
    $seed = file_get_contents($seedPath);
    $pdo->exec($seed);
}

echo "Base de datos inicializada con exito en {$dbPath}\n";
