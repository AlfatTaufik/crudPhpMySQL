<?php
$dbname = 'tugas-akhir';
$host = 'localhost';
$username = 'root';
$pass = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;", $username, $pass);
} catch (PDOException $e) {
    echo 'error : ' . $e->getMessage();
}
