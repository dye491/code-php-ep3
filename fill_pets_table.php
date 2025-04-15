<?php

require './lib/functions.php';

$conn = get_connection();
$pets = json_decode(file_get_contents('data/pets.json'), true);

if (!empty($pets)) {
    truncate_pets_table($conn);
    foreach ($pets as $pet) {
        insert_pet($conn, $pet);
    }
}

function truncate_pets_table(PDO $conn): void
{
    $conn->exec('TRUNCATE TABLE `pet`;');
}
