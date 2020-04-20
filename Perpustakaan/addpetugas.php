<?php
    require_once("config.php");
    session_start();
    $hak = $_SESSION['hak'];
    $queryadm = $dbConn->prepare("SELECT MAX(idPustakawan DIV 1) as id from pustakawan");
    $queryadm->execute();
    $rowidadm = $queryadm->fetch(PDO::FETCH_ASSOC);
    $idadm = $rowidadm['id'];

?>
<a href="editpetugas.php" class="btn btn-primary">Back</a>

<form action="" method="POST" enctype="multipart/form-data">
    <img id = "gambar" height = "300px" width = "250px"> <br>
    <input accept="images/*" type = "file" name = "imagepustakawan" onchange = "document.getElementById('gambar').src = window.URL.createObjectURL(this.files[0])"> <br>
    <input type="text" name="addnama" placeholder="Nama"><br>
    <input type="text" name="addalamat" placeholder="Alamat"><br>
    <input type="text" name="addphone" placeholder="No HP"><br>
    <input type="email" name="addemail" placeholder="Email"><br>
    <input type="text" name="addusername" placeholder="Username"><br>
    <input type="password" name="addpass" placeholder="Password"><br>
    <select name="hakpetugas">
        <option value="admin">Admin</option>
        <option value="pustakawan">Pustakawan</option>
    </select>
    <br>
    <input type="submit" value="add" name="addbtn">
</form>

<?php
    if (isset($_POST['addbtn'])) {
        try {
            $editnama = $_POST['addnama'];
            $editalamat = $_POST['addalamat'];
            $editphone = $_POST['addphone'];
            $editemail = $_POST['addemail'];
            $editusername = $_POST['addusername'];
            $editpass = $_POST['addpass'];
            $hakpetugas = $_POST['hakpetugas'];
            $image = $_FILES['imagepustakawan']['name'];
            $type = $_FILES['imagepustakawan']['type'];
            $size = $_FILES['imagepustakawan']['size'];
            $temp = $_FILES['imagepustakawan']['tmp_name'];
            $path = "imagepetugas/".$image; 
    
            $idpetugas = ++$idadm;
    
            if (empty($editnama) || empty($editalamat) || empty($editphone) || empty($editemail) || empty($editusername) || empty($editpass) || empty($image)) {
                $error = "error";
            }
            else {
                if (!file_exists($path)) {
                    move_uploaded_file($temp, "imagepetugas/".$image);
                }
                else {
                    $error = "Sudah Ada";
                    echo "<script> alert('Sudah ada data itu') </script>";
                }
            }
    
            if (!isset($error)) {
                $querylogin = $dbConn->prepare("INSERT INTO login (idPustakawan, username, password, hakUser) values(:id,:username,:pass,:hakuser)");
                $querylogin->execute(array(':id'=>$idpetugas, ':username'=>$editusername, ':pass'=>$editpass, ':hakuser'=>$hakpetugas));
    
                $querypustakawan = $dbConn->prepare("INSERT INTO pustakawan (idPustakawan, nama, alamat, phone, email, image) values(:id, :name, :alamat, :phone, :email, :image)");
                $querypustakawan->execute(array(':id'=>$idpetugas, ':name'=>$editnama, ':alamat'=>$editalamat, ':phone'=>$editphone, ':email'=>$editemail, ':image'=>$image));
                
                header("Location: editpetugas.php");
            }
        } catch (PDOException $th) {
            //throw $th;
        }
        header("Location: editpetugas.php");
    }
?>