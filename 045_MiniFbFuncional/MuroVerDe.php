<?php

    require_once "_com/DAO.php";

    // Comprobamos si hay sesión-usuario iniciada.
    //   - Si la hay, no intervenimos. Dejamos que la pág se cargue.
    //     (Mostrar info del usuario logueado y tal...)
    //   - Si NO la hay, redirigimos a SesionInicioFormulario.php

    if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) {
        redireccionar("SesionInicioFormulario.php");
    }

    if(isset($_REQUEST["id"])){
         $id = $_REQUEST["id"];
    }else{
        $id = $_SESSION["id"];
    }

    $usuario = DAO::obtenerUsuarioPorId($id);
    $publicaciones=DAO::publicacionObtenerPorDestinatarioId($usuario->getId());
  //  print_r($publicaciones);
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php DAO::pintarInfoSesion(); ?>

<h1>Muro de <?=$usuario->getNombre()?> <?=$usuario->getApellidos()?></h1>

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
    <label>Mensaje para <?=$usuario->getNombre()?> <?=$usuario->getApellidos()?></label><br />
    <label><strong>Asunto: </strong></label>
    <input type='text' name='asunto' value=''><br />
    <label><strong>Contenido: </strong></label>
    <textarea name="contenido" rows="10" cols="50"></textarea><br />
    <input type='text' name='destinatario' value='<?=$usuario->getId()?>' hidden><br>
    <input type='submit' value='Crear publicacion'>
</form>

<a href='Index.php'>Ir al pagina principal</a>

<a href='MuroVerGlobal.php'>Ir al muro global</a>

</body>

</html>