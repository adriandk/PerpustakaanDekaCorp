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
    $sql = "SELECT buku.idBuku, buku.judul, buku.penulis, buku.sinopsis, kategori.kategoriBuku, penerbit.nama from buku, kategori, penerbit where buku.idKategori = kategori.idKategori AND buku.idPenerbit = penerbit.idPenerbit";
?>
<!-- ini belum -->
<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset='utf-8'>
    <title>Edit Buku</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' href='assets/css/bootstrap.css'>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/popper.js"></script>
    <script src="assets/js/bootstrap.js"></script>
    <link rel="shortcut icon" href="assets/images/wddetail.jpg" type="image/x-icon">
</head>
<body class="h-100 bg-dark"  style="background-image: url('assets/images/wddetail.jpg'); background-size: 100%; background-blend-mode: overlay;">
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
      </nav>
      <div class="container">
            <table class="table mt-5">
                <tr>
                    <td>
                        <a  href="addbuku.php" class="btn btn-primary">Add</a>
                    </td>

                    <td colspan="6" align="right">
                        <form method = "POST" class="form-inline">
                            <div class="form-group ml-auto mr-2">
                                <input type="text" name="search" class="form-control" name="searchbook" placeholder="Search by Judul">
                            </div>
                            
                            <button type="submit" name="searchbtn" class="btn btn-primary">Search</button>
                        </form>
                    </td>
                </tr>

                <tr class="thead-dark">
                    <th scope="col" style='width: 10%;'>Judul</th>
                    <th scope="col" style='width: 10%;'>Penulis</th>
                    <th scope="col" style='width: 10%;'>Penerbit</th>
                    <th scope="col" style='width: 10%;'>Sinopsis</th>
                    <th scope="col" style='width: 10%;'>Kategori</th>
                    <th scope="col" style="text-align: center;">Action</th>
                </tr>
                    <?php

                    if (isset($_POST['searchbtn'])) {
                        $search = $_POST['search'];
                        if (empty($search)) {
                            $sql = "SELECT buku.idBuku, buku.judul, buku.penulis, buku.sinopsis, kategori.kategoriBuku, penerbit.nama from buku, kategori, penerbit where buku.idKategori = kategori.idKategori AND buku.idPenerbit = penerbit.idPenerbit";
                        }
                        else {
                            $sql = "SELECT buku.idBuku, buku.judul, buku.penulis, buku.sinopsis, kategori.kategoriBuku, penerbit.nama from buku, kategori, penerbit where buku.idKategori = kategori.idKategori AND buku.idPenerbit = penerbit.idPenerbit AND buku.judul LIKE '%$search%'";   
                        }
                    }

                    $query = $dbConn->prepare($sql);
                    $query->execute();
                    
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr class='thead-light' style = 'color: white;'>";
                        echo "<td scope='col' style='width: 10%;'>".$row['judul']."</td>";
                        echo "<td scope='col' style='width: 10%;'>".$row['penulis']."</td>";
                        echo "<td scope='col' style='width: 10%;'>".$row['nama']."</td>";
                        echo "<td scope='col' style='width: 50%;'>".$row['sinopsis']."</td>";
                        echo "<td scope='col' style='width: 10%;'>".$row['kategoriBuku']."</td>";
                        echo "<td scope='col' style='text-align: center;'>
                        <a href =\"editdatabuku.php?id=$row[idBuku]\"><img src='assets/images/edit.png' style='width: 30px; height: 30px;'></a> &nbsp;
                        <a href =\"deletebuku.php?id=$row[idBuku]\" onClick =\"return confirm ('Are You Sure?')\"><img src='assets/images/hapus.png' style='width: 30px; height: 30px;'></a></td>";
                    }

                    ?>
            </table>
        </div>
</body>
</html>