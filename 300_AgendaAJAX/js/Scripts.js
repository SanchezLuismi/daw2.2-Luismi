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

            cargaRequest(this.response);
        }

    };

    req.open("GET","CategoriaObtenerTodas.php",true);
    req.send();
}

function cargaRequest(xml){

    var tablaCategorias = document.getElementById("tablaCategorias");
    var datos = document.getElementById("datos");

    var objeto = JSON.parse(xml);
    var tamano=objeto.length

    for(var i=0;i<tamano;i++){
        var hilera = document.createElement("tr");
        var celda = document.createElement("td");
        var enlace = document.createElement("a");
        enlace.setAttribute("href","CategoriaFicha.php?id=" +objeto[i].id);
        var textoCelda=document.createTextNode(objeto[i].nombre);

        enlace.appendChild(textoCelda);
        celda.appendChild(enlace);
        hilera.appendChild(celda);
        datos.appendChild(hilera);

    }
    tablaCategorias.appendChild(datos);
}