<?php
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}
?>


<section id="panelklienta">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 panelklienta container-fluid">
                <hr class="m-o">
                <h2>Panel użytkownika</h2>
                <hr class="m-o">
                <ul>
                    <li><a href="#">Twoje aktualne rezerwacje</a></li>
                    <li><a href="historiazamowienusera.php">Historia rezerwacji</a></li>
                    <li><a href="followedFilms.php">Obserwowane filmy</a></li>
                    <li><a href="daneusera.php">Dane użytkownika</a></li>

                </ul>

                <hr class="m-o">
                <h3><i class="icon-phone"></i>+48 666 888 999</h3>
                <h3><i class="icon-mail"></i>info@reserveit.pl</h3>
                <hr class="m-o">

            </div>
            <div class="col-sm-10 py-5">
                <?php echo "<p> ".' [ <a href="wylogowanie.php">Wyloguj się!</a> ]</p>';?>
                <h2>Witaj w swoim koncie - sprawdź swoje rezerwacje!</h2>
                <hr class="m-o">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">lp.</th>
                        <th scope="col">Nr rezerwacji</th>
                        <th scope="col">Repertuar</th>
                        <th scope="col">Data i godzina</th>
                        <th scope="col">Sala</th>
                        <th scope="col">Ilość miejsc</th>
                        <th scope="col">Działanie</th>
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
									$i = 1; // , count(*) as ilosc
									foreach (mysqli_query($polaczenie, "SELECT f.sala,f.tytul,f.data_seansu, rf.id_film, rf.normalne, rf.ulgowe, rf.id_rezerwacja_film FROM rezerwacja_film rf
									inner join filmy f on f.id_film = rf.id_film 
									WHERE rf.id_user = " . $_SESSION['id'] .  " AND rf.status = 1 group by rf.id_film" ) as $row) {
										echo '<tr><th>' . $i . '</th><td>' .$row['id_rezerwacja_film'] . '</td><td>'. $row['tytul'] . '</td><td>' . $row['data_seansu']. '</td><td>' . $row['sala'] .'</td><td>' . ($row['normalne'] + $row['ulgowe']) . '</td><td>' .  '<a href="sala.php?id=' . $row['id_film'] . '">Edytuj</a> <a href="delete_order.php?id=' . $row['id_rezerwacja_film'] . '">Usuń</a> '. '</td> </tr>';
										$i++;
									}
									/* . ' <a href="delete.php?id=' . $row['id_film'] . '">Usuń</a>'  */

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
            </div>
        </div>
    </div>
</section>

