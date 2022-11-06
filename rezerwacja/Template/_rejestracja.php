<?php


if (isset($_POST['email']))
{
//Założenie udanej walidacji
$wszystko_OK=true;

//Sprawdzenie poprawności imienia
$imie = $_POST['imie'];
$nazwisko = $_POST['nazwisko'];

//Sprawdzenie długości imienia
if ((strlen($imie)<3) || (strlen($imie)>30))
{
    $wszystko_OK=false;
    $_SESSION['e_imie']="Imię musi posiadać od 3 do 30 znaków!";
}

//Sprawdzenie poprawności nazwiska
    if ((strlen($nazwisko)<3) || (strlen($nazwisko)>30))
    {
        $wszystko_OK=false;
        $_SESSION['e_nazwisko']="Nazwisko musi posiadać od 3 do 30 znaków!";
    }

//Sprawdzenie poprawnosci maila
    $email = $_POST['email'];
    $emailB = filter_var($email, FILTER_SANITIZE_EMAIL);

    if ((filter_var($emailB, FILTER_VALIDATE_EMAIL)==false) || ($emailB!=$email))
    {
        $wszystko_OK=false;
        $_SESSION['e_email']="Podaj poprawny adres e-mail!";
    }

//Sprawdzenie haseł
    $haslo1 = $_POST['haslo1'];
    $haslo2 = $_POST['haslo2'];

    if ((strlen($haslo1)<8) || (strlen($haslo1)>20))
    {
        $wszystko_OK=false;
        $_SESSION['e_haslo']="Hasło musi posiadać od 8 do 20 znaków!";
    }

    if ($haslo1!=$haslo2)
    {
        $wszystko_OK=false;
        $_SESSION['e_haslo']="Podane hasła nie są identyczne!";
    }

    $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);


//Sprawdzenie czy regulamin jest zaakceptowany
    if (!isset($_POST['regulamin']))
    {
        $wszystko_OK=false;
        $_SESSION['e_regulamin']="Potwierdź akceptację regulaminu!";
    }

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
            //Czy email już istnieje?
            $rezultat = $polaczenie->query("SELECT user_id FROM uzytkownicy WHERE email='$email'");

            if (!$rezultat) throw new Exception($polaczenie->error);

            $ile_takich_maili = $rezultat->num_rows;

            if($ile_takich_maili>0)
            {
                $wszystko_OK=false;
                $_SESSION['e_mail']="Istnieje już konto przypisane do tego adresu e-mail!";
            }
            if ($wszystko_OK==true)
            {
                if ($polaczenie->query("INSERT INTO uzytkownicy VALUES (NULL, '$imie', '$nazwisko', '$email', '$haslo_hash', 'user')"))
                {
                    $_SESSION['udanarejestracja']=true;
                    header('Location: podziekowaniezarej.php');
                }
                else
                {
                    throw new Exception($polaczenie->error);
                }
            }

            $polaczenie->close();
        }

    }
    catch(Exception $e){
        echo '<span style="color:red;">Błąd serwera - prosimy o rejestrację w innym terminie!</span>';
        echo '<br/>Informacja developerska: '.$e;
    }
}

?>

<div class="rejestracja">
    <form method="post">
        <input type="text" name="imie" placeholder="imię" onfocus="this.placeholder=''" onblur="this.placeholder='imię'" required>
        <?php
        if (isset($_SESSION['e_imie']))
        {
            echo '<div class="error">'.$_SESSION['e_imie'].'</div>';
            unset($_SESSION['e_imie']);
        }
        ?>
        <input type="text" name="nazwisko" placeholder="nazwisko" onfocus="this.placeholder=''" onblur="this.placeholder='nazwisko'" required>
        <?php
        if (isset($_SESSION['e_nazwisko']))
        {
            echo '<div class="error">'.$_SESSION['e_nazwisko'].'</div>';
            unset($_SESSION['e_nazwisko']);
        }
        ?>
        <input type="text" name="email" placeholder="e-mail" onfocus="this.placeholder=''" onblur="this.placeholder='e-mail'"required >
        <?php
        if (isset($_SESSION['e_email']))
        {
            echo '<div class="error">'.$_SESSION['e_email'].'</div>';
            unset($_SESSION['e_email']);
        }
        ?>

        <input type="password" name="haslo1" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'" required>
        <?php
        if (isset($_SESSION['e_haslo']))
        {
            echo '<div class="error">'.$_SESSION['e_haslo'].'</div>';
            unset($_SESSION['e_haslo']);
        }
        ?>
        <input type="password" name="haslo2" placeholder="powtórz hasło" onfocus="this.placeholder=''" onblur="this.placeholder='powtórz hasło'" required>
        <label class="regulamin">
            <input type="checkbox" name="regulamin"/> Akceptuję regulamin</label>
        <?php
        if (isset($_SESSION['e_regulamin']))
        {
            echo '<div class="error">'.$_SESSION['e_regulamin'].'</div>';
            unset($_SESSION['e_regulamin']);
        }
        ?>
        <input type="submit" value="Zarejestruj się">
    </form>
</div>