<?php
session_start();
// ถ้าไม่loginก็จะเข้าหน้านี้ไม่ได้
if (!isset($_SESSION['user_email'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user_email']);
    header('location: login.php');
}