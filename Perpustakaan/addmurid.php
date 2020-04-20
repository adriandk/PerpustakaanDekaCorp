<?php
    require_once("config.php");
    session_start();
    $hak = $_SESSION['hak'];
    $querynis = $dbConn->prepare("SELECT MAX(nis DIV 1) as nis from siswa");
    $querynis->execute();
    $rownis = $querynis->fetch(PDO::FETCH_ASSOC);
    $nis = $rownis['nis'];
?>
<a href="editmurid.php" class="btn btn-primary">Back</a><br>
<?php
    $nissiswa = ++$nis;
    echo "NIS : ";
    echo $nissiswa;
?>
<br>
<form action="" method="POST" enctype="multipart/form-data">
    <img id = "gambar" height = "300px" width = "250px"> <br>
    <input accept="images/*" type = "file" name = "imagesiswa" onchange = "document.getElementById('gambar').src = window.URL.createObjectURL(this.files[0])"> <br>
    <input type="text" name="addnama" placeholder="Nama"><br>
    <input type="text" name="addalamat" placeholder="Alamat"><br>
    <input type="text" name="addphone" placeholder="No HP"><br>
    <input type="email" name="addemail" placeholder="Email"><br>
    <select name="jurusan">
        <option value="RPL">RPL</option>
        <option value="SIJA">SIJA</option>
        <option value="IOP">IOP</option>
        <option value="EIND">EIND</option>
    </select>
    <select name="tingkat">
        <option value="X">X</option>
        <option value="XI">XI</option>
        <option value="XII">XII</option>
        <option value="XIII">XIII</option>
    </select>
    <select name="kelas">
        <option value="A">A</option>
        <option value="B">B</option>
        <option value="C">C</option>
        <option value="D">D</option>
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
            $editjurusan = $_POST['jurusan'];
            $editkelas = $_POST['kelas'];
            $edittingkat = $_POST['tingkat'];
            $image = $_FILES['imagesiswa']['name'];
            $type = $_FILES['imagesiswa']['type'];
            $size = $_FILES['imagesiswa']['size'];
            $temp = $_FILES['imagesiswa']['tmp_name'];
            $path = "imagesiswa/".$image;

            if (empty($editnama) || empty($editalamat) || empty($editphone) || empty($editemail) || empty($image)) {
                $error = "error";
            }
            else {
                if (!file_exists($path)) {
                    move_uploaded_file($temp, "imagesiswa/".$image);
                }
                else {
                    $error = "Sudah Ada";
                    echo "<script> alert('Sudah ada data itu') </script>";
                }
            }

            if (!isset($error)) {
                $queryinsert = $dbConn->prepare("INSERT INTO siswa (nis, nama, alamat, jurusan, tingkat, kelas,phone, email, image) VALUES(:nis, :nama, :alamat, :jurusan, :tingkat, :kelas, :phone, :email, :image)");
                $queryinsert->execute(array(':nis'=>$nissiswa,':nama'=>$editnama, ':alamat'=>$editalamat,':jurusan'=>$editjurusan,':tingkat'=>$edittingkat,':kelas'=>$editkelas,':phone'=>$editphone,':email'=>$editemail, ':image'=>$image));
                header("Location: editmurid.php");
            }
        } catch (PDOException $th) {
            //throw $th;
        }
        header("Location: editmurid.php");
    }
?>