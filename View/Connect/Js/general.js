/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function() {
    
    $("#server").change(function(){
        if($(this).val() == "connect"){
            $("#addrIp").show();
            //$("#port").show();
            $("#addrIp input").prop('required',true);
            //$("#port input").prop('required',true);
        }
        else{
            $("#addrIp").hide();
            //$("#port").hide();
            $("#addrIp input").val('');
            //$("#port input").val('');
            $("#addrIp input").prop('required',false);
            //$("#port input").prop('required',false);
        }
    });
    
    $("#connectGame").submit(function(){
        var type = $("#server").val();
        var port = $("#port").val();
        
        if(type == "newServer") window.open("serverController.php?port="+port);
        
        $.ajax({
            type: "POST",
            data:$(this).serialize(),
            url:"clientController.php",
            dataType: "html",
            complete:function(data){
                $('#contentPage').html(data.responseText);
            }
        });
        //$('body').load("clientController.php",$(this).serialize());
        
        return false;
    });
});