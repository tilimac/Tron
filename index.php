<?php


if(isset($_POST['pseudo'])){
    $color = ($_POST['color'] == "rand") ? array_rand(array(0,1,2,3,4,5,6)) : $_POST['color'];
    $infoPlayer = array("pseudo"=>$_POST['pseudo'],"color"=>$color);
    require_once './Controller/gameController.php';
}
else {
    require_once './Controller/connectController.php';
}