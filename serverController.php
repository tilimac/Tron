<?php

$host = 'localhost';
$port = $_GET['port'];
$null = NULL;

set_time_limit(0);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);
socket_bind($socket, 0, $port);
socket_listen($socket);


$clients = array($socket);
//$infoClients = array('',array('x'=>5,'y'=>5,'dir'=>'right'),array('x'=>44,'y'=>44,'dir'=>'left'),array('x'=>5,'y'=>44,'dir'=>'up'),array('x'=>44,'y'=>5,'dir'=>'down'),array('x'=>5,'y'=>22,'dir'=>'up'),array('x'=>22,'y'=>5,'dir'=>'down'));
$infoClients = array('');
$playerInfos = array(1=>array('x'=>5,'y'=>5,'dir'=>'right'),2=>array('x'=>44,'y'=>44,'dir'=>'left'),3=>array('x'=>5,'y'=>44,'dir'=>'up'),4=>array('x'=>44,'y'=>5,'dir'=>'down'),5=>array('x'=>5,'y'=>24,'dir'=>'right'),6=>array('x'=>44,'y'=>25,'dir'=>'left'));
$playerAvailable = array(1=>true,2=>true,3=>true,4=>true,5=>true,6=>true);
$colors = array("E26A6A"=>"bgRouge","FBE781"=>"bgJaune","F8AC0C"=>"bgOrange","73ECB0"=>"bgVert","5CAAD0"=>"bgBleu","8570EB"=>"bgViolet","FB89FB"=>"bgRose");


$synchroMove = array(1=>true,2=>true,3=>true,4=>true,5=>true,6=>true);
$deplacement = array(1=>array('direction'=>'right','living'=>'0'),2=>array('direction'=>'left','living'=>'0'),3=>array('direction'=>'up','living'=>'0'),4=>array('direction'=>'down','living'=>'0'),5=>array('direction'=>'up','living'=>'0'),6=>array('direction'=>'down','living'=>'0'));

$classement = array();
$startGame = false;

