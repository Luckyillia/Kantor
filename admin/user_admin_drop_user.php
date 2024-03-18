<?php
    session_start();
    $conn=new mysqli('localhost','root','','kantor');
    if (!isset($_SESSION['user_id']) || $_SESSION['type'] != 'Admin') {
        header("Location: /kantor/log.php");
        exit();
    }
    $sql3 = "ALTER TABLE users AUTO_INCREMENT = 1";
    $sql4 = "ALTER TABLE portfel AUTO_INCREMENT = 1";
    $sql2= "DELETE FROM users WHERE user_id=".$_GET['id'];
    $sql = "DELETE FROM portfel WHERE user_id=".$_GET['id'];
    $conn->query($sql2);
    $conn->query($sql3);
    $conn->query($sql);
    $conn->query($sql4);
    $conn->close();
    header("location: user_admin_panel.php");
?>