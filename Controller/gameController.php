<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$color = ($_POST['color'] == "rand") ? array_rand(array(0,1,2,3,4,5,6)) : $_POST['color'];

$infoPlayer = array("pseudo"=>$_POST['pseudo'],"color"=>$color);
$infoServer = array("type"=>$_POST['server'],"ip"=>$host,"port"=>$port);
$arrayColor = array('E26A6A','FBE781','F8AC0C','73ECB0','5CAAD0','8570EB','B04CB0');

require_once 'View/Game/index.php';