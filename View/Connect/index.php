<!DOCTYPE html>
<html>
    <head>
        <meta charset='UTF-8' />
        
        
        <link rel="stylesheet" type="text/css" href="Library/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="Header/Css/general.css">
        <link rel="stylesheet" type="text/css" href="View/Connect/Css/general.css">
        
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <script src="Library/bootstrap/js/bootstrap.min.js"></script>
        <script src="View/Connect/Js/general.js"></script>
    </head>
    <body>
        <form id="connectGame" class="connection form-horizontal" role="form" method="post">
            <?php if(!is_null($errorcode)){ ?>
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Erreur !</strong> [<?php echo $errorcode; ?>] <?php echo $errormsg; ?>
                </div>
            <?php } ?>
            <div class="form-group">
                <label for="pseudo" class="col-sm-4 control-label">Pseudonyme</label>
                <div class="col-sm-8">
                    <input id="pseudo" name="pseudo" type="text" class="form-control" required />
                </div>
            </div>
            <div class="form-group">
                <label for="color" class="col-sm-4 control-label">Couleur</label>
                <div class="col-sm-8">
                    <select id="color" name="color" class="form-control">
                        <option value="rand">Aléatoire</option>
                        <option value="0" class="bgRouge">Rouge</option>
                        <option value="2" class="bgOrange">Orange</option>
                        <option value="1" class="bgJaune">Jaune</option>
                        <option value="3" class="bgVert">Vert</option>
                        <option value="4" class="bgBleu">Bleu</option>
                        <option value="5" class="bgViolet">Violet</option>
                        <option value="6" class="bgRose">Rose</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="server" class="col-sm-4 control-label">Serveur</label>
                <div class="col-sm-8">
                    <select id="server" name="server" class="form-control" >
                        <option value="connect">Se connecter</option>
                        <option value="newServer">Nouveau serveur</option>
                    </select>
                </div>
            </div>
            <div id="addrIp" class="form-group">
                <label class="col-sm-4 control-label">Adresse IP</label>
                <div class="col-sm-8">
                    <div class="col-sm-3 no-padding">
                        <input id="ip1" name="ip[]" type="number" class="form-control" min="0" max="255" maxlength="3" required value="192"/>
                    </div>
                    <div class="col-sm-3 no-padding">
                        <input id="ip2" name="ip[]" type="number" class="form-control" min="0" max="255" maxlength="3" required value="168"/>
                    </div>
                    <div class="col-sm-3 no-padding">
                        <input id="ip3" name="ip[]" type="number" class="form-control" min="0" max="255" maxlength="3" required value="0"/>
                    </div>
                    <div class="col-sm-3 no-padding">
                        <input id="ip4" name="ip[]" type="number" class="form-control" min="0" max="255" maxlength="3" required value="104"/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="port" class="col-sm-4 control-label">Port</label>
                <div class="col-sm-3">
                    <input id="port" name="port" type="number" class="form-control" min="0" max="65535" maxlength="5" required value="15650"/>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">Valider</button>
                </div>
            </div>
        </form>
    </body>
</html>