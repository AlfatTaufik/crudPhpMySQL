<?php
function getAll($condition = null)
{
    global $conn;
    $query = "SELECT * FROM users ";
    $sql = $conn->prepare($query . $condition);
    $sql->execute();
    $data = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $data;
}
