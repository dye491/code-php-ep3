<?php

function get_pet(int $id)
{
    $pdo = get_connection();
    $sql = 'SELECT * FROM pet WHERE id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch();
}

function get_pets(?int $limit = null)
{
    $pdo = get_connection();
    $sql = 'SELECT * FROM pet';
    if ($limit != 0) {
        $sql .= ' LIMIT :limit';
    }

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam('limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll();
}

function save_pets($petsToSave)
{
    $json = json_encode($petsToSave, JSON_PRETTY_PRINT);
    file_put_contents('data/pets.json', $json);
}

function create_connection(string $dsn, string $username, string $password): PDO
{
    return new PDO($dsn, $username, $password);
}

function get_dsn_string(string $driver, string $hostname, int $port, ?string $db_name = null): string
{
    $dsn = sprintf('%s:host=%s;port=%s', $driver, $hostname, $port);

    if (isset($db_name)) {
        $dsn .= sprintf(';dbname=%s', $db_name);
    }

    return $dsn;
}

function get_driver(array $database): string
{
    return $database['driver'] ?? 'mysql';
}

function get_hostname(array $database): string
{
    return $database['hostname'] ?? '127.0.0.1';
}

function get_port(array $database): int
{
    return $database['port'] ?? 3306;
}

function get_username(array $database): string
{
    return $database['username'] ?? 'root';
}

function get_password(array $database): string
{
    return $database['password'] ?? '';
}

function get_dbname(array $database): string
{
    return $database['db_name'] ?? 'air_pup';
}

function get_connection(): PDO
{
    $config = require 'config.php';
    $database = $config['database'];
    $dsn = get_dsn_string(get_driver($database), get_hostname($database), get_port($database), get_dbname($database));

    return create_connection($dsn, get_username($database), get_password($database));
}

function insert_pet(PDO $conn, array $petData)
{
    $sql = 'INSERT INTO pet(name, breed, age, weight, bio, image) VALUES(:name, :breed, :age, :weight, :bio, :image)';
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':name', $petData['name']);
    $stmt->bindValue(':breed', $petData['breed']);
    $stmt->bindValue(':age', $petData['age'] ?? null);
    $stmt->bindValue(':weight', $petData['weight'] ?? null);
    $stmt->bindValue(':bio', $petData['bio'] ?? null);
    $stmt->bindValue(':image', $petData['image'] ?? null);
    $stmt->execute();
}
