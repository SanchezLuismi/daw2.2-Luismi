/*window.onload = inicializaciones;
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

}*/
window.onload = inicializar;

var divCategoriasDatos;
var inputCategoriaNombre;



// ---------- VARIOS DE BASE/UTILIDADES ----------

function notificarUsuario(texto) {
    // TODO En lugar del alert, habría que añadir una línea en una zona de notificaciones, arriba, con un temporizador para que se borre solo en ¿5? segundos.
    alert(texto);
}

function llamadaAjax(url, parametros, manejadorOK, manejadorError) {
    //TODO PARA DEPURACIÓN: alert("Haciendo ajax a " + url + "\nCon parámetros " + parametros);

    var request = new XMLHttpRequest();

    request.open("POST", url);
    request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    request.onreadystatechange = function() {
        if (this.readyState == 4 && request.status == 200) {
            manejadorOK(request.responseText);
        }
        if (manejadorError != null && request.readyState == 4 && this.status != 200) {
            manejadorError(request.responseText);
        }
    };

    request.send(parametros);
}

function extraerId(texto) {
    return texto.split('-')[1];
}

function objetoAParametrosParaRequest(objeto) {
    // Esto convierte un objeto JS en un listado de clave1=valor1&clave2=valor2&clave3=valor3
    return new URLSearchParams(objeto).toString();
}

// ---------- MANEJADORES DE EVENTOS / COMUNICACIÓN CON PHP ----------

function inicializar() {
    divCategoriasDatos = document.getElementById("categoriasDatos");
    inputCategoriaNombre = document.getElementById("categoriaNombre");

    document.getElementById('btnCategoriaCrear').addEventListener('click', clickCategoriaCrear);

    llamadaAjax("CategoriaObtenerTodas.php", "",
        function(texto) {
            var categorias = JSON.parse(texto);

            for (var i=0; i<categorias.length; i++) {
                // No se fuerza la ordenación, ya que PHP nos habrá dado los elementos en orden correcto y sería una pérdida de tiempo.
                domCategoriaInsertar(categorias[i], false);
            }
        }
    );
}

function clickCategoriaCrear() {
    inputCategoriaNombre.disabled = true;

    // TODO Pasar un objeto JSON stringifizado, con id=-1 o algo así.
    llamadaAjax("CategoriaCrear.php", "nombre=" + inputCategoriaNombre.value,
        function(texto) {
            // Se re-crean los datos por si han modificado/normalizado algún valor en el servidor.
            var categoria = JSON.parse(texto);

            // Se fuerza la ordenación, ya que este elemento podría no quedar ordenado si se pone al final.
            domCategoriaInsertar(categoria, true);

            inputCategoriaNombre.value = "";
            inputCategoriaNombre.disabled = false;
        },
        function(texto) {
            alert("Error Ajax al crear: " + texto);
            inputCategoriaNombre.disabled = false;
        }
    );
}

function blurCategoriaModificar(input) {
    let divCategoria = input.parentElement.parentElement;
    let id = extraerId(divCategoria.id)
    let nombre = input.value;

    let categoria = { "id":  id, "nombre": nombre};

    llamadaAjax("CategoriaActualizar.php", objetoAParametrosParaRequest(categoria),
        function(texto) {
            if (texto != "null") {
                // Se re-crean los datos por si han modificado/normalizado algún valor en el servidor.
                categoria = JSON.parse(texto);
                domCategoriaModificar(categoria);
            } else {
                alert("Error Ajax al modificar: " + texto);
            }
        },
        function(texto) {
            alert("Error Ajax al modificar: " + texto);
        }
    );
}

function clickCategoriaEliminar(id) {
    llamadaAjax("CategoriaEliminar.php", "id="+id,
        function(texto) {
            var categoria = JSON.parse(texto);
            domCategoriaEliminar(id);
        },
        function(texto) {
            alert("Error Ajax al eliminar: " + texto);
        }
    );
}

// ---------- GESTIÓN DEL DOM ----------

function domCategoriaCrearDiv(categoria) {
    let nombreInput = document.createElement("input");
    nombreInput.setAttribute("type", "text");
    nombreInput.setAttribute("value", categoria.nombre);
    nombreInput.setAttribute("onblur", "blurCategoriaModificar(this); return false;");
    let nombreDiv = document.createElement("div");
    nombreDiv.appendChild(nombreInput);

    let eliminarImg = document.createElement("img");
    eliminarImg.setAttribute("src", "img/Eliminar.png");
    eliminarImg.setAttribute("onclick", "clickCategoriaEliminar(" + categoria.id + "); return false;");
    let eliminarDiv = document.createElement("div");
    eliminarDiv.appendChild(eliminarImg);

    let divCategoria = document.createElement("div");
    divCategoria.setAttribute("id", "categoria-" + categoria.id);
    divCategoria.appendChild(nombreDiv);
    divCategoria.appendChild(eliminarDiv);

    return divCategoria;
}

function domCategoriaObtenerDiv(pos) {
    let div = divCategoriasDatos.children[pos];
    return div;
}

function domCategoriaObtenerObjeto(pos) {
    let divCategoria = domCategoriaObtenerDiv(pos);
    let divNombre = divCategoria.children[0];
    let input = divNombre.children[0];

    return { "id":  extraerId(divCategoria.id), "nombre": input.value}; // Devolvemos un objeto recién creado con los datos que hemos obtenido.
}

function domCategoriaEjecutarInsercion(pos, categoria) {
    let divReferencia = domCategoriaObtenerDiv(pos);
    let divNuevo = domCategoriaCrearDiv(categoria);

    divCategoriasDatos.insertBefore(divNuevo, divReferencia);
}

function domCategoriaInsertar(categoriaNueva, enOrden=false) {
    // Si piden insertar en orden, se buscará su lugar. Si no, irá al final.
    if (enOrden) {
        for (let pos = 0; pos < divCategoriasDatos.children.length; pos++) {
            let categoriaActual = domCategoriaObtenerObjeto(pos);

            if (categoriaNueva.nombre.localeCompare(categoriaActual.nombre) == -1) {
                // Si la categoría nueva va ANTES que la actual, este es el punto en el que insertarla.
                domCategoriaEjecutarInsercion(pos, categoriaNueva);
                return;
            }
        }
    }

    domCategoriaEjecutarInsercion(divCategoriasDatos.children.length, categoriaNueva);
}

function domCategoriaLocalizarPosicion(id) {
    var trs = divCategoriasDatos.children;

    for (var pos=0; pos < divCategoriasDatos.children.length; pos++) {
        let categoriaActual = domCategoriaObtenerObjeto(pos);

        if (categoriaActual.id == id) return (pos);
    }

    return -1;
}

function domCategoriaEliminar(id) {
    domCategoriaObtenerDiv(domCategoriaLocalizarPosicion(id)).remove();
}

function domCategoriaModificar(categoria) {
    domCategoriaEliminar(categoria.id);

    // Se fuerza la ordenación, ya que este elemento podría no quedar ordenado si se pone al final.
    domCategoriaInsertar(categoria, true);
}