while (true) {
    $changed = $clients;
    socket_select($changed, $null, $null, 0, 10);

    if (in_array($socket, $changed)) {
        $socket_new = socket_accept($socket); 
        $clients[] = $socket_new; 

        $header = socket_read($socket_new, 1024);
        
        if($header == "init"){
            $msg = mask(json_encode(array('nbClient' => count($clients)-1,'infoClients'=>$infoClients)));
            @socket_write($socket_new, $msg, strlen($msg));
        }
        else {
            perform_handshaking($header, $socket_new, $host, $port);

            socket_getpeername($socket_new, $ip);
            $response = mask(json_encode(array('type' => 'system', 'message' => $ip . ' s\'est connecté')));
            send_message($response);
        }
        $found_socket = array_search($socket, $changed);
        unset($changed[$found_socket]);
    }

    foreach ($changed as $id=>$changed_socket) {

        while (socket_recv($changed_socket, $buf, 1024, 0) >= 1) {
            $received_text = unmask($buf); //unmask data
            $tst_msg = json_decode($received_text); //json decode 
            if($received_text == ""){//Va etre utilisé pour la fermeture d'une socket en js
                $response = mask(json_encode(array('type' => 'system', 'message' => '<span style="color:#'.$infoClients[$id/2]['color'].' ">'.$infoClients[$id/2]['name'].'</span> s\'est déconnecté')));
                send_message($response);
                $response_text = mask(json_encode(array('type' => 'removePlayer', 'num' => $infoClients[$id/2]['num'])));
                send_message($response_text);
                $playerAvailable[$infoClients[$id/2]['num']] = true;
                $synchroMove[$infoClients[$id/2]['num']] = true;
                unset($clients[$id]);
                unset($infoClients[$id/2]);
                /*$response_text = mask(json_encode(array('type' => 'initPlayer', 'clients' => $infoClients)));
                send_message($response_text);*/
                break 2;
            }
            
            switch ($tst_msg->type) {
                case 'message':
                    if($tst_msg->message == "stopSrv"){
                        break 4;
                    }
                    if($tst_msg->message == "startGame"){
                        $startGame = true;
                        $response_text = mask(json_encode(array('type' => 'deplacement','infoDeplacement'=>$deplacement)));
                        send_message($response_text);
                        break 3;
                    }
                    if($tst_msg->message == "initGame"){
                        for ($index = 1; $index < count($infoClients); $index++) {
                            $synchroMove[$index] = false;
                        }
                        $startGame = false;
                        $classement = array();
                        $response_text = mask(json_encode(array('type' => 'initPlayer', 'clients' => $infoClients)));
                        send_message($response_text);
                        break 3;
                    }
                    $response_text = mask(json_encode(array('type' => 'message', 'name' => $tst_msg->name, 'message' => $tst_msg->message, 'color' => $tst_msg->color)));
                    send_message($response_text);
                break;
                case 'initPlayer':
                    $infoClients[$id/2]['name'] = $tst_msg->name;
                    $infoClients[$id/2]['color'] = $tst_msg->color;
                    $infoClients[$id/2]['colorName'] = $colors[$tst_msg->color];
                    foreach ($playerAvailable as $num => $available) {
                        if($available){
                            $infoClients[$id/2]['num'] = $num;
                            $playerAvailable[$num] = false;
                            $synchroMove[$num] = false;
                            break;
                        }
                    }
                    $infoClients[$id/2]['pion'] = $playerInfos[$infoClients[$id/2]['num']];
                    $response_text = mask(json_encode(array('type' => 'initPlayer', 'clients' => $infoClients)));
                    send_message($response_text);
                break;
                case 'deplacement':
                    $synchroMove[$tst_msg->numPlayer] = true;
                    $deplacement[$tst_msg->numPlayer]['direction'] = $tst_msg->dirPlayer;
                    $deplacement[$tst_msg->numPlayer]['living'] = $tst_msg->living;
                    if($tst_msg->living == "0" && !in_array_r($infoClients[$tst_msg->numPlayer]['name'], $classement)){
                        $response_text = mask(json_encode(array('type' => 'removePlayer', 'num' => $infoClients[$tst_msg->numPlayer]['num'])));
                        send_message($response_text);
                        $infoCasssement = array();
                        $infoCasssement['name'] = $infoClients[$tst_msg->numPlayer]['name'];
                        $infoCasssement['color'] = $infoClients[$tst_msg->numPlayer]['color'];
                        $classement[] = $infoCasssement;
                    }
                    
                    $deplaceAll = true;
                    foreach ($synchroMove as $numPlayer => $validMove) {
                        if(!$validMove){
                            $deplaceAll = false;
                        }
                    }
                    if($deplaceAll && $startGame){
                        if(count($classement)<(count($infoClients)-2)){
                            $response_text = mask(json_encode(array('type' => 'deplacement','infoDeplacement'=>$deplacement)));
                            usleep(100000);//Vitesse de déplacement (0.1 sec)
                            send_message($response_text);
                            for ($index = 1; $index < count($infoClients); $index++) {
                                $synchroMove[$index] = false;
                            }
                        }
                        else{
                            //$infoClients[$id]['num']
                            foreach ($infoClients as $client) {
                                if(is_array($client) && !in_array_r($client['name'], $classement)){
                                    $infoCasssement = array();
                                    $infoCasssement['name'] = $client['name'];
                                    $infoCasssement['color'] = $client['color'];
                                    $classement[] = $infoCasssement;
                                }
                            }
                            $response_text = mask(json_encode(array('type' => 'classement','classement'=>array_reverse($classement))));
                            send_message($response_text);
                        }
                    }
                break;
            }
            break 2;
        }

        $buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
        if ($buf === false) { //Va etre utilisé seulement pour la fermeture d'une socket en php
            // remove client  $clients array
            $found_socket = array_search($changed_socket, $clients);
            socket_getpeername($changed_socket, $ip);
            unset($clients[$found_socket]);
            unset($infoClients[$found_socket]);

            
            /*$response = mask(json_encode(array('type' => 'system', 'message' => $ip . ' disconnected')));
            send_message($response);*/
        }
    }
}
socket_close($socket);

function send_message($msg) {
    global $clients;
    foreach ($clients as $changed_socket) {
        @socket_write($changed_socket, $msg, strlen($msg));
    }
    return true;
}


function unmask($text) {
    $length = ord($text[1]) & 127;
    if ($length == 126) {
        $masks = substr($text, 4, 4);
        $data = substr($text, 8);
    } elseif ($length == 127) {
        $masks = substr($text, 10, 4);
        $data = substr($text, 14);
    } else {
        $masks = substr($text, 2, 4);
        $data = substr($text, 6);
    }
    $text = "";
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i % 4];
    }
    return $text;
}


function mask($text) {
    $b1 = 0x80 | (0x1 & 0x0f);
    $length = strlen($text);

    if ($length <= 125)
        $header = pack('CC', $b1, $length);
    elseif ($length > 125 && $length < 65536)
        $header = pack('CCn', $b1, 126, $length);
    elseif ($length >= 65536)
        $header = pack('CCNN', $b1, 127, $length);
    return $header . $text;
}


function perform_handshaking($receved_header, $client_conn, $host, $port) {
    $headers = array();
    $lines = preg_split("/\r\n/", $receved_header);
    foreach ($lines as $line) {
        $line = chop($line);
        if (preg_match('/\A(\S+): (.*)\z/', $line, $matches)) {
            $headers[$matches[1]] = $matches[2];
        }
    }

    $secKey = $headers['Sec-WebSocket-Key'];
    $secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
    //hand shaking header
    $upgrade = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "WebSocket-Origin: $host\r\n" .
            "WebSocket-Location: ws://$host:$port/demo/shout.php\r\n" .
            "Sec-WebSocket-Accept:$secAccept\r\n\r\n";
    socket_write($client_conn, $upgrade, strlen($upgrade));
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}