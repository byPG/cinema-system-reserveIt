<?php
session_start();

if (isset($_POST['placeId']))
{

$newId = $_POST['placeId'];
$userId = $_SESSION['id'];
$oldId = $_POST['oldId'];

    require_once "connectdb.php";
    mysqli_report(MYSQLI_REPORT_STRICT);

    try
    {
        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
        if ($polaczenie->connect_errno!=0)
        {
            throw new Exception(mysqli_connect_errno());
        }
        else {
            //Czy email już istnieje?
            $rezultat = $polaczenie->query("update miejsce_film set user_id = " .$userId . ", id_bilet_rodzaj = 1 WHERE id_miejsce_film = " .$newId);

			echo "Miejsce zarezerwowane !<br/>";
			echo '<a href="edit.php?id=' . $oldId. '">Powrót</a>';


            $polaczenie->close();
        }

    }
    catch(Exception $e){
        echo '<span style="color:red;">Błąd serwera - prosimy o rejestrację w innym terminie!</span>';
        echo '<br/>Informacja developerska: '.$e;
    }
}

?>