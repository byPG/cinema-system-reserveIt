<?php
if(isset($_POST["save"])) {

    if(getimagesize($_FILES["fileToUpload"]["tmp_name"])){

        $target_dir = "./images/filmy/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                $id = $_POST['id'];
                $tytul = $_POST['tytul'];
                $opis = $_POST['opis'];
                $rezyser = $_POST['rezyser'];
                $gatunek = $_POST['gatunek'];
                $data_seansu = $_POST['data_seansu'];
                $produkcja = $_POST['produkcja'];
                $sala = $_POST['sala'];
                $status = $_POST['status'];

                require_once "connectdb.php";
                try {
                    $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                    if ($polaczenie->connect_errno != 0) {
                        throw new Exception(mysqli_connect_errno());
                    } else {
                        if ($polaczenie->query("UPDATE filmy SET tytul = '$tytul', opis = '$opis', data_seansu = '$data_seansu', gatunek_filmu = '$gatunek', rezyser = '$rezyser', produkcja = '$produkcja', obrazek = '$target_file', sala = '$sala', status = '$status' WHERE id_film = '$id'")) {
                            header('Location: ' . $_SERVER['HTTP_REFERER']);
                        } else {
                            throw new Exception($polaczenie->error);
                        }
                    }

                    $polaczenie->close();

                } catch (Exception $e) {
                    echo '<span style="color:red;">Błąd serwera - prosimy o spróbować później</span>';
                    echo '<br/>Informacja developerska: ' . $e;
                }

            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }else{
        $id = $_POST['id'];
        $tytul = $_POST['tytul'];
        $opis = $_POST['opis'];
        $rezyser = $_POST['rezyser'];
        $gatunek = $_POST['gatunek'];
        $data_seansu = $_POST['data_seansu'];
        $produkcja = $_POST['produkcja'];
        $sala = $_POST['sala'];
        $status = $_POST['status'];

        require_once "connectdb.php";
        try {
            $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
            if ($polaczenie->connect_errno != 0) {
                throw new Exception(mysqli_connect_errno());
            } else {
                if ($polaczenie->query("UPDATE filmy SET tytul = '$tytul', opis = '$opis', data_seansu = '$data_seansu', gatunek_filmu = '$gatunek', rezyser = '$rezyser', produkcja = '$produkcja', sala = '$sala', status = '$status' WHERE id_film = '$id'")) {
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                } else {
                    throw new Exception($polaczenie->error);
                }
            }

            $polaczenie->close();

        } catch (Exception $e) {
            echo '<span style="color:red;">Błąd serwera - prosimy o spróbować później</span>';
            echo '<br/>Informacja developerska: ' . $e;
        }
    }

}else{

    $target_dir = "./images/filmy/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $tytul = $_POST['tytul'];
            $opis = $_POST['opis'];
            $rezyser = $_POST['rezyser'];
            $gatunek = $_POST['gatunek'];
            $data_seansu = $_POST['data_seansu'];
            $produkcja = $_POST['produkcja'];
            $sala = $_POST['sala'];

            require_once "connectdb.php";
            try {
                $polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
                if ($polaczenie->connect_errno != 0) {
                    throw new Exception(mysqli_connect_errno());
                } else {
                    if ($polaczenie->query("INSERT INTO filmy VALUES (NULL, '$tytul', '$opis', '$data_seansu', '$gatunek', '$rezyser', '$produkcja', '$target_file', '$sala', 'aktywny')")) {
                        header('Location: ' . $_SERVER['HTTP_REFERER']);
                    } else {
                        throw new Exception($polaczenie->error);
                    }
                }

                $polaczenie->close();

            } catch (Exception $e) {
                echo '<span style="color:red;">Błąd serwera - prosimy o spróbować później</span>';
                echo '<br/>Informacja developerska: ' . $e;
            }

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

