window.onload = inicializar;

var divCategoriasDatos;
var divPersonaDatos;
var inputCategoriaNombre;
var inputPersonaNombre;
var inputPersonaApellido;
var inputPersonaTelefono;
var inputPersonaCategoria;
var inputPersonaEstrella;



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
    divPersonaDatos = document.getElementById("personasDatos");
    inputCategoriaNombre = document.getElementById("categoriaNombre");
    inputPersonaNombre = document.getElementById("personaNombre");
    inputPersonaApellido =document.getElementById("personaApellido");
    inputPersonaTelefono = document.getElementById("personaTelefono");
    inputPersonaCategoria = document.getElementById("personaCategoria");
    inputPersonaEstrella = document.getElementById("personaEstrella");

    document.getElementById('btnCategoriaCrear').addEventListener('click', clickCategoriaCrear);
    document.getElementById('btnPersonasCrear').addEventListener('click', clickPersonaCrear);

    llamadaAjax("CategoriaObtenerTodas.php", "",
        function(texto) {
            var categorias = JSON.parse(texto);

            for (var i=0; i<categorias.length; i++) {
                // No se fuerza la ordenación, ya que PHP nos habrá dado los elementos en orden correcto y sería una pérdida de tiempo.
                domCategoriaInsertar(categorias[i], false);
            }
        }
    );
    llamadaAjax("PersonaListado.php", "",
        function(texto) {
            var personas = JSON.parse(texto);

            for (var i=0; i<personas.length; i++) {
                // No se fuerza la ordenación, ya que PHP nos habrá dado los elementos en orden correcto y sería una pérdida de tiempo.
                domPersonaInsertar(personas[i], false);
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

function clickPersonaCrear() {
    inputPersonaNombre.disabled = true;
    inputPersonaApellido.disabled = true;
    inputPersonaCategoria.disabled = true;
    inputPersonaTelefono.disabled = true;
    inputPersonaEstrella.disabled = true;


    var id=-1;

    var estrella=0;
    if(inputPersonaEstrella.checked() == true){
        estrella = 1;
    }

    let persona = { "id":  id, "nombre": inputPersonaNombre.value,"apellido": inputPersonaApellido.value,
        "telefono": inputPersonaTelefono.value,"categoria": inputPersonaCategoria.value,"estrella": estrella};

    // TODO Pasar un objeto JSON stringifizado, con id=-1 o algo así.
    llamadaAjax("PersonaCrear.php", objetoAParametrosParaRequest(persona),
        function(texto) {
            // Se re-crean los datos por si han modificado/normalizado algún valor en el servidor.
            var persona = JSON.parse(texto);

            // Se fuerza la ordenación, ya que este elemento podría no quedar ordenado si se pone al final.
            domPersonaInsertar(categoria, true);

            inputPersonaNombre.value = "";
            inputPersonaNombre.disabled = false;

            inputPersonaApellido.value = "";
            inputPersonaApellido.disabled = false;

            inputPersonaTelefono.value = "";
            inputPersonaTelefono.disabled = false;

            inputPersonaCategoria.value = "";
            inputPersonaCategoria.disabled = false;

            inputPersonaEstrella.value = "";
            inputPersonaEstrella.disabled = false;
        },
        function(texto) {
            alert("Error Ajax al crear: " + texto);
            inputPersonaNombre.disabled = false;
            inputPersonaApellido.disabled = false;
            inputPersonaTelefono.disabled = false;
            inputPersonaCategoria.disabled = false;
            inputPersonaEstrella.disabled = false;
        }
    );
}

function blurPersonaModificar(input) {
    let divPersona = input.parentElement.parentElement;
    let id = extraerId(divPersona.id);
    let divEstrella = divPersona.children[0];
    let inputEstrella = divEstrella.children[0];

    let divNombre = divPersona.children[1];
    let inputNombre = divNombre.children[0];

    let divApellido = divPersona.children[2];
    let inputApellido = divApellido.children[0];

    let divTelefono = divPersona.children[3];
    let inputTelefono = divTelefono.children[0];

    let divCategoria = divPersona.children[4];
    let inputCategoria = divCategoria.children[0];


    let personaMod = { "id":  id, "nombre": inputNombre.value,"apellido": inputApellido.value,
        "telefono": inputTelefono.value,"categoria": inputCategoria.value,"estrella": inputEstrella.value};

    llamadaAjax("PersonaModificar.php", objetoAParametrosParaRequest(personaMod),
        function(texto) {
            if (texto != "null") {
                // Se re-crean los datos por si han modificado/normalizado algún valor en el servidor.
                persona = JSON.parse(texto);
                domPersonaModificar(persona);
            } else {
                alert("Error Ajax al modificar: " + texto);
            }
        },
        function(texto) {
            alert("Error Ajax al modificar: " + texto);
        }
    );
}

function clickPersonaEliminar(id) {
    llamadaAjax("PersonaEliminar.php", "id="+id,
        function(texto) {
            var categoria = JSON.parse(texto);
            domPersonaEliminar(id);
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

//Persona
function domPersonaCrearDiv(persona){
    /*let estrellaImg = document.createElement("img");
    if(persona.estrella == 1){
        estrellaImg.setAttribute("src", "img/EstrellaRellena.png");
    }else{
        estrellaImg.setAttribute("src", "img/EstrellaVacia.png");
    }
    //eliminarImg.setAttribute("onclick", "clickCategoriaEliminar(" + categoria.id + "); return false;");
    let estrellaDiv = document.createElement("div");
    estrellaDiv.appendChild(estrellaImg);*/

    let estrellaImg = document.createElement("input");
    estrellaImg.setAttribute("type", "text");
    estrellaImg.setAttribute("value", persona.estrella);
    let estrellaDiv = document.createElement("div");
    estrellaDiv.appendChild(estrellaImg);

    let nombreInput = document.createElement("input");
    nombreInput.setAttribute("type", "text");
    nombreInput.setAttribute("value", persona.nombre);
    nombreInput.setAttribute("onblur", "blurPersonaModificar(this); return false;");
    let nombreDiv = document.createElement("div");
    nombreDiv.appendChild(nombreInput);

    let apellidosInput = document.createElement("input");
    apellidosInput.setAttribute("type", "text");
    apellidosInput.setAttribute("value", persona.apellido);
    apellidosInput.setAttribute("onblur", "blurPersonaModificar(this); return false;");
    let apellidosDiv = document.createElement("div");
    apellidosDiv.appendChild(apellidosInput);

    let telefonoInput = document.createElement("input");
    telefonoInput.setAttribute("type", "text");
    telefonoInput.setAttribute("value", persona.telefono);
    telefonoInput.setAttribute("onblur", "blurPersonaModificar(this); return false;");
    let telefonoDiv = document.createElement("div");
    telefonoDiv.appendChild(telefonoInput);

    let categoriaInput = document.createElement("input");
    categoriaInput.setAttribute("type", "text");
    categoriaInput.setAttribute("value", persona.categoriaId);
    categoriaInput.setAttribute("onblur", "blurPersonaModificar(this); return false;");
    let categoriaDiv = document.createElement("div");
    categoriaDiv.appendChild(categoriaInput);

    let eliminarImg = document.createElement("img");
    eliminarImg.setAttribute("src", "img/Eliminar.png");
    eliminarImg.setAttribute("onclick", "clickPersonaEliminar(" + persona.id + "); return false;");
    let eliminarDiv = document.createElement("div");
    eliminarDiv.appendChild(eliminarImg);

    let divPersona = document.createElement("div");
    divPersona.setAttribute("id", "persona-" + persona.id);
    divPersona.appendChild(estrellaDiv);
    divPersona.appendChild(nombreDiv);
    divPersona.appendChild(apellidosDiv);
    divPersona.appendChild(telefonoDiv);
    divPersona.appendChild(categoriaDiv);
    divPersona.appendChild(eliminarDiv);

    return divPersona;
}

function domPersonaObtenerDiv(pos) {
    let div = divPersonaDatos.children[pos];
    return div;
}

function domPersonaObtenerObjeto(pos) {
    let divPersona = domPersonaObtenerDiv(pos);

    let divEstrella = divPersona.children[0];
    let inputEstrella = divEstrella.children[0];

    let divNombre = divPersona.children[1];
    let inputNombre = divNombre.children[0];

    let divApellido = divPersona.children[2];
    let inputApellido = divApellido.children[0];

    let divTelefono = divPersona.children[3];
    let inputTelefono = divTelefono.children[0];

    let divCategoria = divPersona.children[4];
    let inputCategoria = divCategoria.children[0];


    return { "id":  extraerId(divCategoria.id), "nombre": inputNombre.value, "apellido": inputApellido.value,
        "telefono": inputTelefono.value,"categoria": inputCategoria.value,"estrella": inputEstrella.value}; // Devolvemos un objeto recién creado con los datos que hemos obtenido.
}

function domPersonaEjecutarInsercion(pos, persona) {
    let divReferencia = domPersonaObtenerDiv(pos);
    let divNuevo = domPersonaCrearDiv(persona);

    divPersonaDatos.insertBefore(divNuevo, divReferencia);
}

function domPersonaInsertar(personaNueva, enOrden=false) {
    // Si piden insertar en orden, se buscará su lugar. Si no, irá al final.
    if (enOrden) {
        for (let pos = 0; pos < divPersonaDatos.children.length; pos++) {
            let personaActual = domPersonaObtenerObjeto(pos);

            let cadenaActual = personaActual.nombre + personaActual.apellidos;
            let cadenaNueva = personaNueva.nombre + personaNueva.apellidos;

            if (cadenaNueva.localeCompare(cadenaActual) == -1) {
                // Si la categoría nueva va ANTES que la actual, este es el punto en el que insertarla.
                domPersonaEjecutarInsercion(pos, personaNueva);
                return;
            }
        }
    }

    domPersonaEjecutarInsercion(divPersonaDatos.children.length, personaNueva);
}

function domPersonaLocalizarPosicion(id) {
    var trs = divPersonaDatos.children;

    for (var pos=0; pos < divPersonaDatos.children.length; pos++) {
        let personaActual = domPersonaObtenerObjeto(pos);

        if (personaActual.id == id) return (pos);
    }

    return -1;
}

function domPersonaEliminar(id) {
    domPersonaObtenerDiv(domPersonaLocalizarPosicion(id)).remove();
}

function domPersonaModificar(persona) {
    domPersonaEliminar(persona.id);

    // Se fuerza la ordenación, ya que este elemento podría no quedar ordenado si se pone al final.
    domPersonaInsertar(persona, true);
}