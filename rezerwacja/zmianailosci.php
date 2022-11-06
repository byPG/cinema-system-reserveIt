<?php
session_start();
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}


$userId = $_SESSION['id'];
$lastId = $_POST['prevId'];

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
		$i = -1;
		foreach (mysqli_query($polaczenie, "SELECT * FROM rezerwacja_film
		WHERE id_user = " . $userId . ' and id_film = ' . $lastId) as $row) {
			$i = $row['id_rezerwacja_film'];
		}
		if($i == -1){
			$sql = "insert into rezerwacja_film (id_user,id_film,normalne,ulgowe) values (" . $userId . ", " . $lastId . ", " . $_POST['normalne'] . ", " . $_POST['ulgowe'] . ")";
			mysqli_query($polaczenie, $sql );
		}
		else {
			$sql2 = "update rezerwacja_film set ulgowe = '" . $_POST['ulgowe'] . "', normalne='" . $_POST['normalne'] . "' where id_rezerwacja_film = " . $i;
			mysqli_query($polaczenie, $sql2 );
		}
		$polaczenie->close();
	}

}
catch(Exception $e){
	echo '<span style="color:red;">Błąd serwera</span>';
	echo '<br/>Informacja developerska: '.$e;
}



header('Location: sala.php?id=' . $_POST['prevId']);

?>