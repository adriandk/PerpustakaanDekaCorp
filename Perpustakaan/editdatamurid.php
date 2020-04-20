<?php
    require_once("config.php");
    session_start();
    $hak = $_SESSION['hak'];
    $nis = $_GET['nis'];

    $query = $dbConn->prepare("SELECT * FROM siswa where nis=:nis");
    $query->execute(array(':nis'=>$nis));
    $row = $query->fetch(PDO::FETCH_ASSOC);
?>
<a href="editmurid.php" class="btn btn-primary">Back</a>

<form action="" method="POST" enctype="multipart/form-data">
    <img src="imagesiswa/<?php echo $row['image']; ?>" id = "gambar" height = "300px" width = "250px"> <br>
    <input accept="images/*" value="<?php echo $row['image']; ?>" type = "file" name = "imagepustakawan" onchange = "document.getElementById('gambar').src = window.URL.createObjectURL(this.files[0])"> <br>
    <input value="<?php echo $row['nama']; ?>" type="text" name="addnama" placeholder="Nama"><br>
    <input value="<?php echo $row['alamat']; ?>" type="text" name="addalamat" placeholder="Alamat"><br>
    <input value="<?php echo $row['phone']; ?>" type="text" name="addphone" placeholder="No HP"><br>
    <input value="<?php echo $row['email']; ?>" type="email" name="addemail" placeholder="Email"><br>
    <select name="jurusan">
        <?php
        if ($row['jurusan'] == "RPL") {
            echo "<option selected value = 'RPL'>RPL</option>";
            echo "<option value = 'SIJA'>SIJA</option>";
            echo "<option value = 'IOP'>IOP</option>";
            echo "<option value = 'EIND'>EIND</option>";
        }
        elseif ($row['jurusan'] == "SIJA") {
            echo "<option value = 'RPL'>RPL</option>";
            echo "<option selected value = 'SIJA'>SIJA</option>";
            echo "<option value = 'IOP'>IOP</option>";
            echo "<option value = 'EIND'>EIND</option>";
        }
        elseif ($row['jurusan'] == "IOP") {
            echo "<option value = 'RPL'>RPL</option>";
            echo "<option value = 'SIJA'>SIJA</option>";
            echo "<option selected value = 'IOP'>IOP</option>";
            echo "<option value = 'EIND'>EIND</option>";
        }
        elseif ($row['jurusan'] == "EIND") {
            echo "<option value = 'RPL'>RPL</option>";
            echo "<option value = 'SIJA'>SIJA</option>";
            echo "<option value = 'IOP'>IOP</option>";
            echo "<option selected value = 'EIND'>EIND</option>";
        }
        ?>
    </select>
    <select name="tingkat">
        <?php
        if ($row['tingkat'] == "X") {
            echo "<option selected value = 'X'>X</option>";
            echo "<option value = 'XI'>XI</option>";
            echo "<option value = 'XII'>XII</option>";
            echo "<option value = 'XIII'>XII</option>";
        }
        elseif ($row['tingkat'] == "XI") {
            echo "<option value = 'X'>X</option>";
            echo "<option selected value = 'XI'>XI</option>";
            echo "<option value = 'XII'>XII</option>";
            echo "<option value = 'XIII'>XII</option>";
        }
        elseif ($row['tingkat'] == "XII") {
            echo "<option value = 'X'>X</option>";
            echo "<option value = 'XI'>XI</option>";
            echo "<option selected value = 'XII'>XII</option>";
            echo "<option value = 'XIII'>XII</option>";
        }
        elseif ($row['tingkat'] == "XIII") {
            echo "<option value = 'X'>X</option>";
            echo "<option value = 'XI'>XI</option>";
            echo "<option value = 'XII'>XII</option>";
            echo "<option selected value = 'XIII'>XII</option>";
        }
        ?>
    </select>
    <select name="kelas">
        <?php
        if ($row['kelas'] == "A") {
            echo "<option selected value = 'A'>A</option>";
            echo "<option value = 'B'>B</option>";
            echo "<option value = 'C'>C</option>";
            echo "<option value = 'D'>D</option>";
        }
        elseif ($row['kelas'] == "B") {
            echo "<option value = 'A'>A</option>";
            echo "<option selected value = 'B'>B</option>";
            echo "<option value = 'C'>C</option>";
            echo "<option value = 'D'>D</option>";
        }
        elseif ($row['kelas'] == "C") {
            echo "<option value = 'A'>A</option>";
            echo "<option value = 'B'>B</option>";
            echo "<option selected value = 'C'>C</option>";
            echo "<option value = 'D'>D</option>";
        }
        elseif ($row['kelas'] == "D") {
            echo "<option value = 'A'>A</option>";
            echo "<option value = 'B'>B</option>";
            echo "<option value = 'C'>C</option>";
            echo "<option selected value = 'D'>D</option>";
        }
        ?>
    </select>
    <br>
    <input type="submit" value="edit" name="addbtn">
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
            $image = $_FILES['imagepustakawan']['name'];
            $type = $_FILES['imagepustakawan']['type'];
            $size = $_FILES['imagepustakawan']['size'];
            $temp = $_FILES['imagepustakawan']['tmp_name'];
            $path = "imagesiswa/".$image;  
            $directory = "imagesiswa/";
    
    
            if (empty($editnama) || empty($editalamat) || empty($editphone) || empty($editemail)) {
                $error = "error";
            }
            if ($image) {
                if (!file_exists($path)) {
                        unlink($directory.$row['image']);
                        move_uploaded_file($temp, "imagesiswa/".$image);
                }
                else {
                    $error = "Sudah Ada";
                    echo "<script> alert('Sudah ada data itu') </script>";
                }

            }
            else {
                $image = $row['image'];
            }
    
    
            if (!isset($error)) {
                $querylogin = $dbConn->prepare("UPDATE siswa set nama=:nama, alamat=:alamat, jurusan=:jurusan, tingkat=:tingkat, kelas=:kelas, phone=:nohp, email=:email, image=:image where nis=:nis");
                $querylogin->execute(array(':nis'=>$nis,':nama'=>$editnama,':alamat'=>$editalamat,':jurusan'=>$editjurusan,':tingkat'=>$edittingkat,':kelas'=>$editkelas,':nohp'=>$editphone, ':image'=>$image,':email'=>$editemail));            
                header("Location: editmurid.php");
            }
        } catch (PDOException $th) {
            //throw $th;
        }
    }
?>