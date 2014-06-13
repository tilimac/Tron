/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function() {
    var name = $("#name").val();
    var color = $("#color").val();
    var ip = $("#ip").val();
    var port = $("#port").val();
    var wsUri = "ws://"+ip+":"+port+"/serverController.php";
    
    //var wsUri = "ws://192.168.0.108:15645/serverController.php";
    websocket = new WebSocket(wsUri);

    websocket.onopen = function(ev) { // connection is open 
        $('#message_box').append("<div class=\"system_msg\">Connecté !</div>"); //notify user
        
        //var pions = [[5,5,'right'],[44,44,'left'],[5,44,'up'],[44,5,'down']];
        websocket.send(JSON.stringify({type: "initPlayer",name:name,color:color}));
    }

    $('#startGame').click(function() {
        var msg = {
            type: 'message',
            message: 'startGame'
        };
        websocket.send(JSON.stringify(msg));
    });

    $('#stopSrv').click(function() {
        var msg = {
            type: 'message',
            message: 'stopSrv'
        };
        websocket.send(JSON.stringify(msg));
    });

    $('#initGame').click(function() {
        var msg = {
            type: 'message',
            message: 'initGame'
        };
        websocket.send(JSON.stringify(msg));
    });

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
            type: 'message',
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

        if (type == 'message') {
            $('#message_box').append("<p><span style=\"color:#" + msg.color + "\">" + msg.name + " :</span> " + msg.message + "</p>");
        }
        if (type == 'initPlayer') {
            $('td').removeClass();
            $.each(msg.clients, function(index, client) {
                if(client != ""){
                    if(client.name == name){
                        $("#name").data('num',client.num);
                        $("#name").data('dir',client.pion.dir);
                        $("#name").data('living','1');
                    }
                    
                    $("#plateau tr:eq("+client.pion.y+") td:eq("+client.pion.x+")").addClass('used').addClass(client.colorName).addClass("numC_"+client.num).addClass('currentPion').data('color',client.colorName).data('x',client.pion.x).data('y',client.pion.y);
                }
            });
        }
        if (type == 'system') {
            $('#message_box').append("<div class=\"system_msg\">" + msg.message + "</div>");
        }
        if (type == 'deplacement') {
            var myNum = $("#name").data('num');
            var myLife = $("#name").data('living');
            
            $.each(msg.infoDeplacement, function(numPlayer, infoDep) {
                if(infoDep.living == "1"){
                    var infoPlayer = $(".numC_"+numPlayer+".currentPion");
                    var x = infoPlayer.data('x')*1;
                    var y = infoPlayer.data('y')*1;
                    var color = infoPlayer.data('color');
                    infoPlayer.removeClass('currentPion');

                    if(infoDep.direction=='left'){
                        x = x-1;
                    }
                    if(infoDep.direction=='right'){
                        x = x+1;
                    }
                    if(infoDep.direction=='up'){
                        y = y-1;
                    }
                    if(infoDep.direction=='down'){
                        y = y+1;
                    }

                    if(!(x<0 || x>=50 || y<0 || y>=50 || $("#plateau tr:eq("+y+") td:eq("+x+")").hasClass('used'))){
                        $("#plateau tr:eq("+y+") td:eq("+x+")").addClass('used').addClass(color).addClass("numC_"+numPlayer).addClass('currentPion').data('color',color).data('x',x).data('y',y);
                    }
                    else if(numPlayer == myNum){
                        myLife = '0';
                        //console.log('Je suis mort en : x='+x+' y='+y);
                    }
                }
            });
            
            $("#name").data('living',myLife);
            
            var msgServ = {
                type: 'deplacement',
                numPlayer: myNum,
                dirPlayer: $("#name").data('dir'),
                living: myLife
            };
            
            websocket.send(JSON.stringify(msgServ));
        }
        if (type == 'classement') {
            
            if(msg.classement[0].name == name){
                var test = '<p style="text-align: center; font-size: 30px; font-weight: bold; color: green;">Victoire</p>';
            }
            else{
                var test = '<p style="text-align: center; font-size: 30px; font-weight: bold; color: red;">Défaite</p>';
            }
            test += '<p>Voici le classement : </p><ol>';
            $.each(msg.classement, function(position, pos) {
                if(name != 'null') test += '<li style="color:'+pos.color+';">'+pos.name+'</li>';
            });
            test += '</ol>';
            $("#classement .modal-body").html(test);
            $("#classement").modal('show');
        }
        if (type == 'removePlayer') {
            console.log("td.numC_"+msg.num);
            console.log($("td.numC_"+msg.num));
            $("td.numC_"+msg.num).removeClass();
        }
    };

    websocket.onerror = function(ev) {
        $('#message_box').append("<div class=\"system_error\">Error Occurred - " + ev.data + "</div>");
    };
    websocket.onclose = function(ev) {
        $('#message_box').append("<div class=\"system_msg\">Connection Fermé, vous allez être redirigé dans quelque seconde.</div>");
        window.setTimeout(function() {
            location.reload();
        }, 5000);
        
    };
    

    function warning(){
        websocket.close();
    }
    window.onbeforeunload = warning;


    $(document).keydown(function( event ) {
        /*console.log(String.fromCharCode(event.which));*/
        //console.log(event.which);

        if(event.which == 37 || event.which == 39) {
            var oldDir = $("#name").data('dir');
            var newDir;
            
            if(event.which == 37) {
                if(oldDir=='left'){
                    newDir = 'down';
                }
                if(oldDir=='right'){
                    newDir = 'up';
                }
                if(oldDir=='up'){
                    newDir = 'left';
                }
                if(oldDir=='down'){
                    newDir = 'right';
                }
            }
            if(event.which == 39) {
                if(oldDir=='left'){
                    newDir = 'up';
                }
                if(oldDir=='right'){
                    newDir = 'down';
                }
                if(oldDir=='up'){
                    newDir = 'right';
                }
                if(oldDir=='down'){
                    newDir = 'left';
                }
            }
            $("#name").data('dir',newDir);
        }
    });





});