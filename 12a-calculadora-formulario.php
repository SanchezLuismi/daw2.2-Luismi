<?php

?>

<html>

<head>
    <meta charset='UTF-8'>
</head>

<body>

<form action='12b-calculadora-resultado.php' method='get'>
   <p>Introduce el primer operando: <input type='number' name='operando1' /></p>
   <p>Elige la operacion: <select name="operacion">
        <option value="sum">Suma</option>
        <option value="res">Resta</option>
        <option value="mul">Multiplicacion</option>
        <option value="div">Division</option>
    </select></p>
    <p>Introduce el segundo operando: <input type='number' name='operando2' /></p>
    <input type='submit' name='boton' value="Enviar" />
</form>



</body>

</html>
