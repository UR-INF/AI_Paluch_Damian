<?php if ($_SESSION['zalogowany'] == 'mechanik'){?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php?page=mechanicy">Warsztat</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor02">
        <ul class="navbar-nav mr-auto">

            <li class="nav-item">
                <a class="nav-link" href="index.php?page=obsluzDiagnoze">Diagnozy</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=obsluzPrzeglad">Przeglądy</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=obsluzUsluge">Usługi</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=historiaMechanika">Historia</a>
            </li>
            
        </ul>
        <form class="form-inline my-2 my-lg-2 float-right" method="post">
            Zalogowany jako: <?php echo $_SESSION['imie']. ' ' . $_SESSION['nazwisko']. '&nbsp';?>
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