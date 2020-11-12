<?php

if (!isset($_REQUEST["numeroJ1"])) {
    $numeroJ1 = false;
} else {
    $numeroJ1 = $_REQUEST["numeroJ1"];
}
if (!isset($_REQUEST["intentos"])) {
    $intentos = false;
} else {
    $intentos = $_REQUEST["intentos"];
}

if (!isset($_REQUEST["numeroJ2"])) {
    $numeroJ2 = false;
} else {
    $numeroJ2 = $_REQUEST["numeroJ2"];
}

if (!isset($_REQUEST["contador"])) {
    $contador = 0;
} else {
    $contador = $_REQUEST["contador"];
    $contador=$contador+1;
}

if (!isset($_REQUEST["recordIntentos"])) {
    $recordIntentos = 0;
} else {
    $recordIntentos = $_REQUEST["recordIntentos"];
}
//echo $contador;
?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>
<?php
    if(!$numeroJ2){
        $mostrar=false;
    }else if($contador<=$intentos){
        if($numeroJ1<$numeroJ2) {
            echo "<p> El numero es menor </p>";
            $mostrar=false;
        }else if ($numeroJ1>$numeroJ2) {
            echo "<p> El numero es mayor </p>";
            $mostrar=false;
        }else if($numeroJ1 == $numeroJ2){
            echo "<p> El numero es '$numeroJ1' y se ha tardado '$contador' intentos</p>";
            $mostrar=true;
            if($recordIntentos>=$contador ||$recordIntentos == 0) {
                $recordIntentos = $contador;
                echo "<p> Has conseguido el record de intentos</p>";
            }
        }
    }else{
        $mostrar=true;
        echo '<p>Se han acabado los intentos, tenias <?=$intentos?></p>';
    }

    if(!$mostrar){
        ?>
        <form action='' method='get'>
                <p> Intento: <?=$contador?>/<?=$intentos?></p>
                <input type='number' name='numeroJ2' />
                <input type='submit' name='boton' value="Enviar" />
                <input type='hidden' name='numeroJ1' value="<?=$numeroJ1?>"/>
                <input type='hidden' name='contador' value="<?=$contador?>"/>
                <input type='hidden' name='intentos' value="<?=$intentos?>"/>
                <input type='hidden' name='recordIntentos' value="<?=$recordIntentos?>"/>
            </form>
<?php
    }
?>
<form action='AdivinaNumero.php' method='get'>
    <input type='submit' name='boton' value="Reiniciar" />
    <input type='text' name='recordIntentos' style="visibility:hidden" value="<?=$recordIntentos?>"/>
</form>

</body>
</html>