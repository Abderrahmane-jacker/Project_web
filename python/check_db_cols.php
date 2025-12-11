<?php
require 'app/config/database.php';
try {
    $stmt = $pdo->query("DESCRIBE inscriptions");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach($columns as $col) { echo $col . "\n"; }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
