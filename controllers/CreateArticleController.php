<?php
require_once '../config/db_connect.php';
require_once '../models/Article.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $user_id = $_POST['id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    if (isset($_FILES['image'])) {
        $image = $_FILES['image'];
        $imageFileName = $_FILES['image']['name'];
        $imageFileType = strtolower(pathinfo($imageFileName, PATHINFO_EXTENSION));
        $targetDirectory = "../public/uploads/";
        $targetFile = $targetDirectory . uniqid() . '.' . $imageFileType;
        $validImageTypes = array("jpg", "jpeg", "png");
        if (in_array($imageFileType, $validImageTypes)) {
            move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile);
            $sql = "INSERT INTO articles (image, title, description, user_id) VALUES (:image, :title, :description, :user_id)";
            $stmt = $conn->prepare($sql);
            $result = $stmt->execute([
                ':image' => $targetFile,
                ':title' => $title,
                ':description' => $description,
                ':user_id' => $user_id
            ]);
            if ($result) {
                header("Location: http://localhost:8000/tugas-akhir/views/user/profile.php");
            } else {
                echo "Blog gagal dibuat!";
            }
        } else {
            echo "Format gambar tidak valid. Hanya file JPG, JPEG, dan PNG yang diperbolehkan.";
        }
    } else {
        echo "Gambar wajib diunggah.";
    }
}
