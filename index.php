<!DOCTYPE HTML>
<html lang="pl">
<head>
       
	<meta charset="utf-8"/>
    <meta name="description" content="Warsztat">
    <meta name="author" content="Damian Paluch">
    <meta name="robots" content="index">
 	<title>Warsztat samochodowy</title>	   
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--------------------------CZCIONKI--------------------->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,700&subset=latin-ext" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Lato:400,100,900,700' rel='stylesheet' type='text/css'>
    <link href="https://fonts.googleapis.com/css?family=Poiret+One" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Libre+Franklin" rel="stylesheet">
    
    <!--------------------------CSS--------------------->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    
    <link rel="stylesheet" href="css/jquery-ui.min.css" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!--------------------------SCRIPTS------------------>
    <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <!----------------------WLASNY_CSS--------------------->
    <link rel="stylesheet" href="css/style.css">
    


</head>    
<body>
    <?php
   
    
    session_start();
    
        //$current_page = isset($_GET['page']) ? $_GET['page'] : null; 
        if(isset($_SESSION["zalogowany"])==true){
            if($_SESSION["zalogowany"]==true)
            $current_page = 'logowanie';
        }else{
            $current_page = isset($_GET['page']) ? $_GET['page'] : null;
        }

        
		switch ($current_page) 
		{
			case 'logowanie':
                default;
				include 'logowanie.php';
				break;
			case 'rejestracja':
				include 'rejestracja.php';
				break;
			case 'klienci':
				include 'klienci.php';
				break;
            case 'edycjaDanych':
                include 'edycjaDanych.php';
                break;
            case 'password_forgot':
                include 'password_forgot.php';
                break;
            case 'password_reset':
                include 'password_reset.php';
                break;
        }
		
?>
</body>    
</html>