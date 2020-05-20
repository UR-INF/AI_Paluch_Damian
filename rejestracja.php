<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">

</head>
<body>
<div class="center">

<div id="panel">
    <form method="POST"> 
        <label for="username">Login:</label>
        <input type="text" id="username" name="username">
        <label for="password">Hasło:</label>
        <input type="password" id="password" name="password">
        <label for="imie">Imię:</label>
        <input type="text" id="imie" name="imie">
        <label for="nazwisko">Nazwisko:</label>
        <input type="text" id="nazwisko" name="nazwisko">
        <label for="nrTel">Numer telefonu:</label>
        <input type="text" id="nrTel" name="nrTel">
 
        <div id="lower">
            
   
             <input type="submit" value="Zarejestruj" /> 
            <input type="submit" name="powrot" value="Powrót" /> 
        </div>
    </form>
</div>

</div>
</body>
    <?php
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
</html>