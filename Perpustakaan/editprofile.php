<?php
    require_once("config.php");
    session_start();
    $id = $_SESSION['id'];

    $query = $dbConn->prepare("SELECT * FROM pustakawan where idPustakawan=:id");
    $query->execute(array(':id'=>$id));
    $row = $query->fetch(PDO::FETCH_ASSOC);

    $query2 = $dbConn->prepare("SELECT * FROM login where idPustakawan=:id");
    $query2->execute(array(':id'=>$id));
    $row2 = $query2->fetch(PDO::FETCH_ASSOC);

    if ($row2['hakUser'] == "admin") {
        $pindah = "admin.php";
    }
    else {
        $pindah = "librarian.php";
    }
?>
<a href="<?php echo $pindah;?>" class="btn btn-primary">Back</a>

<form action="" method="POST" enctype="multipart/form-data">
    <img src="imagepetugas/<?php echo $row['image']; ?>" id = "gambar" height = "300px" width = "250px"> <br>
    <input accept="images/*" value="<?php echo $row['image']; ?>" type = "file" name = "imagepustakawan" onchange = "document.getElementById('gambar').src = window.URL.createObjectURL(this.files[0])"> <br>
    <input value="<?php echo $row['nama']; ?>" type="text" name="addnama" placeholder="Nama"><br>
    <input value="<?php echo $row['alamat']; ?>" type="text" name="addalamat" placeholder="Alamat"><br>
    <input value="<?php echo $row['phone']; ?>" type="text" name="addphone" placeholder="No HP"><br>
    <input value="<?php echo $row['email']; ?>" type="email" name="addemail" placeholder="Email"><br>
    <input value="<?php echo $row2['username']; ?>" type="text" name="addusername" placeholder="Username"><br>
    <input value="<?php echo $row2['password']; ?>" type="password" name="addpass" placeholder="Password"><br>
    <input type="submit" value="Edit" name="addbtn">
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
            $image = $_FILES['imagepustakawan']['name'];
            $type = $_FILES['imagepustakawan']['type'];
            $size = $_FILES['imagepustakawan']['size'];
            $temp = $_FILES['imagepustakawan']['tmp_name'];
            $path = "imagepetugas/".$image;  
            $directory = "imagepetugas/";
    
    
            if (empty($editnama) || empty($editalamat) || empty($editphone) || empty($editemail) || empty($editusername) || empty($editpass)) {
                $error = "error";
            }
            if ($image) {
                    if (!file_exists($path)) {
                        unlink($directory.$row['image']);
                        move_uploaded_file($temp, "imagepetugas/".$image);
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
    
                $querylogin = $dbConn->prepare("UPDATE login set username=:username, password=:pass where idPustakawan=:id");
                $querylogin->execute(array(':id'=>$id,':username'=>$editusername,':pass'=>$editpass));            
    
                $querypustakawan = $dbConn->prepare("UPDATE pustakawan set nama=:name, alamat=:alamat, phone=:phone, email=:email, image=:images where idPustakawan=:id");
                $querypustakawan->execute(array(':id'=>$id,':name'=>$editnama,':alamat'=>$editalamat,':phone'=>$editphone,':email'=>$editemail,':images'=>$image));
    
                header("Location: $pindah");
            }
        } catch (PDOException $th) {
            //throw $th;
        }
    }
?>