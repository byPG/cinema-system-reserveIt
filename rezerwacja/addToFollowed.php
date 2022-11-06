<?php
require ('funkcje.php');
session_start();

if(isset($_GET['id']) && isset($_SESSION['id'])){
    $filmId = $_GET['id'];
    $userId = $_SESSION['id'];

    $filmy->followFilm($filmId, $userId);
    header('Location: ' . $_SERVER['HTTP_REFERER']);


}