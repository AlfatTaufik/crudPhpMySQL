<?php
function articles($condition = null)
{
    global $conn;
    $query = "SELECT * FROM articles ";
    $sql = $conn->prepare($query . $condition);
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}

function allArticles($condition = null)
{
    global $conn;
    $query = "SELECT articles.id, articles.image, users.name, articles.description, articles.title, users.image as userImage, articles.created_at as timeUpload FROM articles INNER JOIN users ON users.id = articles.user_id;";
    $sql = $conn->prepare($query . $condition);
    $sql->execute();
    $allArticles = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $allArticles;
}
