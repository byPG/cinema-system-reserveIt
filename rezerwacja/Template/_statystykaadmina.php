<?php
if (!isset($_SESSION['zalogowany']) || !$_SESSION['role'] = 'admin')
{
    header('Location: logowanie.php');
    exit();
}

require_once "connectdb.php";
try {
    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
    if ($polaczenie->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {
        if ($result = mysqli_query($polaczenie, "SELECT (SUM(normalne) + SUM(ulgowe)) as sum FROM rezerwacja_film WHERE status = 2")) {
            $allReservations = mysqli_fetch_assoc($result)['sum'];

            $sql = "SELECT (SUM(rf.normalne) + SUM(rf.ulgowe)) as sum, f.gatunek_filmu FROM rezerwacja_film rf INNER JOIN filmy f ON rf.id_film = f.id_film WHERE rf.status = 2 GROUP BY f.gatunek_filmu";
            if($result = mysqli_query($polaczenie, $sql)){
                $dataPoints = array();
                while($row = mysqli_fetch_assoc($result)){
                    switch ($row['gatunek_filmu']){
                        case 'scifi':
                            array_push($dataPoints, array("label"=>"Sci-fi", "y"=>$row['sum'] * 100 / $allReservations, "color"=>"#bb2d3b"));
                            break;
                        case 'komedie':
                            array_push($dataPoints, array("label"=>"Komedie", "y"=>$row['sum'] * 100 / $allReservations, "color"=>"#0d6efd"));
                            break;
                        case 'dramat':
                            array_push($dataPoints, array("label"=>"Dramat", "y"=>$row['sum'] * 100 / $allReservations, "color"=>"#198754"));
                            break;
                        case 'edukacyjne':
                            array_push($dataPoints, array("label"=>"Edukacyjne", "y"=>$row['sum'] * 100 / $allReservations, "color"=>"#6c757d"));
                            break;
                        case 'akcja':
                            array_push($dataPoints, array("label"=>"Akcja", "y"=>$row['sum'] * 100 / $allReservations, "color"=>"#0dcaf0"));
                            break;
                        case 'animowane':
                            array_push($dataPoints, array("label"=>"Animowane", "y"=>$row['sum'] * 100 / $allReservations, "color"=>"#ffc107"));
                            break;
                    }
                }
            }else{
                throw new Exception($polaczenie->error);
            }

        } else {
            throw new Exception($polaczenie->error);
        }
    }

    $polaczenie->close();

} catch (Exception $e) {
    echo '<span style="color:red;">Błąd serwera - prosimy o spróbować później</span>';
    echo '<br/>Informacja developerska: ' . $e;
}

?>

<script>
    window.onload = function() {


        var chart = new CanvasJS.Chart("chartContainer", {
            data: [{
                type: "pie",
                indexLabel: "{y}",
                yValueFormatString: "#,##0.00\"%\"",
                dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
            }]
        });
        chart.render();

    }
</script>

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
                <?php echo "<p> ".' [ <a href="wylogujadmin.php">Wyloguj się!</a> ]</p>';?>
                <h2>Sprawdź, które z kategorii filmowych najczęściej są wybierane przez użytkowników</h2>
                <hr class="m-o">
                <div role="group" aria-label="Kategorie">
                    <button class="btn-danger btn border my-2" >Sci-fi</button>
                    <button class="btn-primary btn border my-2" >Komedie</button>
                    <button class="btn-success btn border my-2" >Dramat</button>
                    <button class="btn-secondary btn border my-2" >Edukacyjne</button>
                    <button class="btn-info border btn my-2" >Akcja</button>
                    <button class="btn-warning btn border my-2" >Animowane</button>
                </div>

                <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

            </div>
        </div>
    </div>
</section>

