<?php
   // print_r($_REQUEST);
    if(isset($_REQUEST["botonIni"])) {
       $numero = 0;
    }elseif (!isset($_REQUEST["numero"])) {
        $numero = 0;
    }else if(isset($_REQUEST["botonInc"])) {
        $numeroSuma=intval($_REQUEST["numeroSuma"]);
        $numero = intval($_REQUEST["numero"])+ intval($_REQUEST["numeroSuma"]);
    }else{
        $numeroSuma=intval($_REQUEST["numeroSuma"]);
        $numero = intval($_REQUEST["numero"])- intval($_REQUEST["numeroSuma"]);
    }

   /* echo "<p> '$ini'  </p>";
    echo "<p> '$numero'  </p>";*/

?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<?php
if (!$numero) {
    ?>
    <form action='' method='get'>
        <h1><?=$numero?></h1>
        <p><input type='text' name='numeroSuma' value="0"/></p>
        <input type='submit' name='botonRest' value="restar" />
        <input type='submit' name='botonInc' value="incrementar" />
        <input type='submit' name='botonIni' value="inicializar" />
        <input type='text' name='numero' value="0" style="visibility: hidden"/>
    </form>

    <?php
} else if($numero) {
    ?>
    <form action='' method='get'>
        <h1><?=$numero?></h1>
        <p> <input type='text' name='numeroSuma' value='<?=$numeroSuma?>'/></p>
        <input type='submit' name='botonRest' value="restar" />
        <input type='submit' name='botonInc' value="incrementar" />
        <input type='submit' name='botonIni' value="inicializar" />
        <input type='text' name='numero' value='<?=$numero?>' style="visibility: hidden">
    </form>
<?php
}
?>

</body>

</html>
