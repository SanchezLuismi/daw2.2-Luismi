window.onload = inicializaciones;ç
var tablaCategorias;


function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    cargarTodasLasCategorias();
    document.getElementById("submitCrearCategoria").addEventListener("click",crearCategoria);
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
   // var datos = document.getElementById("datos");

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
        tablaCategorias.appendChild(hilera);

    }
    //tablaCategorias.appendChild(datos);
}

function crearCategoria(){

    var nombreCat=document.getElementById("nombre").value;
    document.getElementById("nombre").value="";

    var req = new XMLHttpRequest();

    req.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            cargaRequest(this.response);
        }

    };

    req.open("GET","CategoriaGuardar?nombre="+nombreCat,true);
    req.send();

}

