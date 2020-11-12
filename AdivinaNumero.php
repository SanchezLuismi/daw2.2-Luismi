<?php
if(!isset($_REQUEST["recordIntentos"])){
    $recordIntentos= 0;
}else{
    $recordIntentos = $_REQUEST["recordIntentos"];
}
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

    <p>Jugador 1, introduce un numero</p>
    <form action='AdivinaNumero3.php' method='get'>
        <input type='number' name='numeroJ1' />
        <p>Introduce el numero de intentos que tiene el jugador 2</p>
        <input type='number' name='intentos' />
        <input type='submit' name='boton' value="Enviar" />
        <input type='number' name='recordIntentos' style="visibility:hidden" value="<?=$recordIntentos?>"/>
    </form>



</body>

</html>