<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8' />
        
        
        <link rel="stylesheet" type="text/css" href="Library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="Header/Css/general.css">
        <link rel="stylesheet" type="text/css" href="View/Game/Css/general.css">
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="View/Game/Js/general.js"></script>
        <style>
            
        .character{
            background-position: -<?php echo ($infoPlayer['color']*2); ?>00px center; 
            color: #<?php echo $arrayColor[$infoPlayer['color']]; ?>;
        }
        </style>
    </head>
    <body>
        <input id="color" type="hidden" value="<?php echo $arrayColor[$infoPlayer['color']]; ?>" />
        <table>
            <?php for ($i = 0; $i < 50; $i++) { ?>
                <tr>
                    <?php for ($j = 0; $j < 50; $j++) { ?>
                        <td></td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </table>
        <div class="character"><?php echo $infoPlayer['pseudo']; ?></div>
        <div class="chat">
            <form id="sendMsg" class="content" method="post">
                <div class="message-box" id="message_box">
                </div>
                <div class="shadow"></div>
                <div class="input-group">
                    <input type="hidden" name="name" id="name" value="<?php echo $infoPlayer['pseudo']; ?>" />
                    <input type="text" name="message" id="message" maxlength="80" class="form-control" placeholder="Message">
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default" type="button">Envoyer</button>
                    </span>
                </div>
            </form>
        </div>

    </body>
</html>