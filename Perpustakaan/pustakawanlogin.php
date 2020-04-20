<?php
    require_once("config.php");
?>
<!-- ini udah -->
<html>
<head>
    <meta charset='utf-8'>
    <title>Deka.tech Library</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='assets/css/bootstrap.css'>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <link rel="shortcut icon" href="assets/images/wddetail.jpg" type="image/x-icon">

</head>
<body
    style="background-image: url('assets/images/wddetail.jpg'); background-size: 100%; background-repeat: no-repeat; background-blend-mode: overlay;"
    class="bg-dark">
    <div class="container">
        <center>
            <div class="card" style="width: 30rem; height: 450px; margin-top: 100px; border-radius: 30px;">
                <div class="card-body">
                    <img src="assets/images/thor.png" class="card-img-top" style="width: 220px; height: 120px; border-radius: 30px">
                    <h5 class="card-title" style="margin-top: 20px;">Login</h5>
                    <form action="" method="POST">
                        <input type="text" name="username" required class="form-control" placeholder="Enter your username">
                        <input type="password" name="password" required class="form-control" placeholder="Enter your password" style="margin-top: 20px;">
                        <input class="btn btn-primary m-4" type="submit" value="Login" name="login" style="border-radius: 10px;">
                    </form>
                </div>
        </center>
    </div>
    </div>
</body>
</html>
<?php
    if (isset($_POST['login'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        $query = $dbConn->prepare("SELECT * FROM login where username =:user AND password =:pwd");
        $query->execute(array(':user'=>$username, ':pwd'=>$password));
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $hakuser = $row['hakUser'];
        if ($query->rowCount() > 0) {
            if ($hakuser == "admin") {
                session_start();
                $_SESSION['username'] = $row['username'];
                $_SESSION['hak'] = $hakuser;
                $_SESSION['id'] = $row['idPustakawan'];
                header("Location: admin.php");
            }
            elseif ($hakuser == "pustakawan") {
                session_start();
                $_SESSION['username'] = $row['username'];
                $_SESSION['hak'] = $hakuser;
                $_SESSION['id'] = $row['idPustakawan'];
                header("Location: librarian.php");
            }
            else {
                log("Gada");
            }

           
        }
    }
?>