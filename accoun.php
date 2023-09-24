<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="./layout/nav.css">
    <title>Document</title>
</head>
<?php
require_once('./layout/navadimn.php');
?>
<div class="container">

    <body>

        <h3>Thêm Tài khoản</h3>
        <form action="accoun.php" method="post">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputEmail4">Họ và tên</label>
                    <input type="text" class="form-control" id="inputEmail4" placeholder="Ho va tên" name="username">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">Password</label>
                    <input type="password" class="form-control" id="passwword" placeholder="Password" name="password">
                </div>
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress">Email</label>
                <input type="email" class="form-control" id="inputAddress" placeholder="email" name="email">
            </div>



            <button name="dangki" class="btn btn-primary">Thêm</button>
        </form>



        <!-- <form action="accoun.php" method="post">
        <h3>Thêm user</h3>

        <label for="usname">Nhập tên của bạn: </label>
        <input type="text" id="name" placeholder="Nhập tên của bạn" name="username"><br>
        <label for="password">Nhập mật khẩu của bạn: </label>
        <input type="password" id="password" placeholder="Nhập pass" name="password"><br>
        <label for="emai;">Nhập email của bạn: </label>
        <input type="email" id="email" placeholder="Nhập email" name="email"><br>
        <button name="dangki">Thêm Tài Khoản</button>

    </form  -->
    </body>

</html>

<?php
//nhúng file mysql
require_once("./ketnoi.php");
if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    /**
     * us -> not empty
     *  password => >6 ky tu
     *  email hop le
     */
    $errors = [];
    if (strlen($username) < 1) {
        $errors[] = "username not empty";
    }
    if (strlen($password) < 6) {
        $errors[] = "password not empty and > 6 ky tu";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "email invalid email format";
    }
    if (isset($connection) && count($errors) < 1) {
        // insert
        try {
            $sql = "INSERT INTO users(username, password, role, email) VALUES(:username, :password, :role, :email)";
            $statement = $connection->prepare($sql);
            // ma hoa mat khau
            if (
                $statement->execute([
                    // ':password' => password_hash($password, PASSWORD_DEFAULT),
                    // ':password' => password_hash($password, PASSWORD_DEFAULT),
                    ':password' => $password,
                    ':role' => 2,
                    ':username' => $username,
                    ":email" => $email
                ])
            ) {
                $message = 'tạo thành công';
                // header("Location: accoun.php");
                exit;
            } else {
                echo "not create success";
            }
        } catch (Exception $err) {
            echo $err->getMessage();
        }
    }
}
$sql = "SELECT * FROM users";
$statement = $connection->prepare($sql);
$statement->setFetchMode(PDO::FETCH_ASSOC);
$statement->execute();
?>
<table class="table table-striped"">
                <h3>Danh sách tìa khoản mới thêm</h3>
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>name</th>
                            <!-- <th>password</th> -->
                            <th>email</th>
                            <th>Role</th>
                        </tr>
                       
                    </thead>
<tbody>
    <?php foreach ($statement->fetchAll() as $users) { ?>
        <tr>
            <td>
                <?= $users['id'] ?>
            </td>
            <td>
                <?= $users['username'] ?>
            </td>
            <!-- <td>
                <!-- <?= $users['password'] ?> -->
            </td> 
            <td>
                <?= $users['email'] ?>
            </td>
            <td>
                <?= $users['role'] ?>
            </td>
            <td>
            <a style=" color: red" href="./xoatk.php?id=<?= $users['id'] ?>">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3"
            viewBox="0 0 16 16">
            <path
                d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z" />
        </svg>
        </a>
        <button><a href="capnhattk.php?id=<?= $users['id'] ?>">sửa</button>
        <!-- <button type="button" data-id="<?= $category['id'] ?>" data-name="<?= $category['name'] ?>" onclick="updateCat(<?= $category['id'] ?>,'<?= $category['name'] ?>')" class="btn btn-success edit-cat">edit</button> -->
        </td>
        </tr>

    <?php } ?>

    </tbody>
</table>
</div>
<?php
include_once('./layout/footer.php');
?>