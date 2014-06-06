<?php
header('Content-Type: text/html; charset=utf-8');

/**
 * [10061] Aucune connexion na pu être établie car lordinateur cible la expressément refusée. (serveur eteint)
 * [10049] Ladresse demandée nest pas valide dans son contexte. (erreur format ip ou port)
 */

$errorcode = NULL;
if(isset($_POST['server'])){
    $host = ($_POST['server'] == "connect") ? $_POST['ip'][0].'.'.$_POST['ip'][1].'.'.$_POST['ip'][2].'.'.$_POST['ip'][3] : 'localhost';
    $port = $_POST['port'];

    //echo "Message envoye :".$_POST['message'];
    $socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        $errorcode = socket_last_error();
        $errormsg = utf8_encode(socket_strerror($errorcode));
        
        //var_dump("Impossible de créer le socket : [$errorcode] ".  utf8_encode($errormsg));
    }
    else {
        $result = @socket_connect($socket, $host, $port);
        if ($result === false) {
            $errorcode = socket_last_error();
            $errormsg = utf8_encode(socket_strerror($errorcode));
        }
        else{
            socket_write($socket, "init", 4);
            $result = utf8_encode(socket_read($socket, 1024));
            var_dump($result);
        }
    }
    
    socket_close($socket);
}
    

if(isset($_POST['pseudo']) && is_null($errorcode)){
    require_once './Controller/gameController.php';
}
else {
    require_once './Controller/connectController.php';
}