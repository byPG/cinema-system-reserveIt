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
                    <li><a href="panelklienta.php">Twoje rezerwacje</a></li>
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
                        <th scope="col">Status</th>
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
									foreach (mysqli_query($polaczenie, "SELECT  sr.status_nazwa, f.sala,f.tytul,f.data_seansu, rf.status, rf.id_film, rf.normalne, rf.ulgowe, rf.id_rezerwacja_film FROM rezerwacja_film rf
									inner join filmy f on f.id_film=rf.id_film inner join status_rodzaj sr on sr.status_id = rf.status
									WHERE rf.id_user = " . $_SESSION['id'] .  " AND rf.status != 1 group by rf.id_film" ) as $row) {
										echo '<tr><th>' . $i . '</th><td>' .$row['id_rezerwacja_film'] . '</td><td>'. $row['tytul'] . '</td><td>' . $row['data_seansu']. '</td><td>' . $row['sala'] .'</td><td>' . ($row['normalne'] + $row['ulgowe']) . '</td><td>' . $row['status_nazwa'] . '</td> </tr>';
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

