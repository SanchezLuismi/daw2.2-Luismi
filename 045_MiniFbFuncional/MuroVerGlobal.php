<?php

    require_once "_com/DAO.php";
    require_once "_com/Varios.php";

    // Comprobamos si hay sesión-usuario iniciada.
    //   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
    //     (Mostrar info del usuario logueado y tal...)
    //   - Si NO la hay, redirigimos a SesionInicioFormulario.php

    if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) {
        redireccionar("SesionInicioFormulario.php");
    }

$publicaciones=DAO::publicacionObtenerTodas();
   // print_r($publicaciones);

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php DAO::pintarInfoSesion(); ?>

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
            <td><?php
                    if($publicacion->getDestacadaHasta()){?>
                        <?=$publicacion->getDestacadaHasta()?>
                  <?php  }
                ?></td>
            <td><a href="MuroVerDe.php?id=<?=$publicacion->getEmisorId()?>"> <?=DAO::obtenerNombreUsuarioPorId($publicacion->getEmisorId())?> </a></td>
            <td><a href="MuroVerDe.php?id=<?=$publicacion->getDestinatarioId()?>"><?=DAO::obtenerNombreUsuarioPorId($publicacion->getDestinatarioId())?></td>
            <td><?=$publicacion->getAsunto();?></td>
            <td><?=$publicacion->getContenido();?></td>
        </tr>
    <?php } ?>

</table>
<br />
<form action='PublicacionNuevaCrear.php' method='post'>
    <label><strong>Asunto: </strong></label>
    <input type='text' name='asunto' value=''><br />
    <label><strong>Contenido: </strong></label>
    <textarea name="contenido" rows="10" cols="50"></textarea><br />
    <input type='submit' value='Crear publicacion'>
</form>

<br />

<a href='MuroVerDe.php'>Ir a mi muro.</a>

</body>

</html>