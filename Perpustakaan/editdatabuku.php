<?php
    require_once("config.php");
    $id = $_GET['id'];
    $sql = "SELECT * FROM buku where idBuku=:id";
    $stmt = $dbConn->prepare($sql);
    $stmt->bindParam(':id',$id);
    $stmt->execute();
    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    
?>
<!-- layoutnya -->
<form action="" method="POST" enctype="multipart/form-data">
<center>
    <img id = "gambar" height = "300px" width = "250px" src="image/<?php echo $row['image']; ?>"> <br>
    <input accept="images/*" value = "<?php echo $row['image'];?>" type = "file" name = "imagebuku" onchange = "document.getElementById('gambar').src = window.URL.createObjectURL(this.files[0])"> <br>
    <input value = "<?php echo $row['judul'];?>" type = "text" name = "judul" size = "35" placeholder="judul"> <br>
    <select name="kategori">
        <?php
            $querykategori = $dbConn->prepare("SELECT * from kategori");
            $querykategori->execute();
            while ($rowkategori = $querykategori->fetch(PDO::FETCH_ASSOC)) {
                if ($row['idKategori'] == $rowkategori['idKategori']) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                echo "<option ".$selected." value='".$rowkategori['idKategori']."'>".$rowkategori['kategoriBuku']."</option>";
            }
        ?>        
    </select>
    <br>
    <select name="penerbit">
        <?php
            $querypenerbit = $dbConn->prepare("SELECT * from penerbit");
            $querypenerbit->execute();
            while ($rowpenerbit = $querypenerbit->fetch(PDO::FETCH_ASSOC)) {
                if ($row['idPenerbit'] == $rowpenerbit['idPenerbit']) {
                    $selectedd = "selected";
                } else {
                    $selectedd = "";
                }

                echo "<option ".$selectedd." value='".$rowpenerbit['idPenerbit']."'>".$rowpenerbit['nama']."</option>";
            }

        ?>        
            
    </select>
    <br>
    <input value = "<?php echo $row['penulis'];?>" type="text" name="penulis" size="35" placeholder="penulis"> <br>
    <input value = "<?php echo $row['qty'];?>" type="text" name="jumlah" size="35" placeholder="jumlah"> <br>
    <textarea name="sinopsis" cols="30" rows="10"><?php echo $row['sinopsis'];?></textarea> <br>
    <input type = "submit" name = "btn_insert" value = "Insert"> <br>
</center>
</form>
<a href="editbuku.php" class="btn btn-primary">Back</a>
<?php
    if (isset($_POST['btn_insert'])) {
        try{
            $judul = $_POST['judul'];
            $sinopsis = $_POST['sinopsis'];
            $penulis = $_POST['penulis'];
            $qty = $_POST['jumlah'];
            $penerbit = $_POST['penerbit'];
            $kategori = $_POST['kategori'];
    
            $image = $_FILES['imagebuku']['name'];
            $type = $_FILES['imagebuku']['type'];
            $size = $_FILES['imagebuku']['size'];
            $temp = $_FILES['imagebuku']['tmp_name'];
            $path = "image/".$image;
            $directory = "image/";

            if (empty($judul) || empty($sinopsis) || empty($penulis) || empty($qty) || empty($penerbit) || empty($kategori)) {
                $error = "error";
            }
            if ($image) {
                if (!file_exists($path)) {
                    unlink($directory.$row['image']);
                    move_uploaded_file($temp, "image/".$image);
                }
                else {
                    $error = "Sudah Ada";
                    echo "<script> alert('Sudah ada data itu') </script>";
                }
            }
            else {
                $image = $row['image'];
            }

            if(!isset($error)){
                $queryinsert = $dbConn->prepare("UPDATE BUKU set idKategori = :idKategori, judul = :judul, idPenerbit = :idPenerbit, penulis = :penulis,  qty = :qty, image = :images, sinopsis = :sinopsis where idBuku = :idBuku");
                $queryinsert->execute(array(':idBuku'=>$id, ':idKategori'=>$kategori, ':judul'=>$judul,':idPenerbit'=>$penerbit, ':penulis'=>$penulis, ':qty'=>$qty,':images'=>$image,':sinopsis'=>$sinopsis));
            }
            
        } catch (PDOException $e){

        }
        header("Location: editbuku.php");
    }
?>