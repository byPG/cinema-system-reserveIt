<?php
session_start();
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}
?>


<style>
form{
	display: inline-block;
}
.seat{
	display: inline-block;
	width:50px;
	height: 50px;
    border: none;
}
.reserved{
	background-color: red;
}
.non-reserved{
	background-color: green;
}
.my-reservation{
	background-color: orange;
}
</style>

<section id="panelklienta">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 panelklienta container-fluid">
                <hr class="m-o">
                <h2>Panel użytkownika</h2>
                <hr class="m-o">
                <ul>
                    <li><a href="#">Twoje rezerwacje</a></li>
                    <li><a href="daneusera.html">Dane użytkownika</a></li>
                </ul>

                <hr class="m-o">
                <h3><i class="icon-phone"></i>+48 666 888 999</h3>
                <h3><i class="icon-mail"></i>info@reserveit.pl</h3>
                <hr class="m-o">

            </div>
            <div class="col-sm-10 py-5">
                <?php echo "<p> ".' [ <a href="wylogowanie.php">Wyloguj się!</a> ]</p>';?>
                <h2>Edycja rezerwacji filmu</h2>
                <hr class="m-o">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">lp.</th>
                        <th scope="col">Miejsce</th>
                        <th scope="col">Usuń</th>
                    </tr>
                    </thead>
                    <tbody>
					<?php 
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
									$i = 1;
									foreach (mysqli_query($polaczenie, "SELECT * FROM miejsce_film
									WHERE user_id = " . $_SESSION['id'] . ' and id_film = ' . $_GET["id"]) as $row) {
										echo '<tr><th>' . $i . '</th><td>' . $row['numer']. '</td><td><a href="deleteReservation.php?id=' . $row['id_miejsce_film'] . '&oldId=' . $_GET['id']. '">Usuń</a> '. '</td></tr>';
										$i++;
									}
									$polaczenie->close();
								}

							}
							catch(Exception $e){
								echo '<span style="color:red;">Błąd serwera</span>';
								echo '<br/>Informacja developerska: '.$e;
							}

						?>
                    </tbody>
                </table>
				<div>
					<?php 
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
									foreach (mysqli_query($polaczenie, "SELECT * FROM miejsce_film mf
									inner join filmy f on f.id_film=mf.id_film
									WHERE mf.id_film = " . $_GET["id"]) as $row) {
										$format = 'Y-m-d H:i:s';
										//$currentDate = date('Y-m-d h:i:s a', time());
										$currentDate = date('Y-m-d H:i:s', strtotime('+4 hour'));
										//$date = DateTime::createFromFormat($format, $row['data_seansu']);
										//$currentDate = DateTime::createFromFormat($format);
										
										if($row['data_seansu'] > $currentDate){
											//echo "wieksze";
											//echo $row['data_seansu'].'<br/>';
											//echo $date->format($format);
											//echo $currentDate;
											
											if($row['user_id'] == $_SESSION['id']){ // nasze
												echo '<div class="seat my-reservation">' .$row['numer'] . '</div>';
											}
											elseif($row['user_id'] === null){ // wolne
												echo '<form method="post" action="reserve.php"><input type="hidden" name="oldId" value="' .$_GET['id']  .'">
												<input type="hidden" name="placeId" value="' .$row['id_miejsce_film']  .'">
												<input class="seat non-reserved" type="submit" name="row" value="' .$row['numer'] .'"/>' .'</form>';
											}
											elseif($row['user_id'] !== $_SESSION['id']){ // cudze
												echo '<div class="seat reserved">' .$row['numer'] . '</div>';
											}		
										}
										//2022-12-22 00:00:00
										// if data < 4h to wyświetlić
																		
									}
									$polaczenie->close();
								}

							}
							catch(Exception $e){
								echo '<span style="color:red;">Błąd serwera</span>';
								echo '<br/>Informacja developerska: '.$e;
							}

						?>
				</div>
				<div>
					<form method="post" action="confirm.php">
						<input type="hidden" name="movieId" value="<?php echo $_GET['id']?>"/>
						<input type="submit" name="placeId" value="Potwierdź rezerwację"/>
					</form>
				</div>
            </div>
        </div>
    </div>
</section>

