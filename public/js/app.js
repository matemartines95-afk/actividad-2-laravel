function mostrarMensaje(elemento, tipo, mensaje) {
    elemento.replaceChildren();
    const alerta = document.createElement('div');
    alerta.className = `alert alert-${tipo}`;
    alerta.textContent = mensaje;
    elemento.appendChild(alerta);
}

async function enviarFormulario(formulario, salida, opciones = {}) {
    const boton = formulario.querySelector('button[type="submit"]');
    boton.disabled = true;

    try {
        const respuesta = await fetch(formulario.action, {
            method: 'POST',
            body: new FormData(formulario),
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });

        const datos = await respuesta.json();

        if (!respuesta.ok) {
            const mensajes = datos.errors ? Object.values(datos.errors).flat() : [];
            throw new Error(mensajes.join(' ') || datos.message || 'No se pudo completar la solicitud.');
        }

        mostrarMensaje(salida, 'success', datos.mensaje || 'Operación realizada correctamente.');

        if (datos.redirect) {
            window.location.assign(datos.redirect);
            return;
        }

        if (datos.usuario && formulario.id === 'formPerfil') {
            document.getElementById('name').value = datos.usuario.name;
            document.getElementById('edad').value = datos.usuario.edad;
        }

        if (opciones.reset) formulario.reset();
    } catch (error) {
        mostrarMensaje(salida, 'danger', error.message || 'Error de comunicación con el servidor.');
    } finally {
        boton.disabled = false;
    }
}

const formRegistro = document.getElementById('formRegistro');
if (formRegistro) {
    formRegistro.addEventListener('submit', event => {
        event.preventDefault();
        enviarFormulario(formRegistro, document.getElementById('resultado'));
    });
}

const formLogin = document.getElementById('formLogin');
if (formLogin) {
    formLogin.addEventListener('submit', event => {
        event.preventDefault();
        enviarFormulario(formLogin, document.getElementById('resultadoLogin'));
    });
}

const formPerfil = document.getElementById('formPerfil');
if (formPerfil) {
    formPerfil.addEventListener('submit', event => {
        event.preventDefault();
        enviarFormulario(formPerfil, document.getElementById('resultadoPerfil'));
    });
}
