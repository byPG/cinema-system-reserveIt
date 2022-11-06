<?php
session_start();

if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) {

    $rating = $_POST['rating'];
    $reviewText = $_POST['reviewText'];
    $user_id = $_SESSION['id'];
    $date = date("Y-m-d h:i");
    $film_id = $_POST['id_film'];


    require_once "connectdb.php";
    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            if ($polaczenie->query("INSERT INTO review VALUES (NULL, '$reviewText', '$rating', '$date', '$user_id', '$film_id', 1)")) {
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