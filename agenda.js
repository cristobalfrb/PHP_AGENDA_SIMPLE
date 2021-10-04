const tablaContactos = document.getElementById('tabla_contactos');
const btnNuevo = document.getElementById('btnNuevo')
const btnForm = document.getElementById('btnAgregar');
const idHidden = document.getElementById('idHidden');

let nombre = document.getElementById('nombre');
let telefono = document.getElementById('telefono');
let email = document.getElementById('email');
let direccion = document.getElementById('direccion');

function init() {

    tablaContactos.addEventListener('click', (e) => {
        let id = e.target.id.split(':');
        if (e.target.tagName == 'BUTTON' && id[0] == 'edit') {
            editarContacto(e, id[1]);
        }
    });

    btnNuevo.addEventListener('click', () => limpiarModal())

}

async function editarContacto(e, id) {
    btnForm.setAttribute('name', 'editar');
    idHidden.value = id;
    // Traer los datos del contacto

    let response = await fetch('./obtener.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            id: id
        }),
    })

    let datos = await response.json();

    nombre.value = datos[0].nombre;
    telefono.value = datos[0].telefono;
    email.value = datos[0].correo;
    direccion.value = datos[0].direccion;

}

function limpiarModal() {
    btnForm.setAttribute('name', 'agregar');
    idHidden.value = '';
    nombre.value = '';
    telefono.value = '';
    email.value = '';
    direccion.value = '';
}



init();