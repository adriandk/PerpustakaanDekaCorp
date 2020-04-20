<?php
    try {
        require_once("config.php");
        $id= $_GET['id'];
        $sql = "DELETE FROM penerbit where idPenerbit = :id";
        $stmt = $dbConn->prepare($sql);
        $stmt->bindParam(':id',$id);
        $stmt->execute();
        header("Location: editpenerbit.php");
    } catch (PDOException $th) {
        echo '<script language="javascript">';
        echo 'alert("Gabisa bro"); window.location = "editpenerbit.php";';
        echo '</script>';
    }

?>
<!-- ini udah -->