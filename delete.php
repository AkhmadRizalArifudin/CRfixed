<?php

include 'functions.php';
$pdo = pdo_connect();
session_start();
$token = filter_input(INPUT_POST, 'token', FILTER_UNSAFE_RAW);
if (!isset($_SESSION['user']) && (!$token || $token !== $_SESSION['token'])) {
    header("location: ../login.php");
} else {
if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('DELETE FROM contacts WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    header("location:index.php");
} else {
    die ('No ID specified!');
}

}?>