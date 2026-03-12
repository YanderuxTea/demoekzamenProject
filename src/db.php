<?php
$host = 'ekzamen-db-1';
$user = 'root';
$pass = 'root';
$dbname = 'DEMOEKZAMEN';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die('Ошибка подключения');
}
