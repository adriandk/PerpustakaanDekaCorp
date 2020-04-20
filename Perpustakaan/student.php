<?php
    require_once("config.php");
    $sql = "SELECT buku.judul, buku.qty, buku.penulis, buku.sinopsis, kategori.kategoriBuku, penerbit.nama from buku, kategori, penerbit where buku.idKategori = kategori.idKategori AND buku.idPenerbit = penerbit.idPenerbit";
?>
<!-- ini udah -->
<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset='utf-8'>
    <title>Student</title>
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
            <a class="navbar-brand" href="index.html"><img src="assets/images/thor.png" style="width: 60px; height: 30px;"></a>
        </ul>
      </nav>
      <div class="container">
            <table class="table mt-5">
                <tr>
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
                    <th scope="col" style='width: 40%;'>Sinopsis</th>
                    <th scope="col" style='width: 10%;'>Kategori</th>
                    <th scope="col" style='width: 10%;'>Jumlah Buku</th>
                </tr>
                    <?php

                    if (isset($_POST['searchbtn'])) {
                        $search = $_POST['search'];
                        if (empty($search)) {
                            $sql = "SELECT buku.judul, buku.qty, buku.penulis, buku.sinopsis, kategori.kategoriBuku, penerbit.nama from buku, kategori, penerbit where buku.idKategori = kategori.idKategori AND buku.idPenerbit = penerbit.idPenerbit";
                        }
                        else {
                            $sql = "SELECT buku.judul, buku.qty, buku.penulis, buku.sinopsis, kategori.kategoriBuku, penerbit.nama from buku, kategori, penerbit where buku.idKategori = kategori.idKategori AND buku.idPenerbit = penerbit.idPenerbit AND buku.judul LIKE '%$search%'";   
                        }
                    }

                    $query = $dbConn->prepare($sql);
                    $query->execute();
                    
                    while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                        echo "<tr class='thead-light' style = 'color: white;'>";
                        echo "<td scope='col' style='width: 10%;'>".$row['judul']."</td>";
                        echo "<td scope='col' style='width: 10%;'>".$row['penulis']."</td>";
                        echo "<td scope='col' style='width: 10%;'>".$row['nama']."</td>";
                        echo "<td scope='col' style='width: 40%;'>".$row['sinopsis']."</td>";
                        echo "<td scope='col' style='width: 10%;'>".$row['kategoriBuku']."</td>";
                        echo "<td scope='col' style='text-align:center'>".$row['qty']."</td>";
                    }

                    ?>
            </table>
        </div>
</body>
</html>