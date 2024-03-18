<?php
    session_start();
    $conn=new mysqli('localhost','root','','kantor');
    if (!isset($_SESSION['user_id']) || $_SESSION['type'] != 'Admin') {
        header("Location: /kantor/log.php");
        exit();
    }
    $sql3 = "ALTER TABLE users AUTO_INCREMENT = 0";
    $sql2='DELETE FROM users WHERE user_id='.$_GET['id']  ;
    $conn->query($sql2);
    $conn->query($sql3);
    echo $conn->query($sql3);
    header("location: user_admin_panel.php");
?>