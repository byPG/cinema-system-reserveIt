<?php
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}


$reserveId = $_GET['id'];

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
		$sql = "select f.tytul, f.data_seansu, f.sala, u.imie, u.nazwisko, u.email, rf.id_rezerwacja_film, rf.id_user, rf.normalne, rf.ulgowe from rezerwacja_film rf 
		inner join uzytkownicy u on u.user_id = rf.id_user
		inner join filmy f on f.id_film = rf.id_film
		where id_rezerwacja_film = " . $reserveId;
		$result = mysqli_query($polaczenie, $sql);
		$allRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		$polaczenie->close();
	}

}
catch(Exception $e){
	echo '<span style="color:red;">Błąd serwera</span>';
	echo '<br/>Informacja developerska: '.$e;
}

$message = 'Zarezerwowano seans: ' . $allRows[0]['tytul']. '<br>Imię: ' . $allRows[0]['imie']. '<br>Nazwisko: ' .$allRows[0]['nazwisko'] . '<br> Sala: ' .$allRows[0]['sala'] . '<br> Data: ' . $allRows[0]['data_seansu'] . '<br>Bilety Normalne: ' . $allRows[0]['normalne'] . '<br>Bilety Ulgowe: ' . $allRows[0]['ulgowe'];

$mailTo = $allRows[0]['email'];

$headers = "From: noreply@reserveit.pl";
$txt = "Nowa wiadomość e-mail";

mail($mailTo, $txt, $headers, $message);

//header('Location: panelklienta.php');


?>


<section class="podziekowaniezakon">
    <div class="sukces">
        <i class="icon-ok-circled2"></i>
        <h4>Twoja rezerwacja została potwierdzona!</h4>
        <p>Szczegółowe informacje o rezerwacji zostały wysłane na Twój adres e-mail.
            Pamiętaj o odbiorze biletów i ich opłaceniu najpóźniej pół godziny przed rozpoczęciem seansu w kasie kina!
        </p>
        <button><a href="index.php">Powrót</a></button>
    </div>
</section>