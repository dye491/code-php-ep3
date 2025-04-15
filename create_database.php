<?php

require './lib/functions.php';

$config = require './config.php';
$database = $config['database'] ?? [];

$dsn = get_dsn_string(get_driver($database), get_hostname($database), get_port($database));

$conn = create_connection($dsn, get_username($database), get_password($database));

create_db($conn, get_dbname($database));

function create_db(PDO $conn, string $dbname)
{
    $sql = sprintf('CREATE DATABASE %s;', $dbname);

    return $conn->exec($sql);
}

