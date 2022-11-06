<?php

if (!isset($_SESSION['udanarejestracja']))
{
    header('Location: logowanie.php');
    exit();
}
else
{
    unset($_SESSION['udanarejestracja']);
}
 ?>

<section class="podziekowaniezarej">
    <div class="logporej">
        <h4>Dziękujęmy za rejestrację w serwisie!</h4>
        <a href="logowanie.php"> >> Kliknij aby zalogować się na swoje konto! << </a>
        <h4>lub wróć do strony głównej aby zobaczyć najnowsze repertuary!</h4>
        <a href="index.html">Strony główna</a>
    </div>
</section>