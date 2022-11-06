<?php
session_start();

if(isset($_POST['id'])){

    require_once "connectdb.php";
    try {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno != 0) {
            throw new Exception(mysqli_connect_errno());
        } else {
            if ($polaczenie->query("UPDATE filmy SET status = 'nieaktywny' WHERE id_film = ".$_POST['id'])) {
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