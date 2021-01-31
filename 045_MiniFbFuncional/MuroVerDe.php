<?php

    require_once "_com/DAO.php";

    // Comprobamos si hay sesión-usuario iniciada.
    //   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
    //     (Mostrar info del usuario logueado y tal...)
    //   - Si NO la hay, redirigimos a SesionInicioFormulario.php

    if (!haySesionRamIniciada() && !intentarCanjearSesionCookie()) {
        redireccionar("SesionInicioFormulario.php");
    }

    if($_REQUEST["identificador"]){
        $identificador=$_REQUEST["identificador"];
    }else{
        $identificador = $_SESSION["identificador"];
    }

    $usuario = DAO::obtenerUsuarioPorIdentificador($identificador);
    $publicaciones=DAO::publicacionObtenerPorEmisorId($usuario->getId());
    print_r($publicaciones);
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php pintarInfoSesion(); ?>

<h1>Muro de <?=$_SESSION["nombre"]?> <?=$_SESSION["apellidos"]?></h1>

<table border='1'>

    <tr>
        <th>Fecha</th>
        <th>Destacada Hasta</th>
        <th>Emisor </th>
        <th>Destinatario</th>
        <th>Asunto</th>
        <th>Contenido</th>
    </tr>
    <?php foreach ($publicaciones as $publicacion) { ?>
        <tr>
            <td><?=$publicacion->getFecha();?></td>
            <td><?=$publicacion->getDestacadaHasta();?></td>
            <td><?php
                $emisor=$publicacion->getEmisorId();
                if($emisor){?>
                    <?=$emisor->getNombre()?> . " " . <?=$emisor->getApellidos()?>
                <?php}else{
                    ?>
                    A TODOS LOS USUARIOS
                <?php}
                ?></td>
            <td><?php
                $destinatario=$publicacion->getDestinatarioId();
                if($destinatario){?>
                    <?=$destinatario->getNombre()?> . " " . <?=$destinatario->getApellidos()?>
                <?php}else{
                    ?>
                    A TODOS LOS USUARIOS
                <?php}
                ?></td>
            <td><?=$publicacion->getAsunto();?></td>
            <td><?=$publicacion->getContenido();?></td>
        </tr>
    <?php } ?>

</table>

<a href='Index.php'>Ir al pagina principal</a>

<a href='MuroVerGlobal.php'>Ir al muro global</a>

</body>

</html>