<?php
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <section class="dane col-l-6 py-4">
            <p>Aby dokonać prawidłowo rezerwacji w pierwszym kroku wybierz ilość biletów oraz ich rodzaj. Następnie zatwierdż ich ilość za pomocą przycisku. Kolejno wybierz z pośród wolnych miejsc preferowane i przejdź dalej i potwierdź rezerwację.</p>
            <hr>
            <p class="krok">1- wybierz rodzaj i ilość biletów</p>
            <hr>
			
			<form action="zmianailosci.php" method="post">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Rodzaj</th>
                    <th scope="col">Cena</th>
                    <th scope="col">Ilość</th>
                </tr>
                </thead>
                <tbody>
					<?php 
				require_once "connectdb.php";
					mysqli_report(MYSQLI_REPORT_STRICT);

					$normalne = 0;
					$ulgowe = 0;
					$idRezerwacja = 0;
					try
					{
						$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
						if ($polaczenie->connect_errno!=0)
						{
							throw new Exception(mysqli_connect_errno());
						}
						else {
							$i = 1;
							foreach (mysqli_query($polaczenie, "SELECT * FROM rezerwacja_film
							WHERE id_user = " . $_SESSION['id'] . ' and id_film = ' . $_GET["id"]) as $row) {
								$ulgowe = $row['ulgowe'];
								$normalne = $row['normalne'];
								$idRezerwacja = $row['id_rezerwacja_film'];
							}
							$polaczenie->close();
						}

					}
					catch(Exception $e){
						echo '<span style="color:red;">Błąd serwera</span>';
						echo '<br/>Informacja developerska: '.$e;
					}

				?>
				<input type="hidden" name="prevId" value="<?php echo $_GET['id']?>">
					<tr>
						<th scope="row">Normalny</th>
						<td>26.00 ZŁ</td>
						<td>
							<select name="normalne" class="form-select form-select-sm" aria-label=".form-select-sm example">
								<option <?php if($normalne == 0){ echo "selected"; } ?>>0</option>
								<option <?php if($normalne == 1){ echo "selected"; } ?> value="1">1</option>
								<option <?php if($normalne == 2){ echo "selected"; } ?> value="2">2</option>
								<option <?php if($normalne == 3){ echo "selected"; } ?> value="3">3</option>
								<option <?php if($normalne == 4){ echo "selected"; } ?> value="4">4</option>
								<option <?php if($normalne == 5){ echo "selected"; } ?> value="5">5</option>
								<option <?php if($normalne == 6){ echo "selected"; } ?> value="6">6</option>
								<option <?php if($normalne == 7){ echo "selected"; } ?> value="7">7</option>
								<option <?php if($normalne == 8){ echo "selected"; } ?> value="8">8</option>
								<option <?php if($normalne == 9){ echo "selected"; } ?> value="9">9</option>
								<option <?php if($normalne == 10){ echo "selected"; } ?> value="10">10</option>
							</select>
						</td>

					</tr>
					<tr>
						<th scope="row">Ulgowy</th>
						<td>18.00 ZŁ</td>
						<td>
							<select name="ulgowe" class="form-select form-select-sm" aria-label=".form-select-sm example">
								<option <?php if($ulgowe == 0){ echo "selected"; } ?> >0</option>
								<option <?php if($ulgowe == 1){ echo "selected"; } ?> value="1" >1</option>
								<option <?php if($ulgowe == 2){ echo "selected"; } ?> value="2" >2</option>
								<option <?php if($ulgowe == 3){ echo "selected"; } ?> value="3" >3</option>
								<option <?php if($ulgowe == 4){ echo "selected"; } ?> value="4" >4</option>
								<option <?php if($ulgowe == 5){ echo "selected"; } ?> value="5" >5</option>
								<option <?php if($ulgowe == 6){ echo "selected"; } ?> value="6" >6</option>
								<option <?php if($ulgowe == 7){ echo "selected"; } ?> value="7" >7</option>
								<option <?php if($ulgowe == 8){ echo "selected"; } ?> value="8" >8</option>
								<option <?php if($ulgowe == 9){ echo "selected"; } ?> value="9" >9</option>
								<option <?php if($ulgowe == 10){ echo "selected"; } ?> value="10" >10</option>
							</select>
						</td>
					</tr>
					</tbody>
				</table>
				<button class="rezerwacjabtn btn btn-lg" type="submit">Zatwierdź ilosci</button>
			</form>
        </section>
        <hr>
        <p class="krok" id="scrollTo">2- wybierz miejsca</p>
        <hr>
		
        <section class="sala col-l-6 py-4">
            <div class="container">
                <div class="ekran"></div>
				<?php 
				$allRows = [];
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
							$sql = '
							SELECT rf.id_user as id_user,rf.id_film as id_film, mf.numer as numer, mf.rzad as rzad, mf.id_miejsce_film as id_miejsce_film, rf.id_rezerwacja_film as id_rezerwacja_film 
							FROM rezerwacja_film rf 
							inner join miejsce_film mf on mf.id_rezerwacja_film = rf.id_rezerwacja_film
							where rf.id_film=' . $_GET["id"];
							//$result  = $polaczenie->query($sql);
							$result = mysqli_query($polaczenie, $sql);
							$allRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
							//$allRows = $result->fetch_all();
							//echo $allRows;
							//$comma_separated = implode(",", $allRows[0]);
							//echo $comma_separated;
							$polaczenie->close();
						}

					}
					catch(Exception $e){
						echo '<span style="color:red;">Błąd serwera</span>';
						echo '<br/>Informacja developerska: '.$e;
					}

				?>
				
				<?php 
					for($i = 1; $i < 11; $i++){
						echo '<div class="rzad">'. $i;
						
							for($j = 1; $j < 11; $j++){
								$item = null;
								foreach($allRows as $struct) {
									//echo $struct['numer'];
									if ($j == $struct['numer'] && $i == $struct['rzad']) {
										$item = $struct;
										break;
									}
									//$rec++;
								}
								if($item !== null){
									//echo $item['numer'] . " " . $item['rzad'];
									if($item['id_user'] == $_SESSION['id']){ // nasze
										echo "<a href='remove_seat.php?id=" . $item['id_miejsce_film'] ."&oldId=" . $_GET['id'] . "'><div class='fotel2'></div></a>"; 
									}
									else{
										echo "<div class='fotel3'></div>"; // cudze
									}
								}else{
									echo "<a href='add_seat.php?id=" . $idRezerwacja . "&numer=" . $j . "&rzad=" . $i ."&oldId=" . $_GET['id'] . "'><div class='fotel'></div></a>"; // zwykle
								}
							}
						echo $i.'</div>';
					}
				
				?>
            </div>
        </section>
    </div>
</div>

<div class="legenda clearfix">
    <div class="fotel1"></div>
    <p>Wolne</p>
    <div class="fotel2"></div>
    <p>Wybrane</p>
    <div class="fotel3"></div>
    <p>Zajęte</p>
</div>
<a href="potwierdzenierezerwacji.php<?php echo "?id=" . $_GET['id'] ?>"><button type="submit" class="btn btn-warning dalej">Dalej ></button></a>