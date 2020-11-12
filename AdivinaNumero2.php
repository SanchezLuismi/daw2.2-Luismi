<?php
//print_r( $_POST);
if (!isset($_REQUEST["numeroJ1"])){
    $numeroJ1 = false;
} else{
    $numeroJ1 = $_REQUEST["numeroJ1"];
}
if (!isset($_REQUEST["intentos"])){
    $intentos = false;
} else{
    $intentos = $_REQUEST["intentos"];
}

if(!isset($_REQUEST["numeroJ2"])){
    $numeroJ2 = false;
}else{
    $numeroJ2 = $_REQUEST["numeroJ2"];
}

if(!isset($_REQUEST["contador"])){
    $contador = 1;
}else{
    $contador = $_REQUEST["contador"];
}

if(!isset($_REQUEST["recordIntentos"])){
    $recordIntentos= 0;
}else{
    $recordIntentos = $_REQUEST["recordIntentos"];
}

/*echo "<p> '$numeroJ1'  </p>";
if(!$numeroJ2){
    echo "<p> NADA  </p>";
}else{
    echo "<p> '$numeroJ2'  </p>";
}

echo "<p> '$intentos'  </p>";*/

?>
<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<?php
    if(!$numeroJ2) {
        echo "<p> Intento: $contador/$intentos</p>";
        ?>
        <p>Jugador 2, introduce un numero</p>
        <form action='' method='get'>
            <input type='number' name='numeroJ2'/>
            <input type='submit' name='boton' value="Enviar" />
            <input type='number' name='numeroJ1' style="visibility: hidden" value="<?=$numeroJ1?>"/>
            <input type='number' name='contador' style="visibility:hidden" value="<?=$contador?>"/>
            <input type='number' name='intentos' style="visibility:hidden" value="<?=$intentos?>"/>
            <input type='number' name='recordIntentos' style="visibility:hidden" value="<?=v?>"/>
        </form>
        <?php
        $contador=intval($contador)+1;
    }else{
        if($contador<=$intentos){


            if($numeroJ1<$numeroJ2) {
                $contador=$contador+1;
                echo "<p> Intento: $contador/$intentos</p>";
                echo "<p> El numero es menor </p>";
                ?>
                <p>Jugador 2, introduce un numero</p>
                <form action='' method='get'>
                    <input type='number' name='numeroJ2' />
                    <input type='submit' name='boton' value="Enviar" />
                    <input type='number' name='numeroJ1' style="visibility: hidden" value="<?=$numeroJ1?>"/>
                    <input type='number' name='contador' style="visibility:hidden" value="<?=$contador?>"/>
                    <input type='number' name='intentos' style="visibility: hidden" value="<?=$intentos?>"/>
                    <input type='number' name='recordIntentos' style="visibility:hidden" value="<?=$recordIntentos?>"/>
                </form>
                <?php
            }else if ($numeroJ1>$numeroJ2) {
                $contador=$contador+1;
                echo "<p> Intento: $contador/$intentos</p>";
                echo "<p> El numero es mayor </p>";
                ?>
                <p>Jugador 2, introduce un numero</p>
                <form action='' method='get'>
                    <input type='number' name='numeroJ2' />
                    <input type='submit' name='boton' value="Enviar" />
                    <input type='number' name='numeroJ1' style="visibility: hidden" value="<?=$numeroJ1?>"/>
                    <input type='number' name='contador' style="visibility:hidden" value="<?=$contador?>"/>
                    <input type='number' name='intentos' style="visibility: hidden" value="<?=$intentos?>"/>
                    <input type='number' name='intentosgana' style="visibility:hidden" value="<?=$recordIntentos?>"/>
                </form>
                <?php
            }else if($numeroJ1 == $numeroJ2){
                echo "<p> El numero es '$numeroJ1' y se ha tardado '$contador' intentos</p>";
                if($recordIntentos>=$contador ||$recordIntentos == 0) {
                    $recordIntentos = $contador;
                    echo "<p> Has conseguido el record de intentos</p>";
                }
            }
        }else{
            ?>
                <p>Se han acabado los intentos, tenias <?=$intentos?></p>
<?php
        }

    }
    ?>
    <form action='AdivinaNumero.php' method='get'>
        <input type='submit' name='boton' value="Reiniciar" />
        <input type='text' name='intentosgana' style="visibility:hidden" value="<?=$recordIntentos?>"/>
    </form>
</body>

</html>