<?php
session_start();
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}


$placeId = $_GET['id'];
$lastId = $_GET['oldId'];

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
		$sql = "delete from miejsce_film where id_miejsce_film = " . $placeId;
		mysqli_query($polaczenie, $sql );
		
		$polaczenie->close();
	}

}
catch(Exception $e){
	echo '<span style="color:red;">Błąd serwera</span>';
	echo '<br/>Informacja developerska: '.$e;
}



header('Location: sala.php?id=' . $lastId . '#scrollTo');

?>