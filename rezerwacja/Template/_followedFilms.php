<?php
if (!isset($_SESSION['zalogowany'])) {
    header('Location: logowanie.php');
    exit();
}

$followedFilms = $filmy->getFollowedFilms($_SESSION['id']);

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
                        <th scope="col">Plakat</th>
                        <th scope="col">Tytuł filmu</th>
                        <th scope="col">Opis filmu</th>
                        <th scope="col">Gatunek filmu</th>
                        <th scope="col">Reżyser</th>
                        <th scope="col">Produkcja</th>
                        <th scope="col">Data i godzina</th>
                        <th scope="col">Działanie</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    array_map(function ($item) {
                        ?>
                        <tr>
                            <td>
                                <img src="<?php echo $item['obrazek']; ?>" alt="image"
                                     style="width: 70px; height: 100px">
                            </td>
                            <td>
                                <span><?php echo $item['tytul']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $item['opis']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $item['gatunek_filmu']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $item['rezyser']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $item['produkcja']; ?></span>
                            </td>
                            <td>
                                <span><?php echo $item['data_seansu']; ?></span>
                            </td>
                            <td>
                                <form method="post" action="removeFromFollowed.php">
                                    <input name="id" type="hidden" value="<?php echo $item['id_film'] ?>">
                                    <button type="submit" class="btn btn-danger">Usuń</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }, $followedFilms) ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

