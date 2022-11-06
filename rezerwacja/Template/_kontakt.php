<!--kontakt i formularz kontaktowy-->
<section class="kontakt">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mt-5 text-right">
                <h4>Kontakt</h4>
                <p>Aby się skontaktować skorzystaj z poniższego formularza. Odpowiemy najszybciej jak to będzie możliwe!</p>
            </div>
            <div class="col-lg-6 text-center mt-5">
                <i class="icon-phone"></i>
                <h4>Infolinia</h4>
                <p>+48 999-999-999</p>
            </div>
        </div>
    </div>

    <div class="container formularzkontaktowy">
        <h4 class="tytulformularzakontaktowego">Formularz kontaktowy</h4>
        <form method="post" name="formkontakt" action="mail.php">
            <input type="text" class="imie" name="nimie" placeholder="Imię" required/>
            <input type="email" class="imie" name="nemail" placeholder="Adres e-mail" required/>
            <textarea class="wiadomosc" name="nwiadomosc" placeholder="Napisz wiadomość..." required></textarea>
            <button type="submit" class="btnwyslij" name="nbtnwyslij">Wyślij</button>
        </form>
    </div>
</section>