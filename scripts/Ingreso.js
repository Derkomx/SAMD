// Función al pulsar el botón "Iniciar sesión" para ingresar a una cuenta
function InicioSesion() {
    // Se obtienen el CUIL y la clave
    var CUIL = document.getElementById("CUIL").value;
    var Clave = document.getElementById("Clave").value;

    // Si no se escribió un CUIL, se notifica
    if (CUIL.length == 0) {
        Notiflix.Notify.Failure("Debes ingresar un usuario!");
        return;
    }

    // Si no escribió una clave, se notifica
    if (Clave.length == 0) {
        Notiflix.Notify.Failure("Debes ingresar tu clave!");
        return;
    }

    // Activa la pantalla de carga
    Notiflix.Loading.Circle('Cargando...');

    $.ajax({
        type: 'POST',
        url: './Inyector.php',
        data: { Archivo: 'Ingreso.php', CUIL: CUIL, Clave: hex_sha512(Clave) },
        dataType: 'html',
        success: function(data) {
            var Resultado = JSON.parse(data);
            Notiflix.Loading.Remove();

            if (Resultado.error) {
                Notiflix.Notify.Failure(Resultado.error);
                return;
            }

            if (Resultado.inactive) {
                Notiflix.Report.Warning(
                    '¡Cuenta inactiva!',
                    'Para ingresar a esta cuenta, debes activarla mediante el email que recibiste en tu correo electrónico al momento de registrarte. ¿No recibiste el correo? Intenta enviar nuevamente el mensaje.',
                    'Aceptar',
                    function() {
                        location.reload();
                    }
                );

                return;
            }


            if (Resultado.location) {
                // Se borran los datos almacenados si existen
                localStorage.setItem("Recordar", 0);
                localStorage.setItem("CUIL", false);

                // Recordar datos
                if (document.getElementById("Recordar").checked) {
                    // Si está seleccionado "Recordar CUIL", se almacena para usarlo la próxima vez
                    localStorage.setItem("Recordar", 1);
                    localStorage.setItem("CUIL", CUIL);
                }

                location.reload();
                return;
            }

            Notiflix.Notify.Failure("Acaba de ocurrir un error muy raro...");
            return;
        },
        error: function(data) {
            Notiflix.Loading.Remove();

            Notiflix.Notify.Failure("¡No se pudo recibir una respuesta del servidor!");

            console.log(data);
            return;
        }
    });
}



$(document).ready(function() {
    /*Obtener datos almacenados*/
    var Recordar = localStorage.getItem("Recordar");
    var sCUIL = localStorage.getItem("CUIL");

    if (Recordar == 1) {
        document.getElementById("CUIL").value = sCUIL;
        document.getElementById("Recordar").checked = true;
    }

});

function enterKeyPressed(event) {
    if (event.keyCode == 13) {
        InicioSesion();
        return false;
    }
}