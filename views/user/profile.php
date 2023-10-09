<?php
require_once '../../config/db_connect.php';
require_once '../../models/User.php';
require_once '../../models/Article.php';
require_once '../../controllers/UserController.php';

if (!$_SESSION['token']) {
    header('Location: ../login.php');
} else {
    $datas = getAll("WHERE token={$_SESSION['token']}");
    foreach ($datas as $data) {
        $username = $data['name'];
        $password = $data['password'];
        $id = $data['id'];
        $photoProfile = $data['image'];
        $token = $data['token'];
    }
    // Halaman saat ini (misalnya, dari URL)
    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    // Hitung offset
    $items_per_page = 5;
    $offset = ($current_page - 1) * $items_per_page;
    // Query untuk mengambil data
    $articles = articles("WHERE user_id=$id ORDER BY id DESC LIMIT $offset, $items_per_page");

    if (isset($_POST['logout'])) {
        logout($token);
        header('Location: ../' . auth());
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="../../public/src/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
</head>

<body>
    <nav>
        <div class="d-flex flex-row mb-3 justify-content-between px-4 py-2">
            <div class="d-flex justify-content-between px-2 grid gap-3" style="width:170px;">
                <div class="pl-2">
                    <img src="../<?= $photoProfile ?>" alt="" height="50px" width="50px">
                </div>
                <div>
                    <h1><?= $username ?></h1>
                </div>
            </div>
            <div class="d-flex flex-row gap-2">
                <form action="../index.php" method="POST">
                    <button type="submit" name="home" class="btn btn-primary">Home</button>
                </form>
                <button type="button" name="edit" class="btn btn-warning" height="38px" data-bs-target="#editModalUser<?= $id ?>" data-bs-toggle="modal">Edit</button>
                <form action="" method="POST">
                    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <button type="button" class="btn btn-primary mx-3 px-3 py-2 mb-2" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
    <div class="mt-3">
        <table class="table px-auto">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Image</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $iteration = 1;
                foreach ($articles as $article) :
                ?>
                    <tr class="text-center">
                        <th scope="row"><?= $iteration++ ?></th>
                        <td class="">
                            <img src="../<?= $article['image'] ?>" alt="" class="object-fit-content" height="100px" width="100px">
                        </td>
                        <td><?= $article['title'] ?></td>
                        <td><?= $article['description'] ?></td>
                        <td>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $article['id'] ?>">Edit</button>
                            <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#hapusModal<?= $article['id'] ?>">Hapus</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- modal create -->
    <div class="modal fade" id="createModal" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../controllers/CreateArticleController.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Title:</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-3">
                            <label for="description" class="col-form-label">Description:</label>
                            <textarea class="form-control" id="description" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal create -->

    <!-- modal edit -->
    <?php
    foreach ($articles as $article) :
        $idArticle = $article['id'];
    ?>
        <div class="modal fade" id="editModal<?= $article['id'] ?>" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../../controllers/EditArticleController.php" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="id" value="<?= $id ?>">
                            <input type="hidden" name='idArticle' value="<?= $idArticle ?>">

                            <div class="form-group mb-3">
                                <label for="title" class="col-form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?= $article['title'] ?>">
                            </div>
                            <div class="form-group mb-3">
                                <label for="description" class="col-form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description"><?= $article['description'] ?></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="image" class="col-form-label">Image:</label>
                                <input type="file" name="image" id="image" class="form-control" src="<?= $article['image'] ?>">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" name="submit">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- end modal edit -->

    <!-- modal delete -->
    <?php
    foreach ($articles as $article) :
        $idArticle = $article['id'];
    ?>
        <div class="modal fade" id="hapusModal<?= $article['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Deleted Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h1>Yakin Hapus article ini ?</h1>
                    </div>
                    <div class="modal-footer">
                        <form action="../../controllers/DeleteArticleController.php" method="POST">
                            <input type="hidden" name="idArticle" value="<?= $article['id'] ?>">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <!-- end modal delete -->

    <!-- modal edit user -->
    <div class="modal fade" id="editModalUser<?= $id ?>" tabindex="-1" aria-labelledby="createModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">New message</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../controllers/EditUserController.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?= $id ?>">
                        <input type="hidden" name='idArticle' value="<?= $idArticle ?>">

                        <div class="mb-3">
                            <label for="title" class="col-form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" value="<?= $username ?>">
                        </div>
                        <div class="mb-3">
                            <label for="title" class="col-form-label">Password:</label>
                            <input type="text" class="form-control" id="password" name="password" value="<?= $password ?>">
                        </div>
                        <div class="mb-3">
                            <label for="image" class="col-form-label">Image:</label>
                            <input type="file" name="image" id="image" class="form-control" value="<?= $photoProfile ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="submit">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal edit user -->

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
                    <li class="page-item"><a class="page-link" href="profile.php?page=<?= $page ?>"><?= $page ?></a></li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
    <!-- end pagination -->

</body>

</html>