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
                                <input type="text" name="login" id="register_form" class="form-control input-md" placeholder="Login" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-sm-4 col-md-4 col-xs-offset-2 col-sm-offset-2 col-md-offset-2">
                            <div class="form-group">
                                <input type="password" name="haslo1" id="register_form" class="form-control input-md" placeholder="Hasło" required>
                            </div>
                        </div>
                        <div class="col-xs-4 col-sm-4 col-md-4">
                            <div class="form-group">
                                <input type="password" name="haslo2" id="register_form" class="form-control input-md" placeholder="Powtórz hasło" required>
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
                                <input type="number" name="nrTel" id="register_form" class="form-control input-md" placeholder="Numer telefonu" required>
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
require_once "polaczenie.php";
if (isset($_POST['rejestruj'])){
    try
    {
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
            if($e['code'] == 00001)
            {
                echo '00001';
            }
            if($e['code'] == 20001)
            {
                echo '20001';
            }
            if($e['code'] == 20002)
            {
                echo '20002';
            }if($e['code'] == 20003)
            {
                echo '20003';
            }
            if($e['code'] == 20004)
            {
                echo '20004';
            }
            if($e['code'] == 20005)
            {
                echo '20005';
            }
        }
    }
    catch(Exception $error)
    {
        echo 'Błąd serwera!';
        echo '<br/>Informacja dewelopreska: '.$error;
    }
}

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['powrot']))
{
    func();
}
function func()
{
    session_start();
    session_destroy();
    header( 'Location: index.php?page=logowanie');
    exit;    
}
?>
