<?php
session_start();

if (isset($_POST['movieId']))
{

$userId = $_SESSION['id'];
$movieId = $_POST['movieId'];

echo 'Rezerwacja potwierdzona!<br/>';
echo '<a href="edit.php?id=' . $movieId. '">Powrót</a>';

}

?>