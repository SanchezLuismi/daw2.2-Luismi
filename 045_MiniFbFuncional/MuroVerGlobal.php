<?php

    require_once "_com/DAO.php";
    require_once "_com/Varios.php";

    // Comprobamos si hay sesión-usuario iniciada.
    //   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
    //     (Mostrar info del usuario logueado y tal...)
    //   - Si NO la hay, redirigimos a SesionInicioFormulario.php

    if (!haySesionRamIniciada() && !intentarCanjearSesionCookie()) {
        redireccionar("SesionInicioFormulario.php");
    }

$publicaciones=DAO::publicacionObtenerTodas();
    print_r($publicaciones);

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php pintarInfoSesion(); ?>

<h1>Muro global</h1>

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
            <td><a href="MuroVerDe.php?id=<?=$publicacion->getEmisorId()?>"> <?=$publicacion->getEmisorId();?> </a></td>
            <td><a href="MuroVerDe.php?id=<?=$publicacion->getId()?>"><?=$publicacion->getDestinatarioId();?></td>
            <td><?=$publicacion->getAsunto();?></td>
            <td><?=$publicacion->getContenido();?></td>
        </tr>
    <?php } ?>

</table>
<a href='MuroVerDe.php'>Ir a mi muro.</a>

</body>

</html>