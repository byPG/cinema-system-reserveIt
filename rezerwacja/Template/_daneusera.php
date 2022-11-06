<?php
//session_start();
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}
$id = $_SESSION['id'];
// echo $id;
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
                <!--<h2>Twoje dane</h2>
                <hr class="m-o">
                <table class="table">
				<thead>
                    <tr>
                        <th scope="col">Imię i nazwisko</th>
                        <th scope="col">Email</th>
                        <th scope="col">Działanie</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
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
					foreach (mysqli_query($polaczenie, "select * from uzytkownicy where user_id = " . $id ) as $row) {
						echo $row['imie'] . " " . $row['nazwisko'];
						?></td>
				<td>
							<?php echo $row['email']; ?> 
							</td>
									<td><a href="#">Zmień</a></td>
								</tr>
								</tbody>
							</table>
						<?php
					}
					
					$polaczenie->close();
				}

			}
			catch(Exception $e){
				echo '<span style="color:red;">Błąd serwera</span>';
				echo '<br/>Informacja developerska: '.$e;
			}
			?>
			-->
			<div>
				<form method="post" action="updateuser.php">
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
								foreach (mysqli_query($polaczenie, "select * from uzytkownicy where user_id = " . $id ) as $row) {
									?>
									Imię: <input type="text" name="imie" value="<?php echo $row['imie']; ?>" />
									</br> 
									Nazwisko: <input type="text" name="nazwisko" value="<?php echo $row['nazwisko'];?>" /> <br>
									Email: <input type="text" name="email" value="<?php echo $row['email']; ?>"  /> <br>
								<?php
								}
								
								$polaczenie->close();
							}

						}
						catch(Exception $e){
							echo '<span style="color:red;">Błąd serwera</span>';
							echo '<br/>Informacja developerska: '.$e;
						}
						
						?>
						<button type="submit" class="btn btn-outline-dark">Zapisz</button>
				</form>
			</div>
			</div>
		</div>
	</div>
</section>