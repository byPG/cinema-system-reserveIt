<?php

if(!isset($_POST['reservationId']) || !isset($_POST['status'])){
    header('Location: logowanie.php');
}

$reservationId = $_POST['reservationId'];
$status = $_POST['status'];

require_once "connectdb.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno!=0)
{
    echo "Error: ".$polaczenie->connect_errno;
}else{
    $sql = "UPDATE rezerwacja_film SET status = ".$status." WHERE id_rezerwacja_film = ".$reservationId;
    if ($polaczenie->query($sql)) {
        header('Location: panelkasjera.php');
    } else {
        throw new Exception($polaczenie->error);
    }

    $polaczenie->close();
}