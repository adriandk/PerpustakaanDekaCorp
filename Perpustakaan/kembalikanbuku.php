<?php
    require_once("config.php");
    session_start();
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    $idtransaksi = $_GET['id'];
    $kelas = $_GET['kelas'];
    $role = $_GET['stat'];

    if ($role == "balikin") {
        $pindah = "datapeminjaman.php";
    }
    else {
        $pindah = "laporan.php";
    }

    $query = $dbConn->prepare("SELECT *, buku.judul, buku.idBuku, siswa.nama from transaksi, detailtransaksi, buku, siswa where transaksi.idTransaksi = detailtransaksi.idTransaksi AND detailtransaksi.idBuku = buku.idBuku AND transaksi.nis = siswa.nis AND transaksi.idTransaksi = :idtransaksi");
    $query->execute(array(':idtransaksi'=>$idtransaksi));
    $row = $query->fetch(PDO::FETCH_ASSOC);
    $rowcount = $query->rowCount();
    date_default_timezone_set('Asia/Jakarta');
    $date = date('Y-m-d', time());

    $tanggalkembali = strtotime("+3 day", strtotime($row['tglPinjam']));
    $tglkembali = date('Y-m-d', $tanggalkembali);

    $pinjam = date_create($row['tglPinjam']);
    $kembali = date_create($date);
    $daysBorrowed = date_diff($pinjam, $kembali);

    if ($date > $tglkembali) {
        $pinjam = date_create($tglkembali);
        $kembali = date_create($date);
        $daysBorrowed = date_diff($pinjam, $kembali);
        $denda = 1000 * $daysBorrowed->format('%a%');
        // echo $denda;
    }
    else {
        $denda = "-";
    }
?>

<?php
    if (isset($_POST['kembali'])) {
        try {
            $nis = $row['nis'];
            $buku1 = $row['idBuku'];
            $stat = "1";
            if ($rowcount == 1) {
                $queryqty = $dbConn->prepare("SELECT qty from buku where idBuku =:idbuku");
                $queryqty->execute(array(':idbuku'=>$buku1));
                $rowqty = $queryqty->fetch(PDO::FETCH_ASSOC);
                $qty = $rowqty['qty'];

                echo $nis. "<br>";
                echo $buku1. "<br>";
                echo $denda. "<br>";

                $queryupdate = $dbConn->prepare("UPDATE detailtransaksi set tglKembali=:tglkembali, status=:stat where idTransaksi=:idtransaksi");
                $queryupdate->execute(array(':idtransaksi'=>$idtransaksi, ':tglkembali'=>$date, ':stat'=>$stat));

                $queryupdate = $dbConn->prepare("UPDATE buku set qty=:qty where idBuku=:idbuku");
                $queryupdate->execute(array(':qty'=>++$qty, ':idbuku'=>$buku1));
            }
            else {
                $buku2 = $idBuku2;
                
                $queryupdate = $dbConn->prepare("UPDATE detailtransaksi set tglKembali=:tglkembali, status=:stat where idTransaksi=:idtransaksi");
                $queryupdate->execute(array(':idtransaksi'=>$idtransaksi, ':tglkembali'=>$date, ':stat'=>$stat));
// buku1
                $queryqty = $dbConn->prepare("SELECT qty from buku where idBuku =:idbuku");
                $queryqty->execute(array(':idbuku'=>$buku1));
                $rowqty = $queryqty->fetch(PDO::FETCH_ASSOC);
                $qty = $rowqty['qty'];
                $queryupdate = $dbConn->prepare("UPDATE buku set qty=:qty where idBuku=:idbuku");
                $queryupdate->execute(array(':qty'=>++$qty,':idbuku'=>$buku1));
// buku2
                $queryqty = $dbConn->prepare("SELECT qty from buku where idBuku =:idbuku");
                $queryqty->execute(array(':idbuku'=>$buku2));
                $rowqty = $queryqty->fetch(PDO::FETCH_ASSOC);
                $qty = $rowqty['qty'];
                
                $queryupdate = $dbConn->prepare("UPDATE buku set qty=:qty where idBuku=:idbuku");
                $queryupdate->execute(array(':qty'=>++$qty, ':idbuku'=>$buku2));
            }
        } catch (PDOException $th) {
            //throw $th;
        }

        header("Location: datapeminjaman.php");
    
    }
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset='utf-8'>
    <title>Data pinjam</title>
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
            <div class="card" style="width: 30rem; height: 670px; margin-top: 10px; border-radius: 30px;">
                <div class="card-body">
                    <h5 class="card-title">Data Peminjaman</h5>
                    <form action="" method="POST">
                        <label for="" style=" float: left;">NIS</label>
                        <input type="text" class="form-control" value="<?php echo$row['nis']; ?>" disabled>
                        <label for="" style=" float: left;">Nama Siswa</label>
                        <input type="text" class="form-control" value="<?php echo$row['nama']; ?>" disabled>
                        <label for="" style=" float: left;">Kelas</label>
                        <input type="text" class="form-control" value="<?php echo$kelas ?>" disabled>
                        <label for="" style=" float: left;">Tanggal Pinjam</label>
                        <input type="text" class="form-control" value="<?php echo$row['tglPinjam'];?>" disabled>
                        <label for="" style=" float: left;">Buku pinjaman</label>
                        <?php
                            if ($rowcount == 1) {
                                echo "<input class='form-control' type='text' value='$row[judul]' disabled>";
                            }
                            else {
                                while ($row2 = $query->fetch(PDO::FETCH_ASSOC)) {
                                    $idBuku2 = $row2['idBuku'];
                                    echo "<input class='form-control' type='text' value='$row[judul]' disabled>";
                                    echo "<input class='form-control' style = 'margin-top: 5px;' type='text' value='$row2[judul]' disabled>";
                                }
                                
                            }
                        ?>
                        <label for="" style=" float: left;">Tanggal Kembali</label>
                        <input type="text" class="form-control" value="<?php echo$date;?>" disabled >
                        <label for="" style=" float: left;">Denda</label>
                        <input type="text" class="form-control" value="<?php echo$denda;?>" disabled>
                        <?php
                            if ($role == "balikin") {
                                echo "<input class = 'btn btn-primary m-4' type = 'submit' name = 'kembali' value = 'Kembalikan'> ";
                            }
                        ?>
                    </form>
                </div>
        </center>
    </div>
    </div>
</body>
</html>

