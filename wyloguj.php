<?php
session_start();
session_destroy();
header("Location: /kantor/log.php");
?>
