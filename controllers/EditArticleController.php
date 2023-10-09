<?php
require_once "../config/db_connect.php";
$id = $_POST['idArticle'];
$title = $_POST['title'];
$description = $_POST['description'];
$image = $_FILES['image'];

// Periksa apakah ada file gambar yang diunggah 
if (!empty($image['name'])) {
    $extension = array("jpg", "jpeg", "png", "gif");
    $file_extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));

    if (!in_array($file_extension, $extension)) {
        die("Error: File yang diunggah harus berupa gambar (JPG, JPEG, PNG, atau GIF).");
    }

    $query = "SELECT image FROM articles WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    unlink("../public/uploads/" . $row['image']);
    $image_name = "../public/uploads/" . uniqid() . "." . $file_extension;
    $image_tmp = $image['tmp_name'];
    move_uploaded_file($image_tmp, $image_name);
} else {
    // Jika tidak ada gambar yang diunggah, pertahankan gambar yang ada di database 
    $query = "SELECT image FROM articles WHERE id = :id";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $image_name = $row['image'];
}

$sql = "UPDATE articles SET title = :title, description = :description, image = :image WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':title', $title);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':image', $image_name);
$stmt->bindParam(':id', $id);
$stmt->execute();
header("Location: http://localhost:8000/tugas-akhir/views/user/profile.php");
