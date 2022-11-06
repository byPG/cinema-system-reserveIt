<?php

if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
{
    header('Location: panelklienta.php');
    exit();
}
?>

<div class="logowanie">
    <a href="rejestracja.php"> Zarejestruj się!</a>
    <form action="zaloguj.php" method="post">
        <input type="text" name="login" placeholder="e-mail" onfocus="this.placeholder=''" onblur="this.placeholder='e-mail'" required>
        <input type="password" name="haslo" placeholder="hasło" onfocus="this.placeholder=''" onblur="this.placeholder='hasło'" required>
        <input type="submit" value="Zaloguj się">
    </form>
</div>

<?php
if(isset($_SESSION['blad'])) echo $_SESSION['blad'];
?>