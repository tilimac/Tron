<html>
    <head>
        
        
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <style>
            @font-face {
                font-family: "Tron";
                src: url('Tr2n.ttf');
            }
            body{
                background-image:url('fondTron.jpg');
                background-size: cover;
                background-repeat: no-repeat;
                background-color: black;
            }
            table{
                position: absolute;
                top: 50%;
                left: 50%;
                margin: -200px;
                //margin-left: ;
                width:400px;
                height:400px;
                background-color: #001B26;
                border: 3px solid white;
                box-shadow: 1px 1px 10px #FFFFFF;
                border-collapse: collapse;
            }
            td{
                border: 1px solid #193138;
                empty-cells: show;
            }
            .character{
                background-image: url("skins.png");
                background-position: -200px center;
                background-repeat: no-repeat;
                color: #FDEC94; /*change selon joueur*/
                font-family: "Tron",Helvetica,Arial,sans-serif;
                font-size: 30px;
                font-weight: bold;
                height: 600px;
                left: 50%;
                margin-left: -500px;
                position: absolute;
                text-align: center;
                text-shadow: 0 0 0.03em #FFFFFF;
                top: 10%;
                width: 200px;
            }
            .chat{
                background-color: rgba(0, 0, 0, 0.8);
                border: 3px solid #FFFFFF;
                bottom: 10%;
                box-shadow: 1px 1px 10px #FFFFFF;
                position: absolute;
                right: 30px;
                top: 10%;
                width: 25%;
                padding: 20px;
            }
            .content{
                height: 100%;
                position: relative;
            }
            .chat .input-group{
                bottom: 0;
                position: absolute;
                width: 100%;
            }
            .chat .message{
                width: 100%;
                top: 0;
                bottom: 50px;
                position: absolute;
                border-bottom: 3px solid #FFFFFF;
                padding: 10px;
                color: #FFFFFF;
                overflow-y: scroll;
            }
            .chat .shadow{
                top: 0;
                left: -20px;
                right: 17px;
                bottom: 53px;
                position: absolute;
                -moz-box-shadow: inset 0px 0px 10px 10px #000000;
                -webkit-box-shadow: inset 0px 0px 10px 10px #000000;
                -o-box-shadow: inset 0px 0px 10px 10px #000000;
                box-shadow: inset 0px 0px 10px 10px #000000;
                filter:progid:DXImageTransform.Microsoft.Shadow(color=#000000, Direction=NaN, Strength=10);
            }
            .chat .message span {
                text-decoration:underline;
                color: #FDEC94;/*change selon joueur*/
            }
        </style>
    </head>
    <body>
        <table>
            <?php for ($i = 0; $i < 50; $i++) { ?>
                <tr>
                    <?php for ($j = 0; $j < 50; $j++) { ?>
                        <td></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
        <div class="character">Tilimac</div>
        <div class="chat">
            <div class="content">
                <div class="message">
                    <p><span>Tilimac : </span>aaags dfg sdfg sdfg aaags dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg</p>
                    <p><span>Tilimac : </span>aaags dfg sdfg sdfg aaags dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg</p>
                    <p><span>Tilimac : </span>aaags dfg sdfg sdfg aaags dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg</p>
                    <p><span>Tilimac : </span>aaags dfg sdfg sdfg aaags dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg</p>
                    <p><span>Tilimac : </span>aaags dfg sdfg sdfg aaags dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg</p>
                    <p><span>Tilimac : </span>aaags dfg sdfg sdfg aaags dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg</p>
                    <p><span>Tilimac : </span>aaags dfg sdfg sdfg aaags dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg</p>
                    <p><span>Tilimac : </span>aaags dfg sdfg sdfg aaags dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg dfg sdfg sdfg</p>
                </div>
                <div class="shadow"></div>
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Message">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="button">Envoyer</button>
                    </span>
                </div>
            </div>
        </div>
    </body>
</html>