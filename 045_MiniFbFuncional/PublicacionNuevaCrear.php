<?php

require_once "_com/DAO.php";


if(isset($_REQUEST["destinatario"])){
    $destinatario = $_REQUEST["destinatario"];
}else{
    $destinatario = null;
}


DAO::publicacionCrear(date('Y-m-d H:i:s'),$_SESSION["id"],$destinatario,null,$_REQUEST["asunto"],$_REQUEST["contenido"]);
// TODO ¿Excepciones?

if ($_REQUEST["destinatario"]) {
    redireccionar('MuroVerDe.php?id='.$destinatario);
} else {
    redireccionar("MuroVerGlobal.php");
}

?>