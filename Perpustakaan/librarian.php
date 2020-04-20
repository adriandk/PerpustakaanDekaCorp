<?php
    session_start();
    $username = $_SESSION['username'];
    $hak = $_SESSION['hak'];
    $id = $_SESSION['id'];
    if ($hak != "pustakawan") {
        session_destroy();
        header("Location: index.html");
    }
?>
<!-- linknya -->
<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset='utf-8'>
    <title>Librarian</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='assets/css/bootstrap.css'>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <link rel="shortcut icon" href="assets/images/wddetail.jpg" type="image/x-icon">
</head>
<body class="h-100 bg-dark"  style="background-image: url('assets/images/wddetail.jpg'); background-size: 100%; background-repeat: no-repeat; background-blend-mode: overlay;">
    <nav class="navbar navbar-expand-sm bg-dark">
        <ul class="navbar-nav">
            <a class="navbar-brand" href="#"><img src="assets/images/thor.png" style="width: 60px; height: 30px;"></a>
        </ul>

        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link btn btn-outline-primary m-1" style="color: white;"> Hello, <?php echo $username;?> you are a librarian </a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-primary m-1" style="color: white;" href="editprofile.php">Edit Profile</a>
          </li>
          <li class="nav-item">
            <a class="nav-link btn btn-outline-danger m-1" style="color: white;" href="logout.php">Logout</a>
          </li>
        </ul>
      </nav>

    <div class="container h-100">
            <div class="row h-100 align-items-center" style="margin-top: -80px;">
                <div class="col">
                    <a class="btn btn-outline-light btn-block" href="editbuku.php">Edit data buku</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-light btn-block" href="transaksi.php">Transaksi</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-light btn-block" href="editpenerbit.php">Edit data penerbit</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-light btn-block" href="editmurid.php">Edit data murid</a>
                </div>
                <div class="col">
                    <a class="btn btn-outline-light btn-block" href="laporan.php">Laporan</a>
                </div>
            </div>
    </div>
</body>
</html>