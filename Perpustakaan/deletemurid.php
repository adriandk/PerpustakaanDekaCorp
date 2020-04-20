<?php
    try {
        require_once("config.php");
        $nis = $_GET['nis'];
        $sql = "SELECT * FROM siswa where nis = :nis";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':nis',$nis);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $sql = "DELETE FROM siswa where nis = :nis";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':nis',$nis);
        $stmt->execute();
        unlink("imagesiswa/".$row['image']);
        header("Location: editmurid.php");
    } catch (PDOException $th) {
        echo '<script language="javascript">';
        echo 'alert("Gabisa bro"); window.location = "editmurid.php";';
        echo '</script>';
    }

?>