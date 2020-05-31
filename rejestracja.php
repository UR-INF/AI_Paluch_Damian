<div class="login_container">
    <div class="d-flex col-xs-12 col-sm-12 col-md-10 col-sm-offset-1 col-md-offset-1 justify-content-center h-100">
        <div class="register_card">
            <div class="card-header">
                <center><h3>Rejestracja</h3></center>
            </div>
            <div class="card-body">


                <form method="POST" action="index.php?page=rejestracja">
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-xs-offset-4 col-sm-offset-4 col-md-offset-4">
                            <div class="form-group">
                                <input type="text" name="login" id="register_form" class="form-control input-md" title="Login musi zawierać przynajmniej 6 znaków" placeholder="Login" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-xs-offset-2 col-sm-offset-2 col-md-offset-2">
                            <div class="form-group">
                                <input type="password" name="haslo1" id="register_form" class="form-control input-md" title="Hasło musi zawierać przynajmniej 6 znaków i cyfrę" placeholder="Hasło" required>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <input type="password" name="haslo2" id="register_form" class="form-control input-md" title="Hasło musi zawierać przynajmniej 6 znaków i cyfrę" placeholder="Powtórz hasło" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-xs-4 col-sm-4 col-md-4 col-xs-offset-2 col-sm-offset-2 col-md-offset-2">
                            <div class="form-group">
                                <input type="text" name="imie" id="register_form" class="form-control input-md" placeholder="Imię" required>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4 ">
                            <div class="form-group">
                                <input type="text" name="nazwisko" id="register_form" class="form-control input-md" placeholder="Nazwisko" required>
                            </div>
                        </div>


                        <div class="col-xs-4 col-sm-4 col-md-4 col-xs-offset-4 col-sm-offset-4 col-md-offset-4">
                            <div class="form-group">
                                <input type="number" name="nrTel" id="register_form" class="form-control input-md" title="Numer telefonu musi zawierać przynajmniej 9 cyfr" placeholder="Numer telefonu" required>
                            </div>
                        </div>
                    </div>

                    <input type="submit" value="Zarejestruj" name="rejestruj"
                           class="btn login_btn btn-block">
                    <br>
                    <div class="d-flex justify-content-center links">
                        <a href="index.php?page=login">Powrót</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php

if (isset($_POST['rejestruj'])){
    $_SESSION['login'] = $_POST['login'];
    @rejestruj();
}

function rejestruj(){
    require_once "polaczenie.php";
    $conn = oci_connect($login, $haslo, $host);
    if(!$conn)
    {
        $m = oci_error();
        echo $m['message'], "\n";
        exit;   
    }
    $query="begin klient_rejestracja.rejestruj_klienta(:ku_login, :ku_haslo, :ku_powtorz_haslo, :k_imie, :k_nazwisko, :k_nr_tel); end;";
    $login = $_POST['login'];
    $haslo = $_POST['haslo1'];
    $powtorz_haslo = $_POST['haslo2'];
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $nr_tel = $_POST['nrTel'];
    $stid = oci_parse($conn, $query);
    oci_bind_by_name($stid, ":ku_login",  $login);
    oci_bind_by_name($stid, ":ku_haslo",  $haslo);
    oci_bind_by_name($stid, ":ku_powtorz_haslo",  $powtorz_haslo);
    oci_bind_by_name($stid, ":k_imie",  $imie);
    oci_bind_by_name($stid, ":k_nazwisko",  $nazwisko);
    oci_bind_by_name($stid, ":k_nr_tel",  $nr_tel);
    $result = oci_execute($stid);
    if(false === $result){
        $e = oci_error($stid);

?><div class="d-flex justify-content-center"><?php
        if($e['code'] == 00001)
        {?>
    <div class="alert alert-dismissible alert-secondary">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Błąd rejestracji</strong> Login jest już zajęty
    </div>
    
    <?php
        }
        if($e['code'] == 20001)
        {
    ?>
    <div class="alert alert-dismissible alert-secondary">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Błąd rejestracji</strong> Login musi zawierać przynajmniej 6 znaków
    </div><?php
        }
        if($e['code'] == 20002)
        {
            ?>
    <div class="alert alert-dismissible alert-secondary">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Błąd rejestracji</strong> Hasło musi zawierać przynajmniej 6 znaków
    </div>
    
    <?php
        }if($e['code'] == 20003)
        {
            ?>
    <div class="alert alert-dismissible alert-secondary">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Błąd rejestracji</strong> Hasło musi zawierać cyfrę
    </div><?php
        }
        if($e['code'] == 20004)
        {
            ?>
    <div class="alert alert-dismissible alert-secondary">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Błąd rejestracji</strong> Numer telefonu jest za krótki
    </div><?php
        }
        if($e['code'] == 20005)
        {
            ?>
    <div class="alert alert-dismissible alert-secondary">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <strong>Błąd rejestracji</strong> Hasła się różnią
    </div><?php
        }
    }
}
    ?>
<script>
window.setTimeout(function() {
    $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
    });
}, 2000);
</script>
</div><?php


if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['powrot']))
{
    func();
}
function func()
{
    header( 'Location: index.php?page=logowanie');
    exit;    
}
?>
