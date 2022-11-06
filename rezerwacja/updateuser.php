<?php
session_start();
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}

$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];
$email = $_POST['email'];

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
		$sql = "update uzytkownicy 
		set imie ='" .$imie . "', nazwisko='" .$nazwisko . "', email='" .$email . "' 
		where user_id = " . $_SESSION['id'];
		mysqli_query($polaczenie, $sql );
		
		$polaczenie->close();
	}

}
catch(Exception $e){
	echo '<span style="color:red;">Błąd serwera</span>';
	echo '<br/>Informacja developerska: '.$e;
}



header('Location: panelklienta.php');

?>