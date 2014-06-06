<?php
$host = "127.0.0.1";
$port = 11245;

set_time_limit(0);

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

$result = socket_bind($socket, $host, $port);

$result = socket_listen($socket, 3);

$clients = array($socket);

for ($i = 0; $i < 10; $i++) {
    $changed = $clients;
    socket_select($changed, $null, $null, 0, 10);
    if (in_array($socket, $changed)) {
        $socket_new = socket_accept($socket); //accpet new socket
        $clients[] = $socket_new; //add socket to client array
        
        $header = socket_read($socket_new, 1024); //read data sent by the socket
        perform_handshaking($header, $socket_new, $host, $port); //perform websocket handshake
        var_dump($header);
    }
    
    sleep(1);
}



//$spawn = socket_accept($socket) or die("Could not accept incoming connection\n");

/*$finish = false;
while (!$finish){

    $result = socket_listen($socket, 3);
    
    
    $input = socket_read($spawn, 1024) or die("Could not read input\n");

    $input = trim($input);
    echo "Client Message : ".$input."<br />";
    
    //$output = strrev($input) ."<br />";
    socket_write($spawn, $input, strlen ($input)) or die("Could not write output\n");
    if($input == "stop"){
        $finish = true;
    }
}*/

//socket_close($spawn);
socket_close($socket);






function send_message($msg) {
    global $clients;
    foreach ($clients as $changed_socket) {
        @socket_write($changed_socket, $msg, strlen($msg));
    }
    return true;
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

?>