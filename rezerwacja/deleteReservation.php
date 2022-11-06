<?php
session_start();
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
                <h2>Usunięcie rezerwacji filmu</h2>
                <hr class="m-o">
                
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
									$result = mysqli_query($polaczenie, "update miejsce_film set user_id = null, id_bilet_rodzaj = null WHERE id_miejsce_film = " . $_GET['id']);
									echo 'Rezerwacja na miejsce cofnięta !<br/>';
									echo '<a href="edit.php?id=' . $_GET['oldId']. '">Powrót</a>';
									$polaczenie->close();
								}

							}
							catch(Exception $e){
								echo '<span style="color:red;">Błąd serwera</span>';
								echo '<br/>Informacja developerska: '.$e;
							}

						?>
						
            </div>
        </div>
    </div>
</section>

