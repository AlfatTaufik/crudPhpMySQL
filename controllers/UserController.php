<?php
// require_once '../config/db_connect.php';
// require_once '../models/User.php';
session_start();
// error_reporting(0);

function datas()
{
    $datas = getAll();
    for ($i = 0; $i < count($datas); $i++) {
    }
}

function auth()
{
    global $conn;

    $datas = getAll();
    $path = 'login.php';
    if (!$_SESSION['token']) {
        foreach ($datas as $data) {
            $name = $_POST['name'];
            $password = $_POST['password'];
            $sql = $conn->prepare("SELECT * FROM users WHERE name='$name' AND password='$password'");
            $sql->execute();
            $dataFix = $sql->fetch(PDO::FETCH_ASSOC);
            // var_dump($_POST['name'] != $dataFix['name']);
            // var_dump($_POST['password'] != $dataFix['password']);
            // var_dump(($dataFix['role_id'] == 1) && empty($dataFix['token']));
            // var_dump(($dataFix['role_id'] != 1) && empty($dataFix['token']));
            if (($_POST['name'] != $dataFix['name']) || ($_POST['password'] != $dataFix['password'])) {
                return $path  = 'login.php';
            } else {
                if ($dataFix != 1) {
                    if (($dataFix['role_id'] == 1) && empty($dataFix['token'])) {
                        $_SESSION['token'] = mt_rand(0000, 9999);
                        $query = "UPDATE users SET token={$_SESSION['token']}, status=1 WHERE id={$dataFix['id']}";
                        $sql = $conn->prepare($query);
                        $sql->execute();
                        return $path = 'admin/dashboard.php';
                    }
                    if (($dataFix['role_id'] == 2) && empty($dataFix['token'])) {
                        $_SESSION['token'] = mt_rand(0000, 9999);
                        $query = "UPDATE users SET token={$_SESSION['token']}, status=1 WHERE id={$dataFix['id']}";
                        $sql = $conn->prepare($query);
                        $sql->execute();
                        return $path = 'index.php';
                    }
                }
            }
        }
    }
    return $path;
}

function logout($token)
{
    global $conn;
    $datas = getAll();
    foreach ($datas as $data) {
        if (($_SESSION['token'] == $token) || $data['token']) {
            $query = "UPDATE users SET token=null, status=0 WHERE token=:token";
            $sql = $conn->prepare($query);
            $sql->execute([
                ':token' => $token
            ]);
            session_destroy();
        }
        return 'login.php';
    }
}

function upload()
{
    if (isset($_POST['submit'])) {
        $direktori = '../../src/uploads/';
        $filename = $_FILES['NamaFile']['name'];
    }
}

function makeRandomString($max = 6)
{
    $i = 0; //Reset the counter.
    $possible_keys = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $keys_length = strlen($possible_keys);
    $str = ""; //Let's declare the string, to add later.
    while ($i < $max) {
        $rand = mt_rand(1, $keys_length - 1);
        $str .= $possible_keys[$rand];
        $i++;
    }
    return $str;
}

function destroy($id)
{
    global $conn;
    $users = getAll("WHERE id=$id");
    foreach ($users as $user) {
        if ($user['status'] == 0) {
            $userId = $user['id'];
            $query = "DELETE FROM users WHERE id=:id";
            $sql = $conn->prepare($query);
            $sql->execute([
                ':id' => $userId
            ]);
        }
    }
}

function update()
{
    // UPDATE nama_tabel SET nama_kolom = data_baru WHERE kondisi
    global $conn;
    if ($_SESSION['token']) {
        $datas = getAll();
        for ($i = 0; $i < sizeof($datas); $i++) {
            $data = $datas[$i];
            $query = "UPDATE users SET image =':image', name=':name', password=':password' WHERE id=:id";
            $sql = $conn->prepare($query);
            $sql->execute([
                ':id' => $data['id'],
                ':name' => $_POST['name'],
                ':password' => $_POST['password'],
                ':image' => $_POST['image']
            ]);
        }
    }
}
