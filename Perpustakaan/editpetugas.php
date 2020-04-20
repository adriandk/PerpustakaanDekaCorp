<?php
    require_once("config.php");
    session_start();
    $hak = $_SESSION['hak'];
    $username = $_SESSION['username'];
    if ($hak == "admin") {
        $pindah = "admin.php";
        $role = "an admin";
    }
    elseif ($hak == "pustakawan") {
        $pindah = "librarian.php";
        $role = "a librarian";
    }
    $sql = "SELECT pustakawan.idPustakawan, pustakawan.nama, pustakawan.email, pustakawan.alamat, pustakawan.phone, login.hakUser from pustakawan, login where pustakawan.idPustakawan = login.idPustakawan ";
?>
<!-- ini belum -->
<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset='utf-8'>
    <title>Edit Pustakawan</title>
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
            <a class="navbar-brand" href="admin.php"><img src="assets/images/thor.png" style="width: 60px; height: 30px;"></a>
        </ul>
        <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link btn btn-outline-primary m-1" style="color: white;"> Hello, <?php echo $username;?> you are <?php echo $role; ?> </a>
          </li>
        </ul>
      </nav>
      <div class="container">
            <table class="table mt-5">
                <tr>
                    <td>
                        <a  href="addpetugas.php" class="btn btn-primary">Add</a>
                    </td>

                    <td colspan="6" align="right">
                        <form method = "POST" class="form-inline">
                            <div class="form-group ml-auto mr-2">
                                <input type="text" name="search" class="form-control" name="searchpetugas" placeholder="Search by name">
                            </div>
                            <button type="submit" name="searchbtn" class="btn btn-primary">Search</button>
                        </form>
                    </td>
                </tr>

                <tr class="thead-dark">
                    <th scope="col" style="text-align: center;">Nama</th>
                    <th scope="col" style="text-align: center;">Alamat</th>
                    <th scope="col" style="text-align: center;">Email</th>
                    <th scope="col" style="text-align: center;">No HP</th>
                    <th scope="col" style="text-align: center;">Hak Akses</th>
                    <th scope="col" style="text-align: center;">Action</th>
                </tr>
                    <?php

                    if (isset($_POST['searchbtn'])) {
                        $search = $_POST['search'];
                        if (empty($search)) {
                            $sql = "SELECT pustakawan.idPustakawan, pustakawan.nama, pustakawan.email, pustakawan.alamat, pustakawan.phone, login.hakUser from pustakawan, login where pustakawan.idPustakawan = login.idPustakawan";
                        }
                        else {
                            $sql = "SELECT pustakawan.idPustakawan, pustakawan.nama, pustakawan.email, pustakawan.alamat, pustakawan.phone, login.hakUser from pustakawan, login where pustakawan.idPustakawan = login.idPustakawan AND pustakawan.nama like'%$search%'";   
                        }
                    }

                    $query = $dbConn->prepare($sql);
                    $query->execute();
                    
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr class='thead-light' style = 'color: white;'>";
                        echo "<td scope='col' style='text-align: center;'>".$row['nama']."</td>";
                        echo "<td scope='col' style='text-align: center;'>".$row['alamat']."</td>";
                        echo "<td scope='col' style='text-align: center;'>".$row['email']."</td>";
                        echo "<td scope='col' style='text-align: center;'>".$row['phone']."</td>";
                        echo "<td scope='col' style='text-align: center;'>".$row['hakUser']."</td>";
                        echo "<td scope='col' style='text-align: center;'>
                        <a href =\"editdatapetugas.php?id=$row[idPustakawan]\"><img src='assets/images/edit.png' style='width: 30px; height: 30px;'></a> &nbsp;
                        <a href =\"deletepetugas.php?id=$row[idPustakawan]\" onClick =\"return confirm ('Are You Sure?')\"><img src='assets/images/hapus.png' style='width: 30px; height: 30px;'></a></td>";
                    }

                    ?>
            </table>
        </div>
</body>
</html>