<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Database;

try {
    $db = Database::getInstance();
    
    // Читаем SQL файл
    $sql = file_get_contents(__DIR__ . '/database.sql');
    
    // Выполняем SQL
    $db->query($sql);
    
    echo "Database installed successfully!\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
