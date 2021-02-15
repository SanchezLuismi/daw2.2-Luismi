window.onload = inicializaciones;
var tablaCategorias;


function inicializaciones() {
    tablaCategorias = document.getElementById("tablaCategorias");
    document.getElementById("submitCrearCategoria").addEventListener("click",crearCategoria);
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
   // var datos = document.getElementById("datos");

    var objeto = JSON.parse(xml);
    var tamano=objeto.length


    for(var i=0;i<tamano;i++){
        var tr = document.createElement("tr");
        var td = document.createElement("td");
        //var a = document.createElement("a");
        //a.setAttribute("href","CategoriaFicha.php?id=" + objeto[i].id);
        var textoContenido = document.createTextNode(objeto[i].nombre);

        var tdBorrado = document.createElement("td");
        var boton = document.createElement("input");
        boton.setAttribute("type", "button");
        boton.setAttribute("id", "btnBorrar"+objeto[i].id);

// editButton.setAttribute('onClick', editSection('id'))
        //boton.addEventListener('click', borrarCategoria(objeto[i]), true);
        boton.setAttribute("value", "X")

        //a.appendChild(textoContenido);
        td.appendChild(textoContenido);

        tdBorrado.appendChild(boton);

        tr.appendChild(td);
        tr.appendChild(tdBorrado);
        tablaCategorias.appendChild(tr);
    }
    //tablaCategorias.appendChild(datos);
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
            nodo = lista[i];
        }

    }

    var tr = document.createElement("tr");
    var td = document.createElement("td");
   // var a = document.createElement("a");
    //a.setAttribute("href","CategoriaFicha.php?id=" + categoria.id);
    var textoContenido = document.createTextNode(categoria.nombre);

    var tdBorrado = document.createElement("td");
    var boton = document.createElement("button");
    //boton.onclick=borrarCategoria(objeto[i]);
    var textoBorrado = document.createTextNode("X");

    td.appendChild(textoContenido);
    //td.appendChild(a);

    boton.appendChild(textoBorrado);
    tdBorrado.appendChild(boton);

    tr.appendChild(td);
    tr.appendChild(tdBorrado);

    if(nodo){
        container.insertBefore(tr, nodo);
        tablaCategorias.appendChild(tr);
    }else{
        tablaCategorias.appendChild(tr);
    }

}

function borrarCategoria(obj){

    var req = new XMLHttpRequest();

    req.onreadystatechange = function(){
        if(this.readyState == 4 && this.status == 200){

            borraCategoria(this.response,obj);
        }

    };

    req.open("GET","CategoriaEliminar.php?id="+obj.id,true);
    req.send();
}

function borraCategoria(xml,obj){

    var respuesta = JSON.parse(xml);
    var container = document.querySelector('#tablaCategorias');
    var lista = container.querySelectorAll("tr td");
    var nodo;

   if(respuesta != null){

       for(var i=0;i<lista.length;i++){
           if(lista[i].outerText == obj.nombre){
               lista[i].parentNode.removeChild(lista[i]);
           }
       }

   }else{
       alert("No se ha podido borrar")
   }

}