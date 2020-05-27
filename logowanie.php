
<div class="login_container">
    <div class="d-flex justify-content-center h-100">
        <div class="card">
            <div class="card-header">
                <center><h3>Zaloguj się</h3></center>
            </div>
            <div class="card-body">
                <form method="POST"> 
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                        </div>
                        <input type="text" name= "login" class="form-control" placeholder="Login" required>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="haslo" class="form-control" placeholder="Hasło" required>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <br>
                        </div>
                        <select name="konto" class="form-control form-control-lg">
                            <option value="klient">Klient</option>
                            <option value="mechanik">Mechanik</option>
                            <option value="administrator">Administrator</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <input type="submit" value="Zaloguj" name="logowanie" class="btn float-right login_btn">
                    </div>
                </form>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-center links">
                    Nie posiadasz konta?<a href="index.php?page=rejestracja">Zarejestruj się</a>
                </div>

            </div>
        </div>

        <?php

        if(isset($_POST['logowanie']))
        {
            @zaloguj();


        }
        function zaloguj(){
            require_once "polaczenie.php";
            $conn = oci_connect($login, $haslo, $host);
            if(!$conn)
            {
                $m = oci_error();
                echo $m['message'], "\n";
                exit;   
            }

            if($_POST['konto'] == 'klient')
            {
                $query = "begin logowanie.klient_logowanie(:login, :haslo); end;";

                $login = $_POST['login'];
                $haslo = $_POST['haslo'];
                $stid = oci_parse($conn, $query);

                oci_bind_by_name($stid, ":login", $login);
                oci_bind_by_name($stid, ":haslo", $haslo);
                $result = oci_execute($stid);

                if(true === $result)
                {
                    $query = "select k.id, k.imie, k.nazwisko from klienci k, klienci_uzytkownicy ku where ku.login = '$login'and ku.haslo = '$haslo'";
                    $stid = oci_parse($conn, $query);
                    $result = oci_execute($stid);
                    $row =oci_fetch_array($stid);
                    $_SESSION['id'] = $row['ID'];
                    $_SESSION['imie'] = $row['IMIE'];
                    $_SESSION['nazwisko'] = $row['NAZWISKO'];
                    $_SESSION['zalogowany'] = 'klient';
                    header("Location: index.php?page=klienci");
                }
                if(false === $result){
                    $e = oci_error($stid);
                    if($e['code'] == 20000)
                    {?>
        <div class="alert alert-dismissible alert-secondary">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Błąd logowania</strong> Podałeś błędne dane
        </div> <?php
                    }
                }
            }else if($_POST['konto'] == 'mechanik')
            {
                $query = "begin logowanie.mechanik_logowanie(:login, :haslo); end;";

                $login = $_POST['login'];
                $haslo = $_POST['haslo'];
                $stid = oci_parse($conn, $query);

                oci_bind_by_name($stid, ":login", $login);
                oci_bind_by_name($stid, ":haslo", $haslo);
                $result = oci_execute($stid);
                if(true === $result)
                {
                    $query = "select p.id, p.imie, p.nazwisko from pracownicy p, pracownicy_uzytkownicy pu where pu.login = '$login'and pu.haslo = '$haslo' and p.id_uzytkownika = pu.id";
                    $stid = oci_parse($conn, $query);
                    $result = oci_execute($stid);
                    $row =oci_fetch_array($stid);
                    $_SESSION['id'] = $row['ID'];
                    $_SESSION['imie'] = $row['IMIE'];
                    $_SESSION['nazwisko'] = $row['NAZWISKO'];
                    $_SESSION['zalogowany'] = 'mechanik';
                    header("Location: index.php?page=mechanicy");
                }
                if(false === $result){
                    $e = oci_error($stid);
                    if($e['code'] == 20000)
                    {?>
        <div class="alert alert-dismissible alert-secondary">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Błąd logowania</strong> Podałeś błędne dane
        </div> <?php
                    }
                }
            }else if($_POST['konto'] == 'administrator')
            {
                $query = "begin logowanie.administrator_logowanie(:login, :haslo); end;";

                $login = $_POST['login'];
                $haslo = $_POST['haslo'];
                $stid = oci_parse($conn, $query);

                oci_bind_by_name($stid, ":login", $login);
                oci_bind_by_name($stid, ":haslo", $haslo);
                $result = oci_execute($stid);
                if(true === $result)
                {
                    $query = "select p.id, p.imie, p.nazwisko from pracownicy p, pracownicy_uzytkownicy pu where pu.login = '$login'and pu.haslo = '$haslo' and p.id_uzytkownika = pu.id";
                    $stid = oci_parse($conn, $query);
                    $result = oci_execute($stid);
                    $row =oci_fetch_array($stid);
                    $_SESSION['id'] = $row['ID'];
                    $_SESSION['imie'] = $row['IMIE'];
                    $_SESSION['nazwisko'] = $row['NAZWISKO'];
                    $_SESSION['zalogowany'] = 'administrator';
                    header("Location: index.php?page=administratorzy");
                }
                if(false === $result){
                    $e = oci_error($stid);
                    if($e['code'] == 20000)
                    {?>
        <div class="alert alert-dismissible alert-secondary">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Błąd logowania</strong> Podałeś błędne dane
        </div> <?php
                    }
                }
            }
        }
        if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['rejestracja']))
        {
            func();
        }
        function func()
        {
            session_start();
            session_destroy();
            header( 'Location: index.php?page=rejestracja');
            exit;    
        }
        ?>

    </div>
</div>
