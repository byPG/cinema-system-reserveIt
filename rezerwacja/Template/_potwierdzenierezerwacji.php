<?php
if (!isset($_SESSION['zalogowany']))
{
    header('Location: logowanie.php');
    exit();
}


$oldId = $_GET['id'];
$userId = $_SESSION['id'];
//$allRows = null;

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
		$sql = "select rf.id_film,rf.normalne,rf.ulgowe, f.tytul, f.opis, f.data_seansu, f.sala, f.produkcja, f.obrazek, f.gatunek_filmu, rf.id_rezerwacja_film
		from rezerwacja_film rf 
		inner join filmy f on f.id_film = rf.id_film
		where rf.id_user=". $userId . " and rf.id_film = " . $oldId;
		//echo $sql;
		$result = mysqli_query($polaczenie, $sql);
		$allRows = mysqli_fetch_all($result, MYSQLI_ASSOC);
		
		$polaczenie->close();
	}

}
catch(Exception $e){
	echo '<span style="color:red;">Błąd serwera</span>';
	echo '<br/>Informacja developerska: '.$e;
}


?>

<section id="rezerw" class="py-3 sekcjapotwierdzeniarezerwacji">
    <div class="container-fluid w-75 py-3">
        <h5 class="">Potwierdzenie złożenia rezerwacji</h5>


        <div class="row potwierdzenierezerwacji">
            <div class="col-sm-9">
                <div class="row border-top py-3 mt-3">
                    <div class="col-sm-2">
                        <img src="<?php echo $allRows[0]['obrazek']?>" style="height: 120px;" alt="plakaty" class="img-fluid">
                    </div>
                    <div class="col-sm-8">
                        <h5 class=""><?php echo $allRows[0]['tytul']?></h5>
                        <small><?php echo ($allRows[0]['ulgowe'] + $allRows[0]['normalne'])?> miejsca</small>
                        <div class="d-flex">
                        </div>

                        <div class="d-flex pt-2">
                            <form method="post">
                                <button type="submit" name="" class="btn text-danger px-3 border-right"><a href="sala.php?id=<?php echo $oldId ?>" class="rezygnacja">Porzuć rezerwowanie</a></button>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="text-dark">
							<?php echo $allRows[0]['data_seansu'] ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="border text-center mt-2">
                    <h6 class="text-success py-3">Podsumowanie</h6>
                    <div class="border-top py-4">
                        <button type="submit" class="btn btn-warning mt-3"><a href="infoozarezerwowaniu.php?id=<?php echo $allRows[0]['id_rezerwacja_film'];?>" class="potwierdzenie">Potwierdź rezerwację</a></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>