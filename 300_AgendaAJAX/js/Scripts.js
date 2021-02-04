window.onload = inicializaciones;

function inicializaciones() {
    cargarTodasLasCategorias();
}

function cargarTodasLasCategorias() {
    // TODO v0.9 Obtener el JSON con UNA categoría.
    // TODO v1.0 Obtener el JSON con un ARRAY de categorías.

    // TODO Adaptar/traducir esto a Javascript/DOM/etc.
    var req = new XMLHttpRequest();

    req.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            cargaXml(this.response);
        }

    };

    req.open("GET","CategoriaObtenerTodas.php",true);
    req.send();
    // <?php foreach ($categorias as $categoria) { ?>
    //     <tr>
    // <td><a href='CategoriaFicha.php?id=<?=$categoria->getId()?>'>    <?=$categoria->getNombre()?> </a></td>
    // <td><a href='CategoriaEliminar.php?id=<?=$categoria->getId()?>'> (X)                            </a></td>
    // </tr>
    // <?php } ?>
}

function cargaXml(xml){

    var datos = document.getElementById("datos");

    var objeto = JSON.parse(xml);
    var array=Object.values(objeto);
    var tamano=array.length

    for(var i=0;i<tamano;i++){
        var hilera = document.createElement("tr");
        var celda = document.createElement("td");
        var textoCelda=document.createTextNode(array[i]);

        celda.appendChild(textoCelda);
        hilera.appendChild(celda);
        datos.appendChild(hilera);

    }

    /*var tamano=xml.getElementsByTagName("CD").length;

    for(var i=-1;i<tamano;i++){
        var hilera = document.createElement("tr");
        var nodo;

        if(i== -1){
            nodo=xml.getElementsByTagName("CD")[1].childNodes;
            for(var j=1;j<nodo.length;j=j+2){

                var celda = document.createElement("td");
                var textoCelda=document.createTextNode(nodo[j].localName);
                celda.appendChild(textoCelda);
                hilera.appendChild(celda);
            }
        }else{
            nodo=xml.getElementsByTagName("CD")[i].childNodes;
            for(var j=1;j<nodo.length;j=j+2){

                var celda = document.createElement("td");
                var textoCelda=document.createTextNode(nodo[j].textContent);
                celda.appendChild(textoCelda);
                hilera.appendChild(celda);

            }
        }


        tblBody.appendChild(hilera);
    }
    tabla.appendChild(tblBody);
    body.appendChild(tabla);
    tabla.setAttribute("border", "2");*/

}