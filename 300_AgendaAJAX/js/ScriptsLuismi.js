window.onload = inicializaciones;
var tablaCategorias;


function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    document.getElementById("submitCrearCategoria").addEventListener("click",crearCategoria);
    cargarTodasLasCategorias();
}

function cargarTodasLasCategorias() {
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
        var tr = document.createElement("tr");
        var td = document.createElement("td");
        td.setAttribute('onclick',"mostrarModificarCategoria("+objeto[i].id+")");
        var textoContenido = document.createTextNode(objeto[i].nombre);

        var tdBorrado = document.createElement("td");
        var boton = document.createElement("input");
        boton.setAttribute("type", "button");
        boton.setAttribute("id", "btnBorrar"+objeto[i].id);

        boton.setAttribute('onclick', "borrarCategoria("+objeto[i].id+")");
        boton.setAttribute("value", "X")

        td.appendChild(textoContenido);
        tdBorrado.appendChild(boton);

        tr.appendChild(td);
        tr.appendChild(tdBorrado);
        tablaCategorias.appendChild(tr);
    }
}

function crearCategoria(){

    var nombreCat=document.getElementById("nombre").value;
    document.getElementById("nombre").value="";

    var req = new XMLHttpRequest();

    req.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            cargaCategoria(this.response);
        }

    };

    req.open("GET","CategoriaCrear.php?nombre="+nombreCat,true);
    req.send();

}

function cargaCategoria(xml){
    var obj = JSON.parse(xml);
    if(obj){
        insertarCategoriaPorPosicion(obj);
    }else{
        alert("Error")
    }
}

function insertarCategoriaPorPosicion(categoria) {

    //var container = document.querySelector('#tablaCategorias');
    var lista = tablaCategorias.querySelectorAll("tr td");
    var nodo;
    var nombre = categoria.nombre.toLowerCase()
    var letraInicial = nombre.substr(0,1);

    for(var i=0;i<lista.length;i=i+2) {
        var nombreLista = lista[i].outerText.toLowerCase()
        var letra = nombreLista.substr(0, 1);
        if (letraInicial < letra) {
            nodo = i;
        }

    }

    var tr = document.createElement("tr");
    var td = document.createElement("td");
    td.setAttribute('onclick',"mostrarModificarCategoria("+categoria.id+")");
    var textoContenido = document.createTextNode(categoria.nombre);

    var tdBorrado = document.createElement("td");
    var boton = document.createElement("button");
    boton.setAttribute('onclick', "borrarCategoria("+categoria.id+")");
    var textoBorrado = document.createTextNode("X");

    td.appendChild(textoContenido);
    boton.appendChild(textoBorrado);
    tdBorrado.appendChild(boton);

    tr.appendChild(td);
    tr.appendChild(tdBorrado);

    if(nodo) {
        lista.insertBefore(tr, lista[i-1]);
        tablaCategorias.appendChild(lista);
    }else{
        tablaCategorias.appendChild(tr);
    }

}

function borrarCategoria(id){

    var req = new XMLHttpRequest();

    req.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            borraCategoria(this.response);
        }

    };

    req.open("GET","CategoriaEliminar.php?id="+id,true);
    req.send();
}

function borraCategoria(xml){

    var respuesta = JSON.parse(xml);

    if(respuesta == 1){
        tablaCategorias.innerHTML="<tr>\n" +
            "        <th>Nombre</th>\n" +
            "    </tr>";
        cargarTodasLasCategorias();
        alert("Categoria eliminada")
    }else{
        alert("Error")
    }

}

function mostrarModificarCategoria(id){

    var div = document.getElementById("modificar");

    var input = document.createElement("input");
    input.setAttribute("id","input"+id);
    var boton = document.createElement("button");
    boton.setAttribute('onclick', "modificarCategoria("+id+")");
    var textoMod = document.createTextNode("Modificar Categoria");

    boton.appendChild(textoMod);
    div.appendChild(input);
    div.appendChild(boton);

}

function modificarCategoria(id){

    var nombre = document.getElementById("input" + id).value;

    var req = new XMLHttpRequest();

    req.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            modificacionCategoria(this.response);
        }

    };

    req.open("GET","CategoriaModificar.php?id="+id+"?nombre="+nombre,true);
    req.send();

}

function modificacionCategoria(xml){

    var respuesta = JSON.parse(xml);

    if(respuesta){
        tablaCategorias.innerHTML="<tr>\n" +
            "        <th>Nombre</th>\n" +
            "    </tr>";
        cargarTodasLasCategorias();
        alert("Categoria modificada")
    }else{
        alert("Error")
    }

}