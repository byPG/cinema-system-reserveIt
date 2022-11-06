<?php

require ('funkcje.php');
session_start();

if(isset($_POST['id']) && isset($_SESSION['id'])){
    $filmId = $_POST['id'];
    $userId = $_SESSION['id'];

    $filmy->removeFromFollowed($filmId, $userId);
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}