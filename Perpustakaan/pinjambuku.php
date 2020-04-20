<?php
    require_once("config.php");
    session_start();
    $id = $_SESSION['id'];
    $username = $_SESSION['username'];

    $queryidpinjam = $dbConn->prepare("SELECT MAX(idTransaksi DIV 1) as id from transaksi");
    $queryidpinjam->execute();
    $rowidpinjam = $queryidpinjam->fetch(PDO::FETCH_ASSOC);

    $querybuku = $dbConn->prepare("SELECT * FROM buku");
    $querybuku->execute();
    $querybuku2 = $dbConn->prepare("SELECT * FROM buku");
    $querybuku2->execute();
    $querysiswa = $dbConn->prepare("SELECT * FROM siswa");
    $querysiswa->execute();

    date_default_timezone_set('Asia/Jakarta');
    $date = date('Y-m-d', time());
?>

<?php
    if (isset($_POST['pinjam'])) {
        try {
            $pustakawan = $username;
            $nissiswa = $_POST['siswa'];
            $tanggal = $date;
            $buku1 = $_POST['buku1'];
            $buku2 = $_POST['buku2'];
            

            if ($rowidpinjam['id'] == NULL) {
                $idTransaksi = "1";
            }
            else {
                $idTransaksi = ++$rowidpinjam['id'];
            }

            // echo $idTransaksi;

            if ($buku2 == "optional") {
                // pinjam 1 buku
                $queryqty = $dbConn->prepare("SELECT qty from buku where idBuku =:idbuku");
                $queryqty->execute(array(':idbuku'=>$buku1));
                $rowqty = $queryqty->fetch(PDO::FETCH_ASSOC);
                $qty = $rowqty['qty'];

                if ($qty == "0") {
                    echo "KAMU GABISA MINJEM";
                }
                else {
                    // echo "OKE KAMU BISA MINJEM";
                    $query = $dbConn->prepare("INSERT INTO transaksi (idTransaksi, nis, idPustakawan, tglPinjam) values(:id, :nis, :idPus, :tgl)");
                    $query->execute(array(':id'=>$idTransaksi, ':nis'=>$nissiswa, ':idPus'=>$id, ':tgl'=>$tanggal));
        
                    $query = $dbConn->prepare("INSERT INTO detailtransaksi (idTransaksi, idBuku, status) values(:id, :idBuku, :status)");
                    $query->execute(array(':id'=>$idTransaksi, ':idBuku'=>$buku1, ':status'=>"0"));

                    $query = $dbConn->prepare("UPDATE buku set qty =:qty where idBuku =:idbuku");
                    $query->execute(array(':qty'=>--$qty, ':idbuku'=>$buku1));
                }


            }
            else {
                // pinjam buku ke 1
                $queryqty = $dbConn->prepare("SELECT qty from buku where idBuku =:idbuku");
                $queryqty->execute(array(':idbuku'=>$buku1));
                $rowqty = $queryqty->fetch(PDO::FETCH_ASSOC);
                $qty = $rowqty['qty'];

                $queryqty2 = $dbConn->prepare("SELECT qty from buku where idBuku =:idbuku");
                $queryqty2->execute(array(':idbuku'=>$buku2));
                $rowqty2 = $queryqty2->fetch(PDO::FETCH_ASSOC);
                $qty2 = $rowqty2['qty'];

                if ($qty == "0" || $qty2 == "0") {
                    echo "KAMU GABISA MINJEM";
                }
                else {
                    // echo "OKE KAMU BISA MINJEM";
                    $query = $dbConn->prepare("INSERT INTO transaksi (idTransaksi, nis, idPustakawan, tglPinjam) values(:id, :nis, :idPus, :tgl)");
                    $query->execute(array(':id'=>$idTransaksi, ':nis'=>$nissiswa, ':idPus'=>$id, ':tgl'=>$tanggal));
        
                    $query = $dbConn->prepare("INSERT INTO detailtransaksi (idTransaksi, idBuku, status) values(:id, :idBuku, :status)");
                    $query->execute(array(':id'=>$idTransaksi, ':idBuku'=>$buku1, ':status'=>"0"));

                    $query = $dbConn->prepare("UPDATE buku set qty =:qty where idBuku =:idbuku");
                    $query->execute(array(':qty'=>--$qty, ':idbuku'=>$buku1));

                    $query = $dbConn->prepare("INSERT INTO detailtransaksi (idTransaksi, idBuku, status) values(:id, :idBuku, :status)");
                    $query->execute(array(':id'=>$idTransaksi, ':idBuku'=>$buku2, ':status'=>"0"));

                    $query = $dbConn->prepare("UPDATE buku set qty =:qty where idBuku =:idbuku");
                    $query->execute(array(':qty'=>--$qty2, ':idbuku'=>$buku2));
                }
            }
            
        } catch (PDOException $error) {
            //throw $th;
        }
        header("Location: transaksi.php");
    }
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset='utf-8'>
    <title>Pinjam Buku</title>
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
            <div class="card" style="width: 30rem; height: 550px; margin-top: 50px; border-radius: 30px;">
                <div class="card-body">
                    <h5 class="card-title">Add Buku</h5>
                    <form action="" method="POST">
                        <label for="" style=" float: left;">Nama Pustakawan</label>
                        <input disabled value="<?php echo $username;?>" type="text" required class="form-control" placeholder="Enter your username">

                        <label class="my-1 mr-2" style="margin-top: 10px; float: left;" for="inlineFormCustomSelectPref">Nama Siswa</label>
                        <select name="siswa" class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                            <?php
                                while ($rowsiswa = $querysiswa->fetch(PDO::FETCH_ASSOC)) {
                            ?>        
                                <option value="<?php echo $rowsiswa['nis']; ?>"><?php echo $rowsiswa['nama']; ?></option>
                            <?php
                                }
                            ?>
                        </select>

                        <label for="" style="margin-top: 10px;  float: left;">Tanggal Pinjam</label>
                        <input disabled type="text" value="<?php echo$date;?>" name="tanggal" required class="form-control" placeholder="Enter your username">

                        <label class="my-1 mr-2" style="margin-top: 10px; float: left;" for="inlineFormCustomSelectPref">Buku 1</label>
                        <select name="buku1" class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                            <?php
                                while ($rowbuku = $querybuku->fetch(PDO::FETCH_ASSOC)) {
                            ?>        
                                <option value="<?php echo $rowbuku['idBuku']; ?>"><?php echo $rowbuku['judul']; ?></option>
                            <?php
                                }
                            ?>
                        </select>

                        <label class="my-1 mr-2" style="margin-top: 10px; float: left;" for="inlineFormCustomSelectPref">Buku 2</label>
                        <select name="buku2" class="custom-select my-1 mr-sm-2" id="inlineFormCustomSelectPref">
                            <option value="optional">OPTIONAL</option>
                            <?php
                                while ($rowbuku2 = $querybuku2->fetch(PDO::FETCH_ASSOC)) {
                            ?>        
                                <option value="<?php echo $rowbuku2['idBuku']; ?>"><?php echo $rowbuku2['judul']; ?></option>
                            <?php
                                }
                            ?>
                        </select>

                        <input class="btn btn-primary m-4"  type = "submit" name = "pinjam" value = "Pinjam" style="border-radius: 10px; width: 80%;">
                    </form>
                </div>
        </center>
    </div>
    </div>
</body>
</html>