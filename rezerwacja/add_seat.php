<?php
session_start();
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}


$placeId = $_GET['id'];
$nr = $_GET['numer'];
$rzad = $_GET['rzad'];
$oldId = $_GET['oldId'];

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
		$sql3 = "select count(*) as ilosc from miejsce_film where id_rezerwacja_film = " . $placeId;
		$result = mysqli_query($polaczenie, $sql3 );
		$allRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
		$ilosc = $allRows[0]['ilosc'];
		
		$sql2 = "select * from rezerwacja_film where id_rezerwacja_film = " . $placeId;
		$result2 = mysqli_query($polaczenie, $sql2 );
		$allRows2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
		$maxIlosc = $allRows2[0]['normalne'] + $allRows2[0]['ulgowe'] ;
		
		if($ilosc < $maxIlosc){
			$sql = "insert into miejsce_film (id_rezerwacja_film,numer,rzad) values (" . $placeId . "," .$nr . "," . $rzad .") ";
			mysqli_query($polaczenie, $sql );
		}
		
		$polaczenie->close();
	}

}
catch(Exception $e){
	echo '<span style="color:red;">Błąd serwera</span>';
	echo '<br/>Informacja developerska: '.$e;
}



header('Location: sala.php?id=' . $oldId . '#scrollTo');

?>