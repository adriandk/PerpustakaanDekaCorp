<?php
    require_once("config.php");
    // session_start();
    // $hak = $_SESSION['hak'];
    $queryidbuku = $dbConn->prepare("SELECT MAX(idBuku DIV 1) as id from buku");
    $queryidbuku->execute();
    $rowidbuku = $queryidbuku->fetch(PDO::FETCH_ASSOC);
    $id = $rowidbuku['id'];
    $idinsert = null;
    if($id == null){
        $idinsert = "1";
    }
    else {
        $idinsert = ++$id;
    }

?>
<!-- layoutnya -->
<form action="" method="POST" enctype="multipart/form-data">
<center>
    <img id = "gambar" height = "300px" width = "250px"> <br>
    <input accept="images/*" type = "file" name = "imagebuku" onchange = "document.getElementById('gambar').src = window.URL.createObjectURL(this.files[0])"> <br>
    <input type = "text" name = "judul" size = "35" placeholder="judul"> <br>
    <select name="kategori">
        <?php
            $querykategori = $dbConn->prepare("SELECT * from kategori");
            $querykategori->execute();
            while ($rowkategori = $querykategori->fetch(PDO::FETCH_ASSOC)) {
        ?>        
            <option value="<?php echo $rowkategori['idKategori']; ?>"><?php echo $rowkategori['kategoriBuku']; ?></option>
        <?php
            }
        ?>
    </select>
    <br>
    <select name="penerbit">
        <?php
            $querypenerbit = $dbConn->prepare("SELECT * from penerbit");
            $querypenerbit->execute();
            while ($rowpenerbit = $querypenerbit->fetch(PDO::FETCH_ASSOC)) {
        ?>        
            <option value="<?php echo $rowpenerbit['idPenerbit']; ?>"><?php echo $rowpenerbit['nama']; ?></option>
        <?php
            }
        ?>
    </select>
    <br>
    <input type="text" name="penulis" size="35" placeholder="penulis"> <br>
    <input type="text" name="jumlah" size="35" placeholder="jumlah"> <br>
    <textarea name="sinopsis" cols="30" rows="10"></textarea> <br>
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

            if (empty($judul) || empty($sinopsis) || empty($penulis) || empty($qty) || empty($penerbit) || empty($kategori) || empty($image)) {
                $error = "error";
            }
            else {
                if (!file_exists($path)) {
                    move_uploaded_file($temp, "image/".$image);
                }
                else {
                    $error = "Sudah Ada";
                    echo "<script> alert('Sudah ada data itu') </script>";
                }
            }

            if(!isset($error)){
                $queryinsert = $dbConn->prepare("INSERT INTO BUKU (idBuku, idKategori, judul, idPenerbit, penulis, qty, image, sinopsis) values(:idBuku, :idKategori, :judul, :idPenerbit, :penulis, :qty, :images, :sinopsis)");
                $queryinsert->execute(array(':idBuku'=>$idinsert, ':idKategori'=>$kategori, ':judul'=>$judul,':idPenerbit'=>$penerbit, ':penulis'=>$penulis, ':qty'=>$qty,':images'=>$image,':sinopsis'=>$sinopsis));
            }
            
        } catch (PDOException $e){

        }

        header("Location: editbuku.php");
    }
?>