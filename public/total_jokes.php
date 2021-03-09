<?php

include_once __DIR__ . '/../includes/DatabaseConnection.php';

include __DIR__ . '/../classes/DatabaseTable.php';

$jokesTable = new DatabaseTable($pdo, 'joke', 'id');

echo $jokesTable->total();