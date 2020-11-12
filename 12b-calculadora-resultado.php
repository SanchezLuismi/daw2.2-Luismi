<?php

if (!isset($_REQUEST["operando1"])){
    $operando1 = false;
} else{
    $operando1 = $_REQUEST["operando1"];
}

if (!isset($_REQUEST["operando2"])){
    $operando2 = false;
} else{
    $operando2 = $_REQUEST["operando2"];
}

if (!isset($_REQUEST["operacion"])){
    $operacion = false;
} else{
    $operacion = $_REQUEST["operacion"];
}

?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>


<?php
if(!$operando1 && !$operando2  && !$operacion) {
    ?>
    <p>Error. Faltan datos para operar</p>
<?php
}else{
    $resultado=0;
    $errorDivCero=false;
    if($operando1 != null && $operando2 != null) {
        switch ($operacion) {
            case "sum" :
                $resultado = $operando1 + $operando2;
                $operacion = "suma";
                break;
            case "res" :
                $resultado = $operando1 - $operando2;
                $operacion = "resta";
                break;
            case "mul" :
                $resultado = $operando1 * $operando2;
                $operacion = "multiplicacion";
                break;
            case "div" :
                if ($operando2 != 0) {
                    $resultado = $operando1 / $operando2;
                    $operacion = "division";
                } else {
                    $errorDivCero = true;
                }
                break;
        }
    }

    if($errorDivCero != true){
        ?>
        <p>El resultado de la <?=$operacion?> entre <?=$operando1?> y <?=$operando2?> es <?=$resultado?></p>
        <?php
    }else{
        echo '<p> No se puede dividir el operando1 entre el numero 0 </p>';
    }
}
?>



</body>
</html>