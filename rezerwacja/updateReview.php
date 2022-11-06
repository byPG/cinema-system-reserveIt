<?php
session_start();

if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) {

    $rating = $_POST['rating'];
    $reviewText = $_POST['reviewText'];
    $reviewId = $_POST['reviewId'];
    $visibility = $_POST['visibility'];


    require_once "connectdb.php";
    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            if ($polaczenie->query("UPDATE review SET rating = '$rating', text = '$reviewText', visibility = '$visibility' WHERE id = '$reviewId'")) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            } else {
                throw new Exception($polaczenie->error);
            }
        }

        $polaczenie->close();

    } catch (Exception $e) {
        echo '<span style="color:red;">Błąd serwera - prosimy o spróbować później</span>';
        echo '<br/>Informacja developerska: ' . $e;
    }
}