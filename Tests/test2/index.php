<?php
session_start();
if(isset($_POST['pseudo']))
	$_SESSION['pseudo'] = $_POST['pseudo'];
?>


<html>
<head>
<meta charset="utf-8">
<title>Tchat</title>
<link href="style.css" rel="stylesheet" type="text/css" media="all">
<body>
<?php 
if(isset($_POST['pseudo'])){ ?>
	<div id="tchat">
		<div id="receiveMessages">
		</div>
		<div id="sendMessages">
			<input type="text" id="message" /><br />
			<input type="button" value="Send" onClick="send();" />
		</div>
		<div id="connect">
                    <input type="button" name="connect" id="connectButton" value="Connexion" onClick="connect('<?php echo htmlentities($_SESSION['pseudo']); ?>');"/>
		</div>
	</div>

<?php } ?>
	<form action="index.php" method="POST" id="define" />
	<input type="text" name="pseudo" /><br />
	<input type="submit" value="Define" />
</form>

<script src="tchat.js" async ></script>

</body>
</html>




<Directory />
    AllowOverride none
    Require all granted
</Directory>








