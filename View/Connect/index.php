<link rel="stylesheet" type="text/css" href="View/Connect/Css/general.css">
<script src="View/Connect/Js/general.js"></script>



<form id="connectGame" class="connection form-horizontal" role="form" method="post">
    <?php if(!is_null($errorcode)){ ?>
        <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Erreur !</strong> <?php echo $errormsg; ?>
        </div>
    <?php } ?>
    <div class="form-group">
        <label for="pseudo" class="col-sm-4 control-label">Pseudonyme</label>
        <div class="col-sm-8">
            <input id="pseudo" name="pseudo" type="text" class="form-control" required/>
        </div>
    </div>
    <div class="form-group">
        <label for="color" class="col-sm-4 control-label">Couleur</label>
        <div class="col-sm-8">
            <select id="color" name="color" class="form-control">
                <option value="rand">Aléatoire</option>
                <option value="E26A6A" class="bgRouge">Rouge</option>
                <option value="F8AC0C" class="bgOrange">Orange</option>
                <option value="FBE781" class="bgJaune">Jaune</option>
                <option value="73ECB0" class="bgVert">Vert</option>
                <option value="5CAAD0" class="bgBleu">Bleu</option>
                <option value="8570EB" class="bgViolet">Violet</option>
                <option value="FB89FB" class="bgRose">Rose</option>
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
                <input id="ip4" name="ip[]" type="number" class="form-control" min="0" max="255" maxlength="3" required value="31"/>
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