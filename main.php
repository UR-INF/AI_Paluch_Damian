
<div class="login_container">
    <div class="spacer"></div>
    <div class="row card_main_top" style="height:60px; width:100%">  
                <div id="card_main_top_element_nick">
                    Zalogowano jako:<center><?php echo $_SESSION["nick"]; ?></center> 
                </div>
                <div id="card_main_top_element_button">
                    <form action="main.php" method="post">
                        <input type="submit" name="logout" value="Wyloguj się" class="btn logout_btn"/>
                    </form>
                </div>
    </div>
    <div>
		<div class="col-md-3 col-xl-3 col-xs-3 chat">
            <div class="card_main mb-sm-3 mb-md-0 ">
				<div class="card-header">
						head
				    </div>
                
				<div class="card-body contacts_body">
						body
				    </div>
                
				<div class="card-footer">
                        footer    
                    </div>
            </div>
        </div>
                
        <div class="col-md-9 col-xl-9 col-xs-9 chat">
            <div class="card_main">
				<div class="card-header msg_head">
					   header		
				    </div>
                
				<div class="card-body msg_card_body">
				        body
				    </div>
                
				<div class="card-footer">
				        footer
					</div>
            </div>
        </div>
    </div>
</div>







<?php

    if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['logout']))
    {
        func();
    }
    function func()
    {
        session_start();
        session_destroy();
        header( 'Location: index.php?page=login');
        exit;    
    }
?>