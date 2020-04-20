<?php
    try {
        require_once("config.php");
        $id= $_GET['id'];
        $sql = "DELETE FROM detailtransaksi where idTransaksi = :id";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        $sql = "DELETE FROM transaksi where idTransaksi = :id";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        header("Location: laporan.php");
    } catch (PDOException $th) {
        echo '<script language="javascript">';
        echo 'alert("Gabisa bro"); window.location = "laporan.php";';
        echo '</script>';
        
    }
?>