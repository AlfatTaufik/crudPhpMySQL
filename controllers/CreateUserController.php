<?php
require_once '../config/db_connect.php';
require_once '../models/User.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $name = $_POST['name'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, password) VALUES (:name, :password)";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute([
        ':name' => $name,
        ':password' => $password
    ]);
    if ($result) {
        header("Location: http://localhost:8000/tugas-akhir/views/login.php");
    } else {
        echo "Blog gagal dibuat!";
    }
}
