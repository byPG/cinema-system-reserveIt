<?php
$id = $_GET['id'];
require_once "connectdb.php";
mysqli_report(MYSQLI_REPORT_STRICT);
$filmRow = null;
$averageRating = "Brak";

$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
if ($polaczenie->connect_errno != 0) {
    throw new Exception(mysqli_connect_errno());
} else {
    $sql = "SELECT * from filmy WHERE id_film = " . $id;
    if ($result = mysqli_query($polaczenie, $sql)) {
        $filmRow = mysqli_fetch_assoc($result);
    }

    $sql = "SELECT AVG(rating) as avg FROM review WHERE film_id = " . $id;
    if ($result = mysqli_query($polaczenie, $sql)) {
        $avg = mysqli_fetch_assoc($result);
        if ($avg['avg'] != 0) {
            $averageRating = round($avg['avg'], 2) . " / 5";
        }
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['reviewId'];
    $sql = "DELETE FROM review WHERE id =" . $id;
    if ($result = mysqli_query($polaczenie, $sql)) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
}

?>


<section id="opisfilmu" class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
             <img src="<?php echo $filmRow['obrazek']; ?>" alt="film" class="img-fluid">
                <div class="form-row pt-4">
                    <div class="col">
                        <form method="post">
                            <input type="hidden" name="" value="">
                            <input type="hidden" name="" value="">
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 py-3">
                <?php
                if ($filmRow != null)
                    echo '<h2>' . $filmRow['tytul'] . '</h2>';
                ?>
                <hr class="m-o">
                <div class="my-3">
                    <p class="tekstofilmie">
                        <?php echo $filmRow['opis']; ?>
                    </p>
                    <table class="table">
                        <tbody>
                        <hr>
                        <tr>
                            <th scope="row">Data seansu</th>
                            <td><?php echo $filmRow['data_seansu']; ?> </td>
                        </tr>
                        <tr>
                            <th scope="row">Gatunek filmu</th>
                            <td> <?php echo $filmRow['gatunek_filmu']; ?> </td>
                        </tr>
                        <tr>
                            <th scope="row">Reżyser</th>
                            <td> <?php echo $filmRow['rezyser']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Produkcja</th>
                            <td> <?php echo $filmRow['produkcja']; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Średnia ocena</th>
                            <td> <?php echo $averageRating; ?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <a class="hiper" href="sala.php?id=<?php echo $id; ?>">
                    <button type="submit" name="products_submit" class="filmbtn btn btn-lg">Zarezerwuj teraz</button>
                </a>
                <?php
                if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) {
                    if (!$filmy->checkFollowing($filmRow['id_film'], $_SESSION['id'])) {
                        ?>
                        <a class="hiper">
                            <a href="addTofollowed.php?id=<?php echo $filmRow['id_film']; ?>" type="submit"
                               class="obserwowane btn btn-lg">Dodaj do obserwowanych</a>
                        </a>
                        <?php
                    } else {
                        ?>
                        <a class="hiper">
                            <a type="submit"
                               class="obserwowane btn btn-lg">W obserwowanych</a>
                        </a>
                        <?php
                    }
                }
                ?>
                <br>
                <br>
                <div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/"
                     data-layout="button" data-size="large"><a target="_blank"
                                                               href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse"
                                                               class="fb-xfbml-parse-ignore">Udostępnij</a></div>
            </div>
        </div>
        <h3>Zobacz recenzje użytkowników</h3>
        <hr>

        <?php

        if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany'] == true)) {
            require_once "_recenzja.php";
        }

        ?>


        <div class="row">
            <div class="col-md-12">
                <?php
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                if ($polaczenie->connect_errno != 0) {
                    throw new Exception(mysqli_connect_errno());
                } else {
                    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
                        $sql = "SELECT * FROM review WHERE film_id = " . $id;
                    }else if(isset($_SESSION['id'])){
                        $sql = "SELECT * FROM review WHERE (film_id = '$id' AND visibility = 1) OR film_id = '$id' AND user_id = " . $_SESSION['id'];
                    }else{
                        $sql = "SELECT * FROM review WHERE film_id = '$id' AND visibility = 1";
                    }
                    if ($result = mysqli_query($polaczenie, $sql)) {
                        $rowcount = mysqli_num_rows($result);
                        if ($rowcount % 10 == 1 && $rowcount % 100 != 11) {
                            echo '<h2><b>' . $rowcount . ' recenzja </b></h2>';
                        } else {
                            echo '<h2><b>' . $rowcount . ' recenzji </b></h2>';
                        }

                    }
                }
                ?>
                <div class="usersComments">
                    <?php
                    echo '<svg id="rating_star" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gold"
                                 class="bi bi-star-fill rating-star" viewBox="0 0 16 16" style="display: none">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                              </svg>';

                    while ($row = mysqli_fetch_assoc($result)) {
                        $sql = "SELECT * FROM uzytkownicy WHERE user_id = " . $row['user_id'];
                        if ($userResult = mysqli_query($polaczenie, $sql)) {
                            $userRow = mysqli_fetch_assoc($userResult);
                            $rating = str_repeat('<svg id="rating_star" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gold"
                                 class="bi bi-star-fill rating-star" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                              </svg>', $row['rating']);

                            $rating .= str_repeat('<svg id="rating_star" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="black"
                                 class="bi bi-star-fill rating-star" viewBox="0 0 16 16">
                                    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                              </svg>', 5 - $row['rating']);

                            echo '
                              <div class="comment">
                                <div style="display: flex; flex-direction: row">
                                    <div class="user">' . $userRow['imie'] . ' ' . $userRow['nazwisko'] . '<span class="time">' . date_format(date_create($row['date']), 'Y-m-d H:i') . '</span></div>';

                            if(isset($_SESSION['id']) && $_SESSION['id'] == $row['user_id']){
                                if($row['visibility'] == 0){
                                    echo '<span style="margin-left: .3rem">(Widoczna tylko dla mnie)</span>';
                                }else{
                                    echo '<span style="margin-left: .3rem">(Widoczna dla wszystkich)</span>';
                                }
                            }

                            if (isset($_SESSION['role']) && ($_SESSION['role'] == 'admin' || $_SESSION['id'] == $row['user_id'])) {
                                echo '<form style="margin-left: auto" method="post">
                                        <input name="reviewId" type="hidden" value="' . $row['id'] . '">
                                        <button name="edit" class="btn btn-outline-primary" type="button" onclick="startEdition(\'' . $row['rating'] . '\', \'' . $row['text'] . '\', \'' . $row['id'] . '\', \'' . $_SESSION['id'] . '\', \'' . $row['user_id'] . '\', \'' . $row['visibility'] . '\')">Edytuj</button>
                                        <button name="delete" class="btn btn-outline-danger">Usuń</button>
                                      </form>';
                            }

                            echo '</div>

                                <div id="rating-bar" style="display: flex; flex-direction: row; margin-bottom: 0.5rem; margin-top: 0.5rem">
                                    ' . $rating . '
                                </div>
                                <div class="userComment">' . $row['text'] . '</div>
                                <input type="hidden" name="comment-rating" id="comment-rating" value="' . $row['rating'] . '">
                                <hr>
                              </div> 
                            ';

                            echo '<div style="display: flex; flex-direction: row">';

                            if(isset($_SESSION['id']) && $review->isLiked($row['id'], $_SESSION['id'])){
                                echo '<a href="unlikeReview.php?id='.$row['id'].'"><img alt="like" src="./images/like_pressed.svg" style="width: 30px; height: 30px; cursor: pointer; margin-right: .5rem"></a>';
                            }else if(isset($_SESSION['id'])){
                                echo '<a href="likeReview.php?id='.$row['id'].'"><img alt="like" src="./images/like.svg" style="width: 30px; height: 30px; cursor: pointer; margin-right: .5rem"></a>';
                            }else{
                                echo '<img alt="like" src="./images/like.svg" style="width: 30px; height: 30px; margin-right: .5rem">';
                            }


                            $likes = $review->getLikesCount($row['id']);
                            $dislikes = $review->getDislikesCount($row['id']);

                            echo '<span style="font-size: 1.5em; margin-right: 1rem">'.$likes['likes'].'</span>';

                            if(isset($_SESSION['id']) && $review->isDisliked($row['id'], $_SESSION['id'])){
                                echo '<a href="removeDislikeReview.php?id='.$row['id'].'"><img alt="dislike" src="./images/dislike_pressed.svg" style="width: 30px; height: 30px; cursor: pointer; margin-right: .5rem"></a>';
                            }else if(isset($_SESSION['id'])){
                                echo '<a href="dislikeReview.php?id='.$row['id'].'"><img alt="dislike" src="./images/dislike.svg" style="width: 30px; height: 30px; cursor: pointer; margin-right: .5rem"></a>';
                            }else{
                                echo '<img alt="dislike" src="./images/dislike.svg" style="width: 30px; height: 30px; margin-right: .5rem">';
                            }

                            $likes = $review->getLikesCount($row['id']);
                            echo '<span style="font-size: 1.5em; margin-right: 1rem">'.$dislikes['likes'].'</span>';

                            echo '</div>';
                        }

                        echo '<hr>';
                    }
                    $polaczenie->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>