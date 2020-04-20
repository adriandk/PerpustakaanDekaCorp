<?php
    require_once("config.php");
    session_start();
    $hak = $_SESSION['hak'];
    $queryid = $dbConn->prepare("SELECT MAX(idPenerbit DIV 1) as id from penerbit");
    $queryid->execute();
    $rowid = $queryid->fetch(PDO::FETCH_ASSOC);
    $id = $rowid['id'];
    if($id == null){
        $idPenerbit = "1";
    }
    else {
        $idPenerbit = ++$id;
    }
?>


<?php
    if (isset($_POST['addbtn'])) {
        try {
            $editnama = $_POST['addnama'];
            $editalamat = $_POST['addalamat'];
            $editphone = $_POST['addphone'];
            $editemail = $_POST['addemail'];


            if (empty($editnama) || empty($editalamat) || empty($editphone) || empty($editemail)) {
                $error = "error";
            }
            if (!isset($error)) {
                $queryinsert = $dbConn->prepare("INSERT INTO penerbit (idPenerbit, nama, alamat, phone, email) values (:id, :nama, :alamat, :phone, :email)");
                $queryinsert->execute(array(':id'=>$idPenerbit,':nama'=>$editnama,':alamat'=>$editalamat,':phone'=>$editphone,':email'=>$editemail));
                header("Location: editpenerbit.php");
            }
        } catch (PDOException $th) {
            //throw $th;
        }
        header("Location: editpenerbit.php");
    }
?>

<!DOCTYPE html>
<html class="h-100">
<head>
    <meta charset='utf-8'>
    <title>Edit Penerbit</title>
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
                    <h5 class="card-title">Add Penerbit</h5>
                    <form action="" method="POST">
                        <label for="" style=" float: left;">Nama Penerbit</label>
                        <input type="text" name="addnama" required class="form-control" placeholder="Masukan Nama Penerbit">

                        <label for="" style="margin-top: 10px; float: left;">Alamat Penerbit</label>
                        <input type="text" name="addalamat" required class="form-control" placeholder="Masukan Alamat Penerbit">

                        <label for="" style="margin-top: 10px;  float: left;">No Telepon</label>
                        <input type="text" name="addphone" required class="form-control" placeholder="Masukan Nomor Telepon">

                        <label for="" style="margin-top: 10px; float: left;">Email Penerbit</label>
                        <input type="email" name="addemail" required class="form-control" placeholder="Masukan Email Penerbit">

                        <input class="btn btn-primary m-4" type="submit" value="Add" name="addbtn" style="border-radius: 10px; width: 80%;">
                    </form>
                </div>
        </center>
    </div>
    </div>
</body>
</html>
