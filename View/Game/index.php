<link rel="stylesheet" type="text/css" href="View/Game/Css/general.css?ck=<?php echo time(); ?>">
<script src="View/Game/Js/general.js?ck=<?php echo time(); ?>"></script>
<style>

.character{
    background-position: -<?php echo (array_search($infoPlayer['color'],$arrayColor)*2); ?>00px center; 
    color: #<?php echo $infoPlayer['color']; ?>;
}
</style>
        
        
<input id="name" type="hidden" value="<?php echo $infoPlayer['pseudo']; ?>" />
<input id="color" type="hidden" value="<?php echo $infoPlayer['color']; ?>" />
<input id="type" type="hidden" value="<?php echo $infoServer['type']; ?>" />
<input id="ip" type="hidden" value="<?php echo $infoServer['ip']; ?>" />
<input id="port" type="hidden" value="<?php echo $infoServer['port']; ?>" />
<input id="numPlayer" type="hidden" value="<?php echo $infoServer['port']; ?>" />
<table id="plateau">
    <?php for ($i = 0; $i < 50; $i++) { ?>
        <tr>
            <?php for ($j = 0; $j < 50; $j++) { ?>
                <td></td>
            <?php } ?>
        </tr>
    <?php } ?>
</table>
<div class="character"><?php echo $infoPlayer['pseudo']; ?></div>
<?php if($infoServer['type'] == "newServer"){ ?>
    <div id="commandes" class="btn-group">
        <button id="initGame" class="btn btn-default">Init le jeu</button>
        <button id="startGame" class="btn btn-default">Démarer le jeu</button>
        <button id="stopSrv" class="btn btn-default">Arreter le serveur</button>
    </div>
<?php } ?>
<div class="chat">
    <form id="sendMsg" class="content" method="post">
        <div class="message-box" id="message_box">
        </div>
        <div class="shadow"></div>
        <div class="input-group">
            <input type="text" name="message" id="message" maxlength="80" class="form-control" placeholder="Message">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-default" type="button">Envoyer</button>
            </span>
        </div>
    </form>
</div>

<div id="classement" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Classement</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
