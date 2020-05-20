
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
                        <input type="text" name= "nick" class="form-control" placeholder="username" required>

                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-key"></i></span>
                        </div>
                        <input type="password" name="haslo" class="form-control" placeholder="password" required>
                    </div>
                    <div class="input-group form-group">
                        <div class="input-group-prepend">
                            <br>
                        </div>
                        <select class="form-control form-control-lg">
                            <option>Klient</option>
                            <option>Mechanik</option>
                            <option>Administrator</option>
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
    </div>
</div>

<?php
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

