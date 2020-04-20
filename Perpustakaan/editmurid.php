<?php
    require_once("config.php");
    $sql = "SELECT nis, nama, alamat, jurusan, kelas, tingkat from siswa";
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
?>
<!-- ini belum -->
<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset='utf-8'>
    <title>Edit Murid</title>
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
            <a class="navbar-brand" href=<?php echo $pindah; ?>><img src="assets/images/thor.png" style="width: 60px; height: 30px;"></a>
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
                        <a href="addmurid.php" class="btn btn-primary">Add</a>
                    </td>

                    <td colspan="5" align="right">
                        <form method = "POST" class="form-inline">
                            <div class="form-group ml-auto mr-2">
                                <input type="text" name="search" class="form-control" name="searchbook" placeholder="Search by Judul">
                            </div>
                            
                            <button type="submit" name="searchbtn" class="btn btn-primary">Search</button>
                        </form>
                    </td>
                </tr>

                <tr class="thead-dark">
                    <th scope="col" style="text-align: center;">NIS</th>
                    <th scope="col" style="text-align: center;">Nama</th>
                    <th scope="col" style="text-align: center;">Alamat</th>
                    <th scope="col" style="text-align: center;">Kelas</th>
                    <th scope="col" style="text-align: center;">Action</th>
                </tr>
                    <?php

                    if (isset($_POST['searchbtn'])) {
                        $search = $_POST['search'];
                        if (empty($search)) {
                            $sql = "SELECT nis, nama, alamat, jurusan, kelas from siswa";
                        }
                        else {
                            $sql = "SELECT nis, nama, alamat, jurusan, kelas from siswa where nama like'%$search%'";
                        }
                    }

                    $query = $dbConn->prepare($sql);
                    $query->execute();
                    
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        $kelas = $row['tingkat']." ".$row['jurusan']." ".$row['kelas'];
                        
                        echo "<tr class='thead-light' style = 'color: white;'>";
                        echo "<td scope='col' style='text-align: center;'>".$row['nis']."</td>";
                        echo "<td scope='col' style='text-align: center;'>".$row['nama']."</td>";
                        echo "<td scope='col' style='text-align: center;'>".$row['alamat']."</td>";
                        echo "<td scope='col' style='text-align: center;'>".$kelas."</td>";
                        echo "<td scope='col' style='text-align: center;'>
                        <a href =\"editdatamurid.php?nis=$row[nis]\"><img src='assets/images/edit.png' style='width: 30px; height: 30px;'></a> &nbsp;
                        <a href =\"deletemurid.php?nis=$row[nis]\" onClick =\"return confirm ('Are You Sure?')\"><img src='assets/images/hapus.png' style='width: 30px; height: 30px;'></a></td>";
                    }

                    ?>
            </table>
        </div>
</body>
</html>