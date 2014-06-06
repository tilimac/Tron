/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    var ip = $("#ip").val();
    var port = $("#port").val();
    var wsUri = "ws://"+ip+":"+port+"/Controller/serverController.php";
    
    //var wsUri = "ws://192.168.0.108:15645/Controller/serverController.php";
    websocket = new WebSocket(wsUri);

    websocket.onopen = function(ev) { // connection is open 
        $('#message_box').append("<div class=\"system_msg\">Connecté !</div>"); //notify user
        
        
        //init(2);
    }

    $('#sendMsg').submit(function() { //use clicks message send button	
        var mymessage = $('#message').val(); //get message text
        var myname = $('#name').val(); //get user name

        if (myname == "") { //empty name?
            alert("Veuillez saisir un pseudo !");
            return false;
        }
        if (mymessage == "") { //emtpy message?
            alert("Pas de message!");
            return false;
        }

        //prepare json data
        var msg = {
            message: mymessage,
            name: myname,
            color: $("#color").val()
        };
        //convert and send data to server
        websocket.send(JSON.stringify(msg));
        $('#message').val(''); //reset text
        
        return false;
    });

    //#### Message received from server?
    websocket.onmessage = function(ev) {
        var msg = JSON.parse(ev.data);
        var type = msg.type;

        if (type == 'usermsg') {
            
                    //<p><span>Tilimac : </span>aaags dfg sdfg sdfg aaags dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg</p>
            $('#message_box').append("<p><span style=\"color:#" + msg.color + "\">" + msg.name + " :</span> " + msg.message + "</p>");
            //$('#message_box').append("<div><span class=\"user_name\" style=\"color:#" + ucolor + "\">" + uname + "</span> : <span class=\"user_message\">" + umsg + "</span></div>");
        }
        if (type == 'system') {
            //$('#message_box').append("<div class=\"system_msg\">" + umsg + "</div>");
        }
        if (type == 'newPos') {
            console.log(msg.id);
            console.log(msg.dir);
            console.log(msg.dir);
        }


        //
    };

    websocket.onerror = function(ev) {
        $('#message_box').append("<div class=\"system_error\">Error Occurred - " + ev.data + "</div>");
    };
    websocket.onclose = function(ev) {
        $('#message_box').append("<div class=\"system_msg\">Connection Fermé</div>");
    };




    $(window).keydown(function( event ) {
        /*console.log(String.fromCharCode(event.which));*/
        console.log(event.which);

        if(event.which == 37 || event.which == 39) {
            if(event.which == 37) {
                var msg = {
                    id: 123,
                    dir: 'left'
                };
            }
            if(event.which == 39) {
                var msg = {
                    id: 123,
                    dir: 'left'
                };
            }
            //convert and send data to server
            websocket.send(JSON.stringify(msg));
        }
    });



    function init(nbPlayer){
        var pions = [[5,5,'right'],[44,44,'left'],[5,44,'up'],[44,5,'down']];
        for (var i = 0; i < nbPlayer; i++) {
            var player = "pionJ"+(i+1);
            /*console.log("x="+pions[i][0]);
            console.log("y="+pions[i][1]);
            console.log($("#x"+pions[i][0]+"_y"+pions[i][1]));*/
            //prepare json data
            var msg = {
                aaaaaaaaaaaaa: "test",
                bbbbbb: "test",
                ccccccc: "test"
            };
            //convert and send data to server
            console.log(websocket);
            websocket.send(JSON.stringify(msg));
            $("#x"+pions[i][0]+"_y"+pions[i][1]).addClass(player);
        }
    }
    function moveLeft(pion){

    }
    function moveRight(pion){

    }
    function moveUp(pion){

    }
    function moveDown(pion){

    }


});