<?php

require './lib/functions.php';

$conn = get_connection();

create_table($conn);

function create_table(PDO $conn)
{
    $sql = <<<SQL
CREATE TABLE pet(
    id int(11) AUTO_INCREMENT,
    name varchar(255),
    breed varchar (100),
    age varchar(100),
    weight smallint,
    bio varchar(255),
    image varchar(255),
    PRIMARY KEY (id)
) ENGINE=InnoDB;
SQL;

    return $conn->exec($sql);
}

