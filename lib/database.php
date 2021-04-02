<?php
declare(strict_types=1);

function db_connect(array $config) : mysqli
{
    $db = mysqli_connect(
        $config['host'],
        $config['username'],
        $config['password'],
        $config['database'],
        $config['port'] ?? 3306
    );

    if (mysqli_connect_errno()) {
        trigger_error("DB Error: " . mysqli_connect_error(), E_USER_ERROR);
    }

    mysqli_set_charset($db, $config['charset'] ?? 'utf8mb4');

    return $db;
}


function db_check_global($database)
{
    if (!isset($database) || ! $database instanceof mysqli) {
        trigger_error('The database-module requires a globally defined variable called $database that holds a MySQL/MariaDB connection (mysqli-Object). You can use db_connect() to establish this connection.', E_USER_ERROR);
    }

    return true;
}


function db_disconnect()
{
    global $database;

    if (! $database instanceof mysqli) {
        return false;
    }

    return mysqli_close($database);
}


function db_query(string $sql)
{
    global $database;
    db_check_global($database);

    $result = mysqli_query($database, $sql);

    if (mysqli_errno($database)) {
        trigger_error("DB ERROR: " . mysqli_error($database), E_USER_ERROR);
    }

    return $result;
}


function db_delete(string $table, $ids) : bool
{
    $ids = (array) $ids;

    $count = count($ids);
    for ($i = 0; $i < $count; $i++) {
        $ids[$i] = (int) $ids[$i];
    }

    $ids = implode(', ', $ids);

    $sql = "DELETE FROM `$table` WHERE `id` IN ($ids)";

    return db_query($sql);
}


function db_prepare($value) : string
{
    global $database;
    db_check_global($database);

    if (is_bool($value)) {
        return $value ? '1' : '0';
    }

    if ($value === 'NULL' || $value === 'null' || $value === null) {
        return 'NULL';
    }

    if (is_string($value)) {
        return "'" . mysqli_escape_string($database, $value) . "'";
    }

    return (string) $value;
}


function db_insert(string $table, array $data)
{
    global $database;
    db_check_global($database);

    $columns = [];
    $values = [];

    foreach ($data as $column => $value) {
        $columns[] = "`$column`";
        $values[] = db_prepare($value);
    }

    $columns = implode(', ', $columns);
    $values = implode(', ', $values);

    $sql = "INSERT INTO `$table` ($columns) VALUES ($values)";

    $success = db_query($sql);

    if ($success) {
        return mysqli_insert_id($database);
    }

    return false;
}


function db_update(string $table, int $id, array $data) : bool
{
    $pairs = [];

    foreach ($data as $column => $value) {
        $pairs[] = "`$column` = " . db_prepare($value);
    }

    $pairs = implode(', ', $pairs);

    $sql = "UPDATE `$table` SET $pairs WHERE `id` = $id";

    return db_query($sql);
}


function db_raw_select(string $sql)
{
    $result = db_query($sql);

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);

    mysqli_free_result($result);

    return $data;
}


function db_raw_first(string $sql)
{
    $result = db_query($sql);

    $data = mysqli_fetch_assoc($result);

    mysqli_free_result($result);

    return $data;
}
