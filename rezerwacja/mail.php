<?php
if (isset($_POST['nbtnwyslij'])) {
    $name = $_POST['nimie'];
    $emailFrom= $_POST['nemail'];
    $message = $_POST['nwiadomosc'];

    $mailTo = "testowo@onet.pl";

    $headers = "From: ".$emailFrom;
    $txt = "Nowa wiadomość e-mail od ". $name.".\n\n";

    mail($mailTo, $txt, $headers, $message);
    header('Location: podziękowaniezakontakt.php');
}