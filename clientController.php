<?php
/**
 * [10061] Aucune connexion na pu être établie car lordinateur cible la expressément refusée. (serveur eteint)
 * [10049] Ladresse demandée nest pas valide dans son contexte. (erreur format ip ou port)
 */
$errorMsg = array(
    100=>"Limite d'utilisateur atteint.",
    101=>"Ce pseudo est déja utilisé.",
    102=>"Cette couleur a déja été utilisé.",
    10061=>"Impossible de se connecté ou serveur éteint.",
    10049=>"Format de l'adresse est incorrecte."
);
$arrayColor = array('E26A6A','FBE781','F8AC0C','73ECB0','5CAAD0','8570EB','FB89FB');


$errorcode = NULL;
if(isset($_POST['server'])){
    $host = ($_POST['server'] == "connect") ? $_POST['ip'][0].'.'.$_POST['ip'][1].'.'.$_POST['ip'][2].'.'.$_POST['ip'][3] : 'localhost';
    $port = $_POST['port'];

    //echo "Message envoye :".$_POST['message'];
    $socket = @socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if($socket === false) {
        $errorcode = socket_last_error();
        $errormsg = $errorMsg[$errorcode];//socket_strerror($errorcode)
        
        //var_dump("Impossible de créer le socket : [$errorcode] ".  utf8_encode($errormsg));
    }
    else {
        $result = @socket_connect($socket, $host, $port);
        if ($result === false) {
            $errorcode = socket_last_error();
            $errormsg = $errorMsg[$errorcode];
        }
        else{
            socket_write($socket, "init", 4);
            $result = utf8_encode(socket_read($socket, 1024));
            $findme = '{';
            $pos = strpos($result, $findme);
            $infoUsers = json_decode(substr($result,$pos,strlen($result))); 
            
            $colorUsed = array();
            $pseudoUsed = array();
            foreach ($infoUsers->infoClients as $key => $value) {
                if($value != ""){
                    $colorUsed[] = $value->color;
                    $pseudoUsed[] = $value->name;
                }
            }
            
            $color = ($_POST['color'] == "rand") ? $arrayColor[array_rand(array_diff($arrayColor,$colorUsed))] : $_POST['color'];
            if($infoUsers->nbClient > 6){
                $errorcode = 100;
                $errormsg = $errorMsg[$errorcode];
            }
            elseif(in_array($_POST['pseudo'], $pseudoUsed)){
                $errorcode = 101;
                $errormsg = $errorMsg[$errorcode];
            }
            elseif(in_array($color, $colorUsed)){
                $errorcode = 102;
                $errormsg = $errorMsg[$errorcode];
            }
        }
    }
    
    socket_close($socket);
}

if(isset($_POST['pseudo']) && is_null($errorcode)){
    $infoPlayer = array("pseudo"=>$_POST['pseudo'],"color"=>$color);
    $infoServer = array("type"=>$_POST['server'],"ip"=>$host,"port"=>$port);

    require_once 'View/Game/index.php';
}
else {
    require_once 'View/Connect/index.php';
}


