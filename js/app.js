const formularioContactos = document.querySelector("#contacto"),
  listadoContactos = document.querySelector("#listado-contactos tbody");
const inputBuscador = document.querySelector("#buscar");


//Escucha los eventos
eventListeners();
function eventListeners() {
  if (numeroContactos()) {
    numeroContactos();
  }

  formularioContactos.addEventListener("submit", leerFormulario);

  if (listadoContactos) {
    listadoContactos.addEventListener("click", eliminarContacto);
  }

  if (inputBuscador) {
    inputBuscador.addEventListener('input', buscarContactos);
  }
}

function buscarContactos(e) {
 
  const expresion = new RegExp(e.target.value, "i"),
    registros = document.querySelectorAll("tbody tr");

  registros.forEach(registro => {

    registro.style.display = 'none';

  
    if (registro.childNodes[1].textContent.replace(/\s/g, " ").search(expresion) != -1) {

      registro.style.display = 'table-row';
    }
    numeroContactos();
  });


}


function numeroContactos() {

  const totalContactos = document.querySelectorAll("tbody tr");
  const contenedorNumeros = document.querySelector(".total-contactos span");
  let total = 0;
  totalContactos.forEach(contacto => {
    if (contacto.style.display == "" || contacto.style.display == "table-row") {
      total++;
    }
  });
  if (contenedorNumeros) {
    contenedorNumeros.textContent = total;
  }



}
function leerFormulario(e) {
  e.preventDefault();

  const nombre = document.querySelector("#nombre").value,
    empresa = document.querySelector("#empresa").value,
    telefono = document.querySelector("#telefono").value,
    accion = document.querySelector("#accion").value;

  if (nombre === "" || empresa === "" || telefono === "") {
    mostrarNotificacion("Se deben rellenar todos los campos", "error");
  } else {

    const infoContacto = new FormData();
    infoContacto.append("nombre", nombre);
    infoContacto.append("empresa", empresa);
    infoContacto.append("telefono", telefono);
    infoContacto.append("accion", accion);

    if (accion === "crear") {
      insertarBD(infoContacto);
      mostrarNotificacion("Se a registrado con exito", "correcto");
      numeroContactos();
    } else {
      const idRegistro = document.querySelector("#id").value;
      infoContacto.append("id", idRegistro);
      actualizarRegistro(infoContacto);
    }

  }
  numeroContactos();
}
function actualizarRegistro(datos) {
  const xhr = new XMLHttpRequest();

  xhr.open("POST", "inc/model/modelo-contactos.php", true);


  xhr.onload = function () {
    if (this.status === 200) {
      const { respuesta } = JSON.parse(xhr.responseText);

      if (respuesta == "correcto") {
        mostrarNotificacion("Contacto Editado Correctamente", "correcto");
        numeroContactos();
      } else {
        mostrarNotificacion("Debe cambiar algun valor para actualizar", "error");
      }

      setTimeout(() => {
        window.location.href = "index.php";
      }, 3000);
    }
  }

  xhr.send(datos);
  numeroContactos();
}
function eliminarContacto(e) {

  const botonBorrarDOM =
    e.target.parentElement.classList.contains("btn-borrar");

  if (botonBorrarDOM) {
    const id = e.target.parentElement.getAttribute("data-id");
    const respuesta = confirm("¿Estas Seguro(a)?");
    if (respuesta) {
      const xhr = new XMLHttpRequest();
      xhr.open(
        "GET",
        `inc/model/modelo-contactos.php?id=${id}&accion=borrar`,
        true
      );

      xhr.onload = function () {
        if (this.status === 200) {

          const resultado = JSON.parse(xhr.responseText);


          const { respuesta } = resultado;

          if (respuesta == "correcto") {

            e.target.parentElement.parentElement.parentElement.remove(); // eliminar un elemento html  
            mostrarNotificacion("Contacto Eliminado", "correcto");
            numeroContactos();
          } else {
            mostrarNotificacion("Hubo un error...", "error");
          }
        }
      };
      xhr.send();
    }


  }

}
function mostrarNotificacion(mensaje, clase) {
  const notificacion = document.createElement("div");
  notificacion.classList.add(clase, "notificacion", "sombra");

  notificacion.textContent = mensaje;

  formularioContactos.insertBefore(
    notificacion,
    document.querySelector("form legend")
  );

  setTimeout(() => {
    notificacion.classList.add("visible");

    setTimeout(() => {
      notificacion.classList.remove("visible");
      setTimeout(() => {
        notificacion.remove();
      }, 500);
    }, 3000);
  }, 100);
}
function insertarBD(datos) {

  const xhr = new XMLHttpRequest();

  xhr.open("POST", "inc/model/modelo-contactos.php", true);

  xhr.onload = function () {
    if (this.status === 200) {
      const respuesta = JSON.parse(xhr.responseText); 
      //destructurar

      const {
        datos: { nombre, empresa, telefono, id_insertado },
      } = respuesta;

      //?nuevo elemento en la tabla
      const nuevoContacto = document.querySelector("tr");

      nuevoContacto.innerHTML = `
           <td>${nombre}</td>
           <td>${empresa}</td>
           <td>${telefono}</td>
           `;

      //? Creando contenedor para los botones
      const contenedorAcciones = document.createElement("td");

      //? icono editar
      const iconoEditar = document.createElement("i");
      iconoEditar.classList.add("fa-solid", "fa-square-pen");
      //? crear enlase para editar

      const btnEditar = document.createElement("a");
      btnEditar.appendChild(iconoEditar);
      btnEditar.href = `editar.php?id=${id_insertado}`;
      btnEditar.classList.add("btn", "btn-editar");

      //?agreganbdo al td -->
      contenedorAcciones.appendChild(btnEditar);

      //!agregando el boton de eliminar
      const iconoEliminar = document.createElement("i");
      iconoEliminar.classList.add("fa-solid", "fa-trash");

      //! crear boton de eliminar

      const btnEliminar = document.createElement("button");
      btnEliminar.appendChild(iconoEliminar);

      //!atributo de html generado
      btnEliminar.setAttribute("data-id", id_insertado);
      btnEliminar.classList.add("btn", "btn-borrar");

      //agrgandolo al padre
      contenedorAcciones.appendChild(btnEliminar);

      //"agregarlo al tr"
      nuevoContacto.appendChild(contenedorAcciones);
      // el tr ya estara comprleto con los cuatro td
      listadoContactos.appendChild(nuevoContacto);

      //!resetear los datos, exite un metodo especial para esto "

      document.querySelector("form").reset();
      //mostrar notificacion
      mostrarNotificacion("Contacto Creado Correctamente", "correcto");
      numeroContactos();
    }
  };


  xhr.send(datos); // Se envia un arreglo de valores distintos mediante el post


}
