<?php
require ('funkcje.php');
session_start();

if(isset($_GET['id']) && isset($_SESSION['id'])){

    $review->removeDislikeReview($_GET['id'], $_SESSION['id']);
    header('Location: ' . $_SERVER['HTTP_REFERER']);

}