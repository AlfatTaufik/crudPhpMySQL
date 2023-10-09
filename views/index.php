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
    // $articles = articles("WHERE user_id=$id ORDER BY id DESC");
    $allArticles = allArticles("WHERE user_id=$id ORDER BY id DESC");
    // var_dump($allArticles);

    if (isset($_POST['logout'])) {
        logout($token);
        header('Location: ' . auth());
    }
    if (isset($_POST['profile'])) {
        header('Location: user/create.php');
    }

    // Halaman saat ini (misalnya, dari URL)
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    // Hitung offset
    $items_per_page = 5;
    $offset = ($current_page - 1) * $items_per_page;
    // Query untuk mengambil data
    $articles = articles("WHERE user_id=$id ORDER BY id DESC LIMIT $offset, $items_per_page");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="slick/slick-theme.css" /> -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../public/src/css/styles.css">
    <title>AllBlog</title>
</head>

<body>
    <header>
        <a href="#" class="logo-wrapper td-none">
            <div><span> Al </span>lfat</div>
        </a>
        <nav>
            <ul class="navmenu">
                <li class="navitem"><a href="#port">Portfolio</a></li>
                <li class="navitem"><a href="#blog">Blog</a></li>
                <li class="navitem">
                    <a href="#">Best Article</a>
                    <ul class="dropdown">
                        <li><a href="#">Technologi</a></li>
                        <li><a href="#">Kesehatan</a></li>
                        <li>
                            <a href="#">Others</a>

                        </li>
                    </ul>
                </li>
                <li class="navitem">
                    <a href="#"><i class="fa-solid fa-user">Alfattn</i></a>
                    <ul class="dropdown">
                        <li><a href="../views/user/profile.php">Profile</a></li>
                        <form action="" method="POST">
                            <button type="submit" name="logout" class="btn btn-danger" style="opacity: 0;">Logout</button>
                        </form>
                    </ul>
                </li>
            </ul>
        </nav>
    </header>
    <div class="container mt-3" id="port">
        <div class="row">
            <!-- photo profile -->
            <div class="col-3 mt-5 ms-1 ps-1">
                <img class="img-fluid rounded-circle img-thumbnail" src="https://th.bing.com/th/id/OIP.h00Kd-BwXNTZZc2Mn35yqAHaHa?w=203&h=203&c=7&r=0&o=5&pid=1.7" alt="Foto Profil" />
            </div>
            <!-- introduction -->
            <div class="col-5 mt-5">
                <h2 class="text-dark">Alfat Taufik N</h2>
                <h6 class="text-muted mt-1">Student</h6>
                <!-- table usia dst -->
                <div>
                    <table class="table table-stripped col-12 mt-3">
                        <thead>
                            <tr>
                                <th scope="col">Usia</th>
                                <td class="text-secondary"> : 16 Tahun</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">Email</th>
                                <td class="text-secondary"> : alfatnurhidayatrevisi@gmail.com</td>
                            </tr>
                            <tr>
                                <th scope="row">Website</th>
                                <td class="text-secondary"> : jclothes.com</td>
                            </tr>
                            <tr>
                                <th scope="row">Phone Number</th>
                                <td class="text-secondary"> : 085942277317</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Menu abiut me -->
    <div class="row col-11 pt-4 mx-5">
        <h6>About me</h6>
        <p class="text-muted text-fluid">
            Halo, salam kenal. Saya Alfat Taufik Nurhidayat seorang pelajar di SMK N 1 Purwokerto jurusan Pengembangan Perangkat Lunak dan Gim
            Website ini saya buat untuk keperluan Kelas industri saya bersama crocodic.
            Tentunya masih banyak kekurangan yang harus saya perbaiki kedepannya
    </div>
    <!-- text alert-danger -->
    <div class="alert alert-success mx-5 ps-3 col-11">
        <table>
            <th>Keterampilan</th>
        </table>
        <ul>
            <li>PHP</li>
            <li>HTML</li>
            <li>CSS</li>
            <li>Bootstrap</li>
        </ul>
    </div>
    </div>
    </div>

    <!-- wrapper -->
    <div class="page-wrapper">
        <!-- slider -->
        <div class="post-slider" id="blog">
            <h1 class="slider-title">Trending Article</h1>
            <i class="fas fa-chevron-left prev"></i>
            <i class="fas fa-chevron-right next"></i>
            <div class="post-wrapper">
                <?php foreach ($allArticles as $allArticle) ?>
                <div class="post" style="width: 300px">
                    <img src="<?= $allArticle['image'] ?>" alt="post" class="slider-img">
                    <div class="post-info">
                        <h4><a href="single.php"><?= $allArticle['description'] ?></a></h4>
                        <i class="far fa-user"><?= $allArticle['name'] ?></i>
                        &nbsp;<i class="far fa-calendar"><?= $allArticle['timeUpload'] ?></i>
                    </div>
                </div>
            </div>
        </div>
        <!-- end slider -->
        <div class="content clearfix">
            <div class="main-content">
                <h1 class="recent-post-title">Recent Post</h1>
                <?php foreach ($articles as $article) : ?>
                    <div class="post">
                        <img src="<?= $article['image'] ?>" alt="" class="post-img">
                        <div class="post-preview">
                            <h2><a href="single.php"><?= $article['title'] ?></a></h2>
                            <div style="height: 100px" class="text-truncate">
                                <?= substr($article['description'], 0, 100); ?>
                                <?= strlen($article['description']) > 100 ? '...' : ''; ?>
                            </div>
                            &nbsp;
                            <i class="far calender">
                                <p>Sep, 8 23</p>
                            </i>
                            <div class>
                                <a href="detail.php?id" z9<?= $article['id'] ?> class="btn btn-outline-primary rounded-0 float-start"></a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- pagination -->
        <div>
            <nav aria-label="Page navigation example">
                <ul class="pagination flex justify-content-center">
                    <?php
                    $sql = "SELECT COUNT(`id`) FROM articles";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $jml_data = $stmt->fetch();
                    $total_items = $jml_data[0];
                    // Hitung jumlah halaman
                    $total_pages = ceil($total_items / $items_per_page);

                    for ($page = 1; $page <= $total_pages; $page++) :
                    ?>
                        <li class="page-item"><a class="page-link" href="index.php?page=<?= $page ?>"><?= $page ?></a></li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
        <!-- end pagination -->
    </div>
    <!-- fw slickslick -->
    <script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script>
        $('.post-wrapper').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2000,
            nextArrow: $('.next'),
            prevArrow: $('.prev')
        });
    </script>
</body>

</html>