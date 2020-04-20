<?php
    try {
        require_once("config.php");
        $id = $_GET['id'];
        $sql = "SELECT * FROM buku where idBuku = :id";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $row=$stmt->fetch(PDO::FETCH_ASSOC);
        $sql = "DELETE FROM buku where idBuku = :id";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        unlink("image/".$row['image']);
        header("Location: editbuku.php");

    } catch (PDOException $th) {
        echo '<script language="javascript">';
        echo 'alert("Gabisa bro"); window.location = "editbuku.php";';
        echo '</script>';
        
    }
    
?>
<!-- ini udah -->