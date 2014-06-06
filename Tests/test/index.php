<?php

/*
 * PHP Sockets - How to create a sockets server/client 
 */

//include the server.php script to start the server
//include_once('server.php');


if(isset($_POST['message'])){
    $host    = "127.0.0.1";
    $port    = 11245;


    //echo "Message envoye :".$_POST['message'];
    
    $socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");
    
    $result = socket_connect($socket, $host, $port) or die("Could not connect to server\n");  
    
    socket_write($socket, $_POST['message'], strlen($_POST['message'])) or die("Could not send data to server\n");
    
    /*$result = socket_read ($socket, 1024) or die("Could not read server response\n");
    echo "<br />";
    echo "Réponse du serveur  :".$result;*/
    
    socket_close($socket);
    
}
?>


<html>
    <head>
        
    </head>
    <body>
        <form action="" method="post">
            <input name="message"/> 
            <input type="submit"/> 
            
        </form>
    </body>
</html>