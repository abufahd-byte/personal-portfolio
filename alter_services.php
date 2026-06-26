<?php
require 'config/config.php';
try {
    $pdo->exec("ALTER TABLE services ADD COLUMN image VARCHAR(255) NULL AFTER description_ar");
    echo "Column 'image' added successfully.\n";
} catch (PDOException $e) {
    if ($e->getCode() == '42S21') { // Duplicate column
        echo "Column 'image' already exists.\n";
    } else {
        echo "Error: " . $e->getMessage() . "\n";
    }
}
