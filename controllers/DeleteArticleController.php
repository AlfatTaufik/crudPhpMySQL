<?php
require_once '../config/db_connect.php';
require_once '../models/Article.php';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $idArticle = $_POST['idArticle'];
    $sql = "DELETE FROM articles WHERE id=$idArticle";
    $stmt = $conn->prepare($sql);
    $result = $stmt->execute();

    $articles = articles();
    // hapus image
    foreach ($articles as $article) {
        $filepath = $article['image'];
    }

    // Cek apakah berkas ada sebelum dihapus
    if (file_exists($filepath)) {
        // Hapus berkas
        if (unlink($filepath)) {
            echo "Berkas '$filename' berhasil dihapus.";
        } else {
            echo "Terjadi kesalahan saat menghapus berkas.";
        }
    } else {
        echo "Berkas '$filename' tidak ditemukan.";
    }

    if ($result) {
        header("Location: http://localhost:8000/tugas-akhir/views/user/profile.php");
    } else {
        echo "Blog gagal dibuat!";
    }
}
