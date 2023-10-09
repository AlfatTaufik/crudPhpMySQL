<?php
require_once '../config/db_connect.php';
require_once '../models/User.php';
require_once '../models/Article.php';
require_once '../controllers/UserController.php';

if (!$_SESSION['token']) {
    header('Location: login.php');
} else {

    $datas = getAll("WHERE token=" . $_SESSION['token']);
    foreach ($datas as $data) {
        $username = $data['name'];
        $token = $data['token'];
        $id = $data['id'];
    }
    $articles = articles();
    $allArticles = allArticles();

    if (isset($_POST['logout'])) {
        logout($token);
        header('Location: ' . auth());
    }
    if (isset($_POST['profile'])) {
        header('Location: user/create.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Homepage</title>
    <link rel="stylesheet" href="../public/src/css/bootstrap.min.css">
</head>

<body>
    <nav>
        <div class="d-flex flex-row mb-3 justify-content-between px-4 py-4">
            <div>
                <h1>Detail</h1>
            </div>
            <div class="d-flex flex-row gap-2">
                <form action="index.php" method="POST">
                    <input type="hidden" name="id" value="<?= $id ?>">
                    <button type="submit" name="home" class="btn btn-primary">Home</button>
                </form>
                <form action="" method="POST">
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <div class="d-flex align-items-center">
        <div class="d-flex flex-wrap text-center justify-content-center" style="margin: 25px 170px;">
            <?php
            foreach ($allArticles as $allArticle) :
                if ($allArticle['id'] == $_GET['id']) :
                    // var_dump($allArticl  e['title']);
            ?>
                    <div class="d-flex bg-dark-subtle px-5 py-3 rounded-4 position-relative" style="width: 1000px;">
                        <div class="">
                            <img src="<?= $allArticle['image'] ?>" alt="" style="width: 400px; height: 400px">
                        </div>
                        <div class="" style="margin: 0 20px">
                            <h1><?= $allArticle['title'] ?></h1>
                            <p class="" style="margin: 10px 0"><?= $allArticle['description'] ?></p>
                        </div>
                        <div class="position-absolute bottom-0 end-0 px-5">
                            <p><?= $allArticle['timeUpload'] ?></p>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>


</body>

</html>