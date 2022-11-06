<?php
session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['haslo'])))
{
    header('Location: panelklienta.php');
    exit();
}

require_once "connectdb.php";

$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);

if ($polaczenie->connect_errno!=0)
{
    echo "Error: ".$polaczenie->connect_errno;
}
else {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $login = htmlentities($login, ENT_QUOTES, "UTF-8");

    if($rezultat= @$polaczenie->query(
        sprintf("SELECT * FROM uzytkownicy WHERE email='%s'",
        mysqli_real_escape_string($polaczenie,$login))))
    {
        $ilu_userow = $rezultat->num_rows;
        if($ilu_userow>0)
        {
            $wiersz = $rezultat->fetch_assoc();
            if (password_verify($haslo, $wiersz['haslo'])) {
                $_SESSION['zalogowany'] = true;
                $_SESSION['id'] = $wiersz['user_id'];
                $_SESSION['email'] = $wiersz['email'];
                $_SESSION['role'] = $wiersz['rola'];

                unset($_SESSION['blad']);
                $rezultat->free_result();
                switch ($_SESSION['role']){
                    case 'admin':
                        header('Location: paneladmina.php');
                        break;
                    case 'user':
                        header('Location: panelklienta.php');
                        break;
                    case 'cashier':
                        header('Location: panelkasjera.php');
                        break;
                }
            }
            else {
                $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                header('Location: logowanie.php');
            }

        } else{
            $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
            header('Location: logowanie.php');

        }

    }

    $polaczenie->close();
}


?>