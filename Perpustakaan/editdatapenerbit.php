<?php
    require_once("config.php");
    session_start();
    $hak = $_SESSION['hak'];
    $id = $_GET['id'];

    $query = $dbConn->prepare("SELECT * FROM penerbit where idPenerbit=:id");
    $query->execute(array(':id'=>$id));
    $row = $query->fetch(PDO::FETCH_ASSOC);
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
                $queryupdate = $dbConn->prepare("UPDATE penerbit set nama=:nama, alamat=:alamat, phone=:nohp, email=:email where idPenerbit=:id");
                $queryupdate->execute(array(':id'=>$id, ':nama'=>$editnama, ':alamat'=>$editalamat, ':nohp'=>$editphone,':email'=>$editemail));
    
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
                    <h5 class="card-title">Edit Penerbit</h5>
                    <form action="" method="POST">
                        <label for="" style=" float: left;">Nama Penerbit</label>
                        <input type="text" value="<?php echo $row['nama']; ?>" name="addnama" required class="form-control" placeholder="Masukan Nama Penerbit">

                        <label for="" style="margin-top: 10px; float: left;">Alamat Penerbit</label>
                        <input type="text" value="<?php echo $row['alamat']; ?>" name="addalamat" required class="form-control" placeholder="Masukan Alamat Penerbit">

                        <label for="" style="margin-top: 10px;  float: left;">No Telepon</label>
                        <input type="text"  value="<?php echo $row['phone']; ?>" name="addphone" required class="form-control" placeholder="Masukan Nomor Telepon">

                        <label for="" style="margin-top: 10px; float: left;">Email Penerbit</label>
                        <input type="email" value="<?php echo $row['email']; ?>" name="addemail" required class="form-control" placeholder="Masukan Email Penerbit">

                        <input class="btn btn-primary m-4" type="submit" value="Edit" name="addbtn" style="border-radius: 10px; width: 80%;">
                    </form>
                </div>
        </center>
    </div>
    </div>
</body>
</html>