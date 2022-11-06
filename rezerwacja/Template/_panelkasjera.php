<?php
if (!isset($_SESSION['zalogowany']) || !$_SESSION['role'] == 'cashier') {
    header('Location: logowanie.php');
    exit();
}

if(isset($_POST['reservationNumber'])){
    if($_POST['reservationNumber'] == ""){
        header('Location: panelkasjera.php');
        exit();
    }
    header('Location: panelkasjera.php?number='.$_POST['reservationNumber']);
}

?>


<section id="panelklienta">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 panelklienta container-fluid">
                <hr class="m-o">
                <h2>Twój panel</h2>
                <hr class="m-o">
                <ul>
                    <li><a href="panelkasjera.php">Panel Kasjera</a></li>
                    <li><a href="historiarezerwacji.php">Historia rezerwacji</a></li>
                </ul>

                <hr class="m-o">
                <h3><i class="icon-phone"></i>+48 666 888 999</h3>
                <h3><i class="icon-mail"></i>info@reserveit.pl</h3>
                <hr class="m-o">

            </div>
            <div class="col-sm-10 py-5">
                <?php echo "<p> " . ' [ <a href="wylogowanie.php">Wyloguj się!</a> ]</p>'; ?>
                <h2>Witaj w swoim koncie - zarządzaj rezerwacjami!</h2>
                <hr class="m-o">
                <form method="post" style="display: flex; flex-direction: row">
                    <input value="<?php if(isset($_GET['number'])) echo $_GET['number'] ?>" class="form-control" min="0" style="width: 30%; margin-right: 1rem" type="number" name="reservationNumber" placeholder="Wyszukaj po numerze rezerwacji">
                    <button type="submit" class="btn btn-outline-dark">Wyszukaj</button>
                    <a href="panelkasjera.php" style="margin-left: 1rem" type="submit" class="btn btn-outline-warning">Pokaż wszystkie</a>
                </form>
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

                    try {
                        $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                        if ($polaczenie->connect_errno != 0) {
                            throw new Exception(mysqli_connect_errno());
                        } else {
                            $i = 1; // , count(*) as ilosc
                            if(!isset($_GET['number'])){
                                $sql = "SELECT f.sala,f.tytul,f.data_seansu, rf.id_film, rf.normalne, rf.ulgowe, rf.id_rezerwacja_film FROM rezerwacja_film rf
									inner join filmy f on f.id_film=rf.id_film
									WHERE rf.status = 1";
                            }else{
                                $sql = "SELECT f.sala,f.tytul,f.data_seansu, rf.id_film, rf.normalne, rf.ulgowe, rf.id_rezerwacja_film FROM rezerwacja_film rf
									inner join filmy f on f.id_film=rf.id_film
									WHERE rf.status = 1 AND rf.id_rezerwacja_film = ".$_GET['number'];
                            }
                            foreach (mysqli_query($polaczenie, $sql) as $row) {
                                echo
                                    '<tr>
                                                <th>' . $i . '</th>
                                                <td>' . $row['id_rezerwacja_film'] . '</td>
                                                <td>' . $row['tytul'] . '</td>
                                                <td>' . $row['data_seansu'] . '</td>
                                                <td>' . $row['sala'] . '</td>
                                                <td>' . ($row['normalne'] + $row['ulgowe']) . '</td>
                                                <td>
                                                <form method="post" action="changeReservationStatus.php">
                                                    <input name="reservationId" type="hidden" value="'.$row['id_rezerwacja_film'].'">
                                                    <select name="status">
                                                        <option value="2">Opłacona</option>
                                                        <option value="3">Porzucona</option>
                                                    </select>
                                                    <button type="submit" class="btn btn-outline-success">Zapisz</button>
                                                </form>
                                                </td>
                                    </tr>';
                                $i++;
                            }

                            $polaczenie->close();
                        }

                    } catch (Exception $e) {
                        echo '<span style="color:red;">Błąd serwera</span>';
                        echo '<br/>Informacja developerska: ' . $e;
                    }
                    //
                    //						?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

<!--<td>' . '<a href="sala.php?id=' . $row['id_film'] . '">Edytuj</a>-->
<!--    <a href="delete_order.php?id=' . $row['id_rezerwacja_film'] . '">Usuń</a> ' . '-->
<!--</td> -->