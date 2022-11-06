<?php
//podpięcie bazy danych
require ('Database/DBController.php');

//podpięcie klasy filmy
require ('Database/Filmy.php');
require ('Database/Review.php');

//obiekt DBController
$db = new DBController();

//obiekt Filmy
$filmy = new Filmy($db);

$review = new Review($db);
