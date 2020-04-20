<?php
    require_once("config.php");
    session_start();
    $idadmin = $_SESSION['id'];
    $id = $_GET['id'];
    if ($id == $idadmin) {
        echo '<script language="javascript">';
        echo 'alert("Kamu gabisa delete data kamu sendiri"); window.location = "editpetugas.php";';
        echo '</script>';
    }
    else {
        try {
            $sql = "SELECT * FROM pustakawan where idPustakawan = :id";
            $stmt = $dbConn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $row=$stmt->fetch(PDO::FETCH_ASSOC);
            $sql = "DELETE FROM pustakawan where idPustakawan = :id";
            $stmt = $dbConn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            $sql = "DELETE FROM login where idPustakawan = :id";
            $stmt = $dbConn->prepare($sql);
            $stmt->bindParam(':id',$id);
            $stmt->execute();
            unlink("imagepetugas/".$row['image']);
            header("Location: editpetugas.php");
        } catch (PDOException $th) {
            echo '<script language="javascript">';
            echo 'alert("Gabisa bro"); window.location = "editpetugas.php";';
            echo '</script>';
        }
        
    }
    
    
?>