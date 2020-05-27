<?php if ($_SESSION['zalogowany'] == 'klient'){?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php?page=klienci">Warsztat</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Umów na wizyte</a>
                <div class="dropdown-menu" style="">
                    <a class="dropdown-item" href="index.php?page=umowDiagnoze">Diagnoza</a>
                    <a class="dropdown-item" href="index.php?page=umowPrzeglad">Przegląd</a>
                    <a class="dropdown-item" href="index.php?page=umowUsluge">Usługa</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=dodajSamochod">Dodaj samochód</a>

            </li>

            <li class="nav-item">
                <a class="nav-link" href="index.php?page=historiaKlienta">Historia</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=edycjaDanychKlienta">Edytuj dane</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-2 float-right" method="post">
 Zalogowany jako: <?php echo $_SESSION['imie']. ' ' . $_SESSION['nazwisko'];?>
            <button class="btn btn-secondary" name="wyloguj" type="submit">Wyloguj</button>
        </form>
    </div>
</nav>
<?php if(isset($_POST['wyloguj'])){
    $_SESSION = array();
    session_destroy();
    header("Location: index.php?page=logowanie");
}
}else{
header("Location: index.php?page=logowanie");
}
?>