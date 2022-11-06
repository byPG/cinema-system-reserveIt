<?php
if (!isset($_SESSION['zalogowany']) || !$_SESSION['role'] == 'admin') {
    header('Location: logowanie.php');
    exit();
}

$filmy_shuffle = $filmy->getAllFilms();

if(isset($_POST['film_id_edit'])){
    $film = $filmy->getFilmById($_POST['film_id_edit']);
}

?>


<section id="panelklienta">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-2 panelklienta container-fluid">
                <hr class="m-o">
                <h2>Panel Admina</h2>
                <hr class="m-o">
                <ul>
                    <li><a href="paneladmina.php">Harmonogram filmów</a></li>
                    <li><a href="statystykaadmina.php">Statystyka</a></li>
                </ul>

                <hr class="m-o">
                <h3><i class="icon-phone"></i>+48 666 888 999</h3>
                <h3><i class="icon-mail"></i>info@reserveit.pl</h3>
                <hr class="m-o">

            </div>
            <div class="col-sm-10 py-5">
                <?php echo "<p> " . ' [ <a href="wylogowanie.php">Wyloguj się!</a> ]</p>'; ?>
                <h2>Witaj w swoim koncie - dodaj film do harmonogramu!</h2>
                <hr class="m-o">


                <form method="post" enctype="multipart/form-data" action="addFilm.php">
                    <input type="hidden" value="<?php if(isset($film)) echo $film['id_film']; ?>" name="id">
                    <input type="hidden" value="<?php if(isset($film)) echo $film['status']; ?>" name="status">
                    <input type="file" name="fileToUpload" id="fileToUpload" required>
                    <input type="text" style="width: 100%" class="form-control" placeholder="Tytuł" name="tytul" required value="<?php if (isset($film)) echo $film['tytul']; ?>">
                    <input type="text" style="width: 100%" class="form-control" placeholder="Reżyser" name="rezyser" required value="<?php if (isset($film)) echo $film['rezyser']; ?>">
                    <input type="text" style="width: 100%" class="form-control" placeholder="Gatunek" name="gatunek" required value="<?php if (isset($film)) echo $film['gatunek_filmu']; ?>">
                    <input type="text" style="width: 100%" class="form-control" placeholder="Produkcja" name="produkcja" required value="<?php if (isset($film)) echo $film['produkcja']; ?>">
                    <input type="number" class="form-control" placeholder="Sala" name="sala" required value="<?php if (isset($film)) echo $film['sala']; ?>">
                    <input type="datetime-local" class="form-control" name="data_seansu"
                           placeholder="Data seansu" required value="<?php echo date('Y-m-d\TH:i:s', strtotime($film['data_seansu'])); ?>">
                    <textarea style="column-span: all" placeholder="Wprowadź opis filmu" rows="8" class="form-control" name="opis"
                              required><?php if (isset($film)) echo $film['opis']; ?></textarea>
                    <?php
                        if(isset($film)){
                    ?>
                            <button type="submit" class="btn btn-primary" name="save">Zapisz</button>
                            <a type="submit" class="btn btn-danger" href="paneladmina.php">Anuluj</a>
                    <?php
                        }else{
                    ?>
                            <button type="submit" class="rezerwacjabtn">Dodaj</button>
                    <?php
                        }
                    ?>


                </form>


                <hr>
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
                        <th scope="col">Status</th>
                        <th scope="col">Działania</th>
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
                                <span><?php echo $item['status']; ?></span>
                            </td>
                            <td>
                                <?php
                                if ($item['status'] == 'aktywny') {
                                    ?>
                                    <form method="post" action="removeFilm.php">
                                        <input name="id" type="hidden" value="<?php echo $item['id_film'] ?>">
                                        <button type="submit" style="width: 100%" class="btn btn-danger">Usuń</button>
                                    </form>
                                    <?php
                                } else if ($item['data_seansu'] > date('Y-m-d H:i:s')) {
                                    ?>
                                    <form method="post" action="enableFilm.php">
                                        <input name="id" type="hidden" value="<?php echo $item['id_film'] ?>">
                                        <button type="submit" class="btn btn-success">Aktywuj</button>
                                    </form>
                                    <?php
                                }
                                ?>
                                <form method="post">
                                    <input name="film_id_edit" type="hidden" value="<?php echo $item['id_film'] ?>">
                                    <button type="submit" class="btn btn-primary" style="margin-top: .3rem">Edytuj
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }, $filmy_shuffle) ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>